<?php
// app/Http/Controllers/SurveyController.php
namespace App\Http\Controllers;

use App\Http\Requests\SurveyRequest;
use App\Models\Survey;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SurveyController extends Controller
{
    public function index()
    {
        return view('survey.index');
    }

    public function store(SurveyRequest $request)
    {
        try {
            $survey = Survey::create([
                'nama' => $request->nama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'usia' => $request->usia,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            return response()->json([
                'success' => true,
                'message' => 'Data survei berhasil disimpan.',
                'data' => $survey
            ], 201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan data.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function dashboard()
    {
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

        // Data survei terbaru
        $recentSurveys = Survey::latest()->take(10)->get();

        return view('survey.dashboard', compact(
            'totalSurveys', 
            'maleCount', 
            'femaleCount', 
            'ageStats', 
            'recentSurveys'
        ));
    }

    public function export()
    {
        $surveys = Survey::all();
        
        $csvData = "ID,Nama,Jenis Kelamin,Usia,Tanggal Pengisian\n";
        
        foreach ($surveys as $survey) {
            $csvData .= $survey->id . "," . 
                    $survey->nama . "," . 
                    $survey->jenis_kelamin_label . "," . 
                    $survey->usia . "," . 
                    $survey->created_at->format('Y-m-d H:i:s') . "\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv')
            ->header('Content-Disposition', 'attachment; filename="survei-kepuasan-' . date('Y-m-d') . '.csv"');
    }
}