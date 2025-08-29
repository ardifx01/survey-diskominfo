<?php
// app/Http/Controllers/AdminController.php
namespace App\Http\Controllers;

use App\Models\AdminUser;
use App\Models\Survey;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use App\Models\SurveySection;
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

    public function dashboard(Request $request)
    {
        // Cek apakah admin sudah login
        if (!session('admin_id')) {
            return redirect()->route('admin.login');
        }

        $tab = $request->get('tab', 'questions'); // Default ke tab questions

        // Data dasar yang dibutuhkan semua tab
        $totalSurveys = Survey::count();
        $questions = SurveyQuestion::active()->with(['section', 'responses'])->ordered()->get();
        
        // Data berdasarkan tab yang dipilih
        switch ($tab) {
            case 'individual':
                return $this->getIndividualData($totalSurveys, $questions);
            default: // questions
                return $this->getQuestionsData($totalSurveys, $questions);
        }
    }

    private function getQuestionsData($totalSurveys, $questions)
    {
        // Statistik jawaban per pertanyaan
        $questionStats = [];
        foreach ($questions as $question) {
            // Pastikan hanya menghitung responses dari survey yang masih ada
            $validResponses = $question->responses()->whereHas('survey')->get();
            
            $stats = [
                'question' => $question,
                'total_responses' => $validResponses->count(),
                'response_data' => []
            ];

            if (in_array($question->question_type, ['multiple_choice', 'dropdown'])) {
                // Untuk pilihan ganda dan dropdown
                $responseCounts = $question->responses()
                    ->whereHas('survey')
                    ->select('answer', DB::raw('count(*) as count'))
                    ->groupBy('answer')
                    ->orderBy('count', 'desc')
                    ->get();
                
                $stats['response_data'] = $responseCounts;
                
            } elseif ($question->question_type === 'checkbox') {
                // Untuk checkbox
                $allAnswers = [];
                foreach ($validResponses as $response) {
                    if ($response->answer_data && is_array($response->answer_data)) {
                        $allAnswers = array_merge($allAnswers, $response->answer_data);
                    } elseif ($response->answer) {
                        $answers = explode(', ', $response->answer);
                        $allAnswers = array_merge($allAnswers, $answers);
                    }
                }
                
                $answerCounts = array_count_values($allAnswers);
                arsort($answerCounts);
                
                $stats['response_data'] = collect($answerCounts)->map(function($count, $answer) {
                    return (object)['answer' => $answer, 'count' => $count];
                });
                
            } elseif ($question->question_type === 'linear_scale') {
                // Untuk skala linier
                $responses = $question->responses()->whereHas('survey')->pluck('answer')->filter()->map(function($item) {
                    return (int) $item;
                });
                
                if ($responses->count() > 0) {
                    $distribution = $responses->countBy()->sort();
                    $stats['response_data'] = [
                        'average' => round($responses->avg(), 2),
                        'total_responses' => $responses->count(),
                        'distribution' => $distribution
                    ];
                }
                
            } elseif (in_array($question->question_type, ['short_text', 'long_text'])) {
                // Untuk jawaban teks
                $sampleResponses = $question->responses()
                    ->whereHas('survey')
                    ->whereNotNull('answer')
                    ->where('answer', '!=', '')
                    ->latest()
                    ->take(5)
                    ->pluck('answer');
                
                $stats['response_data'] = $sampleResponses;
                
            } elseif ($question->question_type === 'file_upload') {
                // Untuk file upload
                $fileResponses = $question->responses()
                    ->whereHas('survey')
                    ->whereNotNull('answer_data')
                    ->latest()
                    ->take(10)
                    ->get();
                
                $stats['response_data'] = $fileResponses->map(function($response) {
                    return [
                        'filename' => $response->answer,
                        'upload_date' => $response->created_at,
                        'file_data' => $response->answer_data
                    ];
                });
            }

            $questionStats[] = $stats;
        }

        return view('admin.dashboard-questions', compact(
            'totalSurveys',
            'questions',
            'questionStats'
        ));
    }

    private function getIndividualData($totalSurveys, $questions)
    {
        // Data individual responden
        $surveys = Survey::with(['responses.question.section'])
            ->latest()
            ->paginate(20);

        return view('admin.dashboard-individual', compact(
            'totalSurveys',
            'questions',
            'surveys'
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