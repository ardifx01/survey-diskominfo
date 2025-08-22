<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Survey;
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
        $maleCount = Survey::byGender('laki_laki')->count();
        $femaleCount = Survey::byGender('perempuan')->count();
        
        // Statistik usia
        $ageStats = Survey::select(
            DB::raw('CASE 
                WHEN usia BETWEEN 15 AND 25 THEN "15-25"
                WHEN usia BETWEEN 26 AND 35 THEN "26-35"
                WHEN usia BETWEEN 36 AND 45 THEN "36-45"
                WHEN usia BETWEEN 46 AND 55 THEN "46-55"
                WHEN usia > 55 THEN "55+"
                END as age_group'),
            DB::raw('COUNT(*) as count')
        )
        ->groupBy('age_group')
        ->get();

        // Data survei dengan paginasi
        $surveys = Survey::latest()->paginate(20);

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

        $surveys = Survey::orderBy('created_at', 'desc')->get();
        
        $csvData = "No,Nama,Jenis Kelamin,Usia,IP Address,User Agent,Tanggal Pengisian\n";
        
        foreach ($surveys as $index => $survey) {
            $csvData .= ($index + 1) . "," . 
                    '"' . str_replace('"', '""', $survey->nama) . '",' . 
                    $survey->jenis_kelamin_label . "," . 
                    $survey->usia . "," . 
                    '"' . $survey->ip_address . '",' . 
                    '"' . str_replace('"', '""', $survey->user_agent) . '",' . 
                    $survey->created_at->format('Y-m-d H:i:s') . "\n";
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
        $survey->delete();

        return redirect()->route('admin.dashboard')->with('success', 'Data survei berhasil dihapus.');
    }
}