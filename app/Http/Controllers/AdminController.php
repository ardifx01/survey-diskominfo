<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function authenticate(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        $admin = AdminUser::where('username', $request->username)->first();

        if ($admin && Hash::check($request->password, $admin->password)) {
            // Set session untuk admin
            session(['admin_id' => $admin->id, 'admin_name' => $admin->name]);
            
            // Update last login
            $admin->update(['last_login_at' => now()]);
            
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors(['login' => 'Username atau password salah.']);
    }

    public function dashboard()
    {
        // Cek apakah admin sudah login
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $totalSurveys = Survey::count();
        
        // Hitung gender berdasarkan responses (menggunakan helper method dari model)
        $surveys = Survey::with(['responses.question'])->get();
        $maleCount = 0;
        $femaleCount = 0;

        foreach ($surveys as $survey) {
            $jenisKelamin = $survey->jenis_kelamin;
            if (strpos($jenisKelamin, 'laki') !== false || strpos($jenisKelamin, 'Laki') !== false) {
                $maleCount++;
            } elseif (strpos($jenisKelamin, 'perempuan') !== false || strpos($jenisKelamin, 'Perempuan') !== false) {
                $femaleCount++;
            }
        }
        
        // Statistik usia berdasarkan responses
        $ageGroups = [
            '15-25' => 0,
            '26-35' => 0,
            '36-45' => 0,
            '46-55' => 0,
            '55+' => 0
        ];

        foreach ($surveys as $survey) {
            $usia = $survey->usia; // Menggunakan accessor
            if ($usia >= 15 && $usia <= 25) {
                $ageGroups['15-25']++;
            } elseif ($usia >= 26 && $usia <= 35) {
                $ageGroups['26-35']++;
            } elseif ($usia >= 36 && $usia <= 45) {
                $ageGroups['36-45']++;
            } elseif ($usia >= 46 && $usia <= 55) {
                $ageGroups['46-55']++;
            } elseif ($usia > 55) {
                $ageGroups['55+']++;
            }
        }

        // Convert to collection format
        $ageStats = collect($ageGroups)->map(function($count, $group) {
            return (object)[
                'age_group' => $group,
                'count' => $count
            ];
        });

        // Data survei dengan paginasi
        $surveys = Survey::with(['responses.question'])->latest()->paginate(20);

        // Statistik per hari dalam 7 hari terakhir
        $dailyStats = Survey::select(
            DB::raw('DATE(created_at) as date'),
            DB::raw('COUNT(*) as count')
        )
        ->where('created_at', '>=', now()->subDays(7))
        ->groupBy('date')
        ->orderBy('date', 'desc')
        ->get();

        return view('admin.dashboard', compact(
            'totalSurveys', 
            'maleCount', 
            'femaleCount', 
            'ageStats', 
            'surveys',
            'dailyStats'
        ));
    }

    public function export()
    {
        // Cek apakah admin sudah login
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $surveys = Survey::with(['responses.question'])->orderBy('created_at', 'desc')->get();
        $questions = SurveyQuestion::active()->ordered()->get();
        
        // Header CSV
        $headers = ['ID', 'Tanggal Pengisian', 'IP Address', 'User Agent'];
        
        // Tambahkan header untuk setiap pertanyaan
        foreach ($questions as $question) {
            $headers[] = $question->question_text;
        }

        $csvData = implode(',', array_map(function($header) {
            return '"' . str_replace('"', '""', $header) . '"';
        }, $headers)) . "\n";
        
        foreach ($surveys as $survey) {
            $row = [
                $survey->id,
                $survey->created_at->format('Y-m-d H:i:s'),
                $survey->ip_address ?: '',
                str_replace('"', '""', $survey->user_agent ?: '')
            ];

            // Tambahkan jawaban untuk setiap pertanyaan
            foreach ($questions as $question) {
                $response = $survey->responses->firstWhere('question_id', $question->id);
                $answer = $response ? $response->answer : '';
                
                // Format khusus untuk file upload
                if ($question->question_type === 'file_upload' && $response && $response->answer_data) {
                    $answer = $response->answer_data['filename'] ?? $answer;
                }
                
                $row[] = str_replace('"', '""', $answer);
            }

            $csvData .= implode(',', array_map(function($field) {
                return '"' . $field . '"';
            }, $row)) . "\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="survei-kepuasan-admin-' . date('Y-m-d') . '.csv"')
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    public function logout()
    {
        session()->forget(['admin_id', 'admin_name']);
        return redirect()->route('admin.login')->with('message', 'Berhasil logout.');
    }

    public function deleteSurvey($id)
    {
        // Cek apakah admin sudah login
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $survey = Survey::findOrFail($id);
        $surveyName = $survey->nama; // Akan menggunakan accessor untuk mendapatkan nama dari response
        $survey->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data survei ' . $surveyName . ' berhasil dihapus.');
    }
}