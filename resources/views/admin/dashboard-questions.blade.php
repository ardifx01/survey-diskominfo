{{-- resources/views/admin/dashboard-questions.blade.php
@extends('layouts.admin')

@section('title', 'Dashboard Pertanyaan - Admin Survei')
@section('active-dashboard', 'active')
@section('page-title', 'Dashboard Survei')
@section('page-subtitle', 'Analisis jawaban per pertanyaan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<style>
    /* Tab Navigation */
    .tab-navigation {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .tab-nav {
        display: flex;
        background: #f8f9fa;
    }

    .tab-item {
        flex: 1;
        padding: 20px 25px;
        text-align: center;
        background: #f8f9fa;
        color: #6c757d;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border-right: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .tab-item:last-child {
        border-right: none;
    }

    .tab-item:hover {
        background: #e9ecef;
        color: #495057;
    }

    .tab-item.active {
        background: #5a9b9e;
        color: white;
    }

    .tab-icon {
        font-size: 18px;
    }

    /* Question Cards */
    .question-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .question-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 12px 30px rgba(0, 0, 0, 0.15);
    }

    .question-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 25px 30px;
    }

    .question-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .question-meta {
        display: flex;
        gap: 20px;
        align-items: center;
        font-size: 14px;
        opacity: 0.9;
        flex-wrap: wrap;
    }

    .question-type-badge {
        padding: 6px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
    }

    .question-body {
        padding: 30px;
    }

    .stats-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 25px;
        padding-bottom: 15px;
        border-bottom: 2px solid #f8f9fa;
    }

    .total-responses {
        font-size: 24px;
        font-weight: 700;
        color: #5a9b9e;
    }

    .responses-label {
        color: #7f8c8d;
        font-size: 14px;
        margin-top: 5px;
    }

    /* Chart Container */
    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }

    /* Response Statistics Styles */
    .response-stats {
        display: grid;
        gap: 15px;
    }

    .response-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 15px 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border-left: 4px solid #5a9b9e;
        transition: all 0.3s ease;
    }

    .response-item:hover {
        transform: translateX(5px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .response-text {
        flex: 1;
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
    }

    .response-count {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 8px 16px;
        border-radius: 25px;
        font-size: 14px;
        font-weight: 700;
        margin-left: 15px;
        min-width: 50px;
        text-align: center;
    }

    .response-percentage {
        font-size: 12px;
        color: #7f8c8d;
        margin-left: 10px;
    }

    /* Scale Statistics */
    .scale-stats {
        text-align: center;
        padding: 30px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 15px;
        margin-bottom: 20px;
    }

    .scale-average {
        font-size: 48px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 10px;
    }

    .scale-label {
        color: #7f8c8d;
        font-size: 16px;
        margin-bottom: 25px;
    }

    .scale-distribution {
        display: flex;
        justify-content: center;
        gap: 15px;
        flex-wrap: wrap;
    }

    .scale-item {
        text-align: center;
        min-width: 50px;
    }

    .scale-number {
        display: block;
        width: 45px;
        height: 45px;
        line-height: 45px;
        border-radius: 50%;
        background: #e9ecef;
        color: #6c757d;
        font-weight: 700;
        margin-bottom: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
    }

    .scale-item.active .scale-number {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        transform: scale(1.1);
    }

    .scale-count {
        font-size: 14px;
        color: #7f8c8d;
        font-weight: 600;
    }

    /* Text Responses */
    .text-responses {
        display: grid;
        gap: 15px;
    }

    .text-response {
        padding: 20px;
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border-radius: 10px;
        border-left: 4px solid #5a9b9e;
        font-style: italic;
        color: #495057;
        font-size: 15px;
        line-height: 1.6;
    }

    .text-response::before {
        content: '"';
        font-size: 24px;
        color: #5a9b9e;
        font-weight: bold;
    }

    .text-response::after {
        content: '"';
        font-size: 24px;
        color: #5a9b9e;
        font-weight: bold;
    }

    /* File Responses */
    .file-responses {
        display: grid;
        gap: 15px;
    }

    .file-response {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 20px;
        background: linear-gradient(135deg, #f1f8e9 0%, #e8f5e8 100%);
        border-radius: 10px;
        border-left: 4px solid #689f38;
        transition: all 0.3s ease;
    }

    .file-response:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
    }

    .file-icon {
        color: #689f38;
        font-size: 24px;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
        margin-bottom: 5px;
    }

    .file-date {
        font-size: 14px;
        color: #7f8c8d;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 24px;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .empty-state p {
        font-size: 16px;
        line-height: 1.6;
        margin-bottom: 25px;
    }

    .no-questions-state {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        padding: 60px 40px;
        text-align: center;
        margin: 40px 0;
    }

    .show-more-info {
        background: #e8f4f8;
        border: 1px solid #bee5eb;
        border-radius: 8px;
        padding: 15px;
        margin-top: 20px;
        text-align: center;
    }

    .show-more-info small {
        color: #5a9b9e;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .tab-nav {
            flex-direction: column;
        }

        .tab-item {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }

        .question-header {
            padding: 20px;
        }

        .question-body {
            padding: 20px;
        }

        .question-meta {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .scale-distribution {
            gap: 10px;
        }

        .scale-number {
            width: 40px;
            height: 40px;
            line-height: 40px;
            font-size: 14px;
        }

        .response-item {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }

        .response-count {
            margin-left: 0;
        }

        .chart-container {
            height: 250px;
        }
    }
</style>
@endpush

@section('content')
<!-- Tab Navigation -->
<div class="tab-navigation">
    <div class="tab-nav">
        <a href="{{ route('admin.dashboard', ['tab' => 'questions']) }}" class="tab-item active">
            <i class="fas fa-question-circle tab-icon"></i>
            <span>Pertanyaan</span>
        </a>
        <a href="{{ route('admin.dashboard', ['tab' => 'individual']) }}" class="tab-item">
            <i class="fas fa-users tab-icon"></i>
            <span>Individual</span>
        </a>
    </div>
</div>

<!-- Questions & Answers Section -->
@if($questions->count() > 0)
    @foreach($questionStats as $stat)
    <div class="question-card">
        <div class="question-header">
            <div class="question-title">{{ $stat['question']->question_text }}</div>
            <div class="question-meta">
                <span class="question-type-badge">
                    <i class="fas fa-tag"></i> {{ $stat['question']->getQuestionTypeLabel() }}
                </span>
                <span><i class="fas fa-layer-group"></i> {{ $stat['question']->section->title }}</span>
                <span><i class="fas fa-{{ $stat['question']->is_required ? 'star' : 'star-o' }}"></i> {{ $stat['question']->is_required ? 'Wajib' : 'Opsional' }}</span>
            </div>
        </div>

        <div class="question-body">
            <div class="stats-header">
                <div>
                    <div class="total-responses">{{ $stat['total_responses'] }}</div>
                    <div class="responses-label">Total Jawaban</div>
                </div>
                @if($stat['total_responses'] > 0)
                    <div style="color: #28a745;">
                        <i class="fas fa-check-circle"></i> Ada Jawaban
                    </div>
                @else
                    <div style="color: #ffc107;">
                        <i class="fas fa-clock"></i> Belum Ada Jawaban
                    </div>
                @endif
            </div>

            @if($stat['total_responses'] > 0)
                @if(in_array($stat['question']->question_type, ['multiple_choice', 'dropdown']))
                    <!-- Multiple Choice / Dropdown Responses -->
                    <div class="chart-container">
                        <canvas id="chart_{{ $stat['question']->id }}"></canvas>
                    </div>
                    <div class="response-stats">
                        @foreach($stat['response_data'] as $response)
                            <div class="response-item">
                                <span class="response-text">{{ $response->answer }}</span>
                                <div>
                                    <span class="response-count">{{ $response->count }}</span>
                                    <span class="response-percentage">({{ number_format(($response->count / $stat['total_responses']) * 100, 1) }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @elseif($stat['question']->question_type === 'checkbox')
                    <!-- Checkbox Responses -->
                    <div class="chart-container">
                        <canvas id="chart_{{ $stat['question']->id }}"></canvas>
                    </div>
                    <div class="response-stats">
                        @foreach($stat['response_data'] as $response)
                            <div class="response-item">
                                <span class="response-text">{{ $response->answer }}</span>
                                <div>
                                    <span class="response-count">{{ $response->count }}</span>
                                    <span class="response-percentage">({{ number_format(($response->count / $stat['response_data']->sum('count')) * 100, 1) }}%)</span>
                                </div>
                            </div>
                        @endforeach
                    </div>

                @elseif($stat['question']->question_type === 'linear_scale')
                    <!-- Linear Scale Responses -->
                    <div class="chart-container">
                        <canvas id="chart_{{ $stat['question']->id }}"></canvas>
                    </div>
                    <div class="scale-stats">
                        <div class="scale-average">{{ $stat['response_data']['average'] ?? 0 }}</div>
                        <div class="scale-label">Rata-rata dari {{ $stat['response_data']['total_responses'] ?? 0 }} jawaban</div>
                        
                        @if(isset($stat['response_data']['distribution']))
                        <div class="scale-distribution">
                            @for($i = ($stat['question']->settings['scale_min'] ?? 1); $i <= ($stat['question']->settings['scale_max'] ?? 5); $i++)
                                <div class="scale-item {{ isset($stat['response_data']['distribution'][$i]) && $stat['response_data']['distribution'][$i] > 0 ? 'active' : '' }}">
                                    <span class="scale-number">{{ $i }}</span>
                                    <div class="scale-count">{{ $stat['response_data']['distribution'][$i] ?? 0 }} orang</div>
                                </div>
                            @endfor
                        </div>
                        @endif
                    </div>

                @elseif(in_array($stat['question']->question_type, ['short_text', 'long_text']))
                    <!-- Text Responses -->
                    <div class="text-responses">
                        @foreach($stat['response_data']->take(5) as $response)
                            <div class="text-response">
                                {{ Str::limit($response, 200) }}
                            </div>
                        @endforeach
                        
                        @if($stat['response_data']->count() > 5)
                            <div class="show-more-info">
                                <small>
                                    <i class="fas fa-info-circle"></i>
                                    Menampilkan 5 jawaban terbaru dari {{ $stat['total_responses'] }} total jawaban
                                </small>
                            </div>
                        @endif
                    </div>

                @elseif($stat['question']->question_type === 'file_upload')
                    <!-- File Upload Responses -->
                    <div class="file-responses">
                        @foreach($stat['response_data'] as $file)
                            <div class="file-response">
                                <i class="fas fa-file file-icon"></i>
                                <div class="file-info">
                                    <div class="file-name">{{ $file['filename'] }}</div>
                                    <div class="file-date">Diupload: {{ \Carbon\Carbon::parse($file['upload_date'])->format('d/m/Y H:i') }}</div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            @else
                <div class="empty-state">
                    <i class="fas fa-inbox"></i>
                    <h3>Belum Ada Jawaban</h3>
                    <p>Pertanyaan ini belum dijawab oleh responden manapun.</p>
                </div>
            @endif
        </div>
    </div>
    @endforeach
@else
<div class="no-questions-state">
    <div class="empty-state">
        <i class="fas fa-question-circle"></i>
        <h3>Belum Ada Pertanyaan</h3>
        <p>Anda belum membuat pertanyaan survei. Mulai dengan membuat pertanyaan pertama untuk melihat jawaban responden di sini.</p>
        <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Pertanyaan Pertama
        </a>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
    // Chart.js Configuration
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#2c3e50';

    // Color Palette
    const colors = ['#5a9b9e', '#28a745', '#ffc107', '#dc3545', '#17a2b8', '#6f42c1', '#fd7e14', '#20c997'];

    // Render charts for each question
    @foreach($questionStats as $stat)
        @if($stat['total_responses'] > 0 && in_array($stat['question']->question_type, ['multiple_choice', 'dropdown', 'checkbox']))
            // Chart for question {{ $stat['question']->id }}
            const ctx{{ $stat['question']->id }} = document.getElementById('chart_{{ $stat['question']->id }}').getContext('2d');
            new Chart(ctx{{ $stat['question']->id }}, {
                type: '{{ $stat['question']->question_type === 'checkbox' ? 'bar' : 'doughnut' }}',
                data: {
                    labels: @json($stat['response_data']->pluck('answer')),
                    datasets: [{
                        data: @json($stat['response_data']->pluck('count')),
                        backgroundColor: colors,
                        @if($stat['question']->question_type !== 'checkbox')
                        borderWidth: 2,
                        borderColor: '#ffffff'
                        @else
                        borderRadius: 8,
                        borderSkipped: false,
                        @endif
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            @if($stat['question']->question_type === 'checkbox')
                            display: false
                            @else
                            position: 'bottom',
                            labels: {
                                padding: 15,
                                usePointStyle: true,
                                font: { size: 12 }
                            }
                            @endif
                        }
                    },
                    @if($stat['question']->question_type === 'checkbox')
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e9ecef' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                    @else
                    cutout: '50%'
                    @endif
                }
            });
        @elseif($stat['total_responses'] > 0 && $stat['question']->question_type === 'linear_scale' && isset($stat['response_data']['distribution']))
            // Linear Scale Chart for question {{ $stat['question']->id }}
            const ctx{{ $stat['question']->id }} = document.getElementById('chart_{{ $stat['question']->id }}').getContext('2d');
            const scaleLabels = [];
            const scaleData = [];
            @for($i = ($stat['question']->settings['scale_min'] ?? 1); $i <= ($stat['question']->settings['scale_max'] ?? 5); $i++)
                scaleLabels.push('{{ $i }}');
                scaleData.push({{ $stat['response_data']['distribution'][$i] ?? 0 }});
            @endfor
            
            new Chart(ctx{{ $stat['question']->id }}, {
                type: 'bar',
                data: {
                    labels: scaleLabels,
                    datasets: [{
                        label: 'Jumlah Responden',
                        data: scaleData,
                        backgroundColor: '#5a9b9e',
                        borderRadius: 8,
                        borderSkipped: false,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: { color: '#e9ecef' }
                        },
                        x: {
                            grid: { display: false }
                        }
                    }
                }
            });
        @endif
    @endforeach
</script>
@endpush --}}