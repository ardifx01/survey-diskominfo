<?php
// app/Http/Controllers/DynamicSurveyController.php
namespace App\Http\Controllers;

use App\Models\Survey;
use App\Models\SurveySection;
use App\Models\SurveyQuestion;
use App\Models\SurveyResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class DynamicSurveyController extends Controller
{
    // Halaman survei dinamis
    public function index()
    {
        $sections = SurveySection::active()
                                ->ordered()
                                ->with(['questions' => function($query) {
                                    $query->active()->ordered();
                                }])
                                ->get();

        // Filter sections yang memiliki pertanyaan aktif
        $sections = $sections->filter(function($section) {
            return $section->questions->count() > 0;
        });

        if ($sections->isEmpty()) {
            // Jika belum ada survei dinamis, redirect ke survei lama
            return redirect()->route('survey.index');
        }

        return view('dynamic-survey.index', compact('sections'));
    }

    // Simpan jawaban survei dinamis
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            // Buat record survei utama
            $survey = Survey::create([
                'nama' => $request->nama ?? 'Anonymous',
                'jenis_kelamin' => $request->jenis_kelamin ?? 'laki_laki',
                'usia' => $request->usia ?? 0,
                'ip_address' => $request->ip(),
                'user_agent' => $request->header('User-Agent'),
            ]);

            // Ambil semua pertanyaan aktif
            $questions = SurveyQuestion::active()->get();

            foreach ($questions as $question) {
                $fieldName = 'question_' . $question->id;
                $answer = $request->input($fieldName);

                if ($answer !== null && $answer !== '') {
                    $answerData = null;

                    // Handle berbagai jenis jawaban
                    if ($question->question_type === 'checkbox' && is_array($answer)) {
                        // Multiple checkbox answers
                        $answerData = $answer;
                        $answer = implode(', ', $answer);
                    } elseif ($question->question_type === 'file_upload') {
                        // Handle file upload
                        if ($request->hasFile($fieldName)) {
                            $file = $request->file($fieldName);
                            $filename = time() . '_' . $file->getClientOriginalName();
                            $path = $file->storeAs('uploads/survey', $filename, 'public');
                            
                            $answerData = [
                                'filename' => $file->getClientOriginalName(),
                                'path' => $path,
                                'size' => $file->getSize(),
                                'mime_type' => $file->getMimeType()
                            ];
                            $answer = $file->getClientOriginalName();
                        }
                    } elseif (is_array($answer)) {
                        $answer = implode(', ', $answer);
                    }

                    // Simpan response
                    SurveyResponse::create([
                        'survey_id' => $survey->id,
                        'question_id' => $question->id,
                        'answer' => $answer,
                        'answer_data' => $answerData
                    ]);
                }
            }

            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Survei berhasil disimpan.',
                'survey_id' => $survey->id
            ], 201);

        } catch (\Exception $e) {
            DB::rollBack();
            
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menyimpan survei.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Validasi data survei dinamis
    private function validateDynamicSurvey(Request $request)
    {
        $rules = [];
        $messages = [];

        // Get all active questions untuk validasi
        $questions = SurveyQuestion::active()->get();

        foreach ($questions as $question) {
            $fieldName = 'question_' . $question->id;
            
            if ($question->is_required) {
                if ($question->question_type === 'file_upload') {
                    $rules[$fieldName] = 'required|file|max:10240'; // Max 10MB
                } elseif ($question->question_type === 'checkbox') {
                    $rules[$fieldName] = 'required|array|min:1';
                } else {
                    $rules[$fieldName] = 'required';
                }

                $messages[$fieldName . '.required'] = 'Pertanyaan "' . $question->question_text . '" wajib dijawab.';
            }

            // Additional validation rules berdasarkan jenis pertanyaan
            if ($question->question_type === 'linear_scale' && isset($question->settings['scale_min'], $question->settings['scale_max'])) {
                $rules[$fieldName] = 'nullable|integer|between:' . $question->settings['scale_min'] . ',' . $question->settings['scale_max'];
            }
        }

        $request->validate($rules, $messages);
    }

    // Preview survei untuk admin
    public function preview()
    {
        $sections = SurveySection::active()
                                ->ordered()
                                ->with(['questions' => function($query) {
                                    $query->active()->ordered();
                                }])
                                ->get();

        $sections = $sections->filter(function($section) {
            return $section->questions->count() > 0;
        });

        return view('dynamic-survey.preview', compact('sections'));
    }

    // API untuk mengambil struktur survei (untuk AJAX)
    public function getStructure()
    {
        $sections = SurveySection::active()
                                ->ordered()
                                ->with(['questions' => function($query) {
                                    $query->active()->ordered();
                                }])
                                ->get();

        $sections = $sections->filter(function($section) {
            return $section->questions->count() > 0;
        });

        return response()->json([
            'success' => true,
            'sections' => $sections->map(function($section) {
                return [
                    'id' => $section->id,
                    'title' => $section->title,
                    'description' => $section->description,
                    'questions' => $section->questions->map(function($question) {
                        return [
                            'id' => $question->id,
                            'text' => $question->question_text,
                            'type' => $question->question_type,
                            'required' => $question->is_required,
                            'options' => $question->options,
                            'settings' => $question->settings
                        ];
                    })
                ];
            })
        ]);
    }

    // Statistik untuk dashboard admin
    public function getStats()
    {
        $totalResponses = Survey::count();
        $questionStats = [];

        $questions = SurveyQuestion::active()->with('responses')->get();

        foreach ($questions as $question) {
            $stats = [
                'question_id' => $question->id,
                'question_text' => $question->question_text,
                'question_type' => $question->question_type,
                'total_responses' => $question->responses->count(),
                'data' => []
            ];

            if (in_array($question->question_type, ['multiple_choice', 'dropdown'])) {
                // Statistik untuk pilihan ganda/dropdown
                $responseCounts = $question->responses()
                    ->select('answer', DB::raw('count(*) as count'))
                    ->groupBy('answer')
                    ->pluck('count', 'answer')
                    ->toArray();

                $stats['data'] = $responseCounts;
            } elseif ($question->question_type === 'checkbox') {
                // Statistik untuk checkbox (multiple selection)
                $allAnswers = [];
                foreach ($question->responses as $response) {
                    if ($response->answer_data) {
                        $allAnswers = array_merge($allAnswers, $response->answer_data);
                    }
                }
                $stats['data'] = array_count_values($allAnswers);
            } elseif ($question->question_type === 'linear_scale') {
                // Statistik untuk skala linier
                $responses = $question->responses()->pluck('answer')->filter()->map(function($item) {
                    return (int) $item;
                });
                
                $stats['data'] = [
                    'average' => $responses->avg(),
                    'min' => $responses->min(),
                    'max' => $responses->max(),
                    'distribution' => $responses->countBy()->toArray()
                ];
            }

            $questionStats[] = $stats;
        }

        return response()->json([
            'success' => true,
            'total_responses' => $totalResponses,
            'questions' => $questionStats
        ]);
    }

    // Export data survei dinamis
    public function export()
    {
        $surveys = Survey::with(['responses.question'])->orderBy('created_at', 'desc')->get();
        $questions = SurveyQuestion::active()->ordered()->get();

        // Header CSV
        $headers = ['ID', 'Nama', 'Jenis Kelamin', 'Usia', 'Tanggal Pengisian'];
        
        // Tambahkan header untuk setiap pertanyaan
        foreach ($questions as $question) {
            $headers[] = $question->question_text;
        }

        $csvData = implode(',', array_map(function($header) {
            return '"' . str_replace('"', '""', $header) . '"';
        }, $headers)) . "\n";

        // Data rows
        foreach ($surveys as $survey) {
            $row = [
                $survey->id,
                $survey->nama,
                $survey->jenis_kelamin_label,
                $survey->usia,
                $survey->created_at->format('Y-m-d H:i:s')
            ];

            // Tambahkan jawaban untuk setiap pertanyaan
            foreach ($questions as $question) {
                $response = $survey->responses->firstWhere('question_id', $question->id);
                $answer = $response ? $response->answer : '';
                
                // Format khusus untuk file upload
                if ($question->question_type === 'file_upload' && $response && $response->answer_data) {
                    $answer = $response->answer_data['filename'] ?? $answer;
                }
                
                $row[] = $answer;
            }

            $csvData .= implode(',', array_map(function($field) {
                return '"' . str_replace('"', '""', $field) . '"';
            }, $row)) . "\n";
        }

        return response($csvData)
            ->header('Content-Type', 'text/csv; charset=UTF-8')
            ->header('Content-Disposition', 'attachment; filename="survei-dinamis-' . date('Y-m-d') . '.csv"')
            ->header('Cache-Control', 'no-cache, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    // Download file yang diupload responden
    public function downloadFile($responseId)
    {
        $response = SurveyResponse::findOrFail($responseId);
        
        if ($response->question->question_type !== 'file_upload' || !$response->answer_data) {
            abort(404);
        }

        $filePath = $response->answer_data['path'];
        
        if (!Storage::disk('public')->exists($filePath)) {
            abort(404, 'File tidak ditemukan');
        }

        return Storage::disk('public')->download($filePath, $response->answer_data['filename']);
    }
}