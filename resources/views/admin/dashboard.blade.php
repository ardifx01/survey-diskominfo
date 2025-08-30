{{-- resources/views/admin/dashboard.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Admin - Survei Kepuasan Diskominfo Lamongan')
@section('active-dashboard', 'active')
@section('page-title', 'Dashboard Administrator')
@section('page-subtitle', 'Kelola dan pantau survei kepuasan masyarakat')

@section('header-actions')
<div class="header-actions">
    <span class="admin-welcome">Selamat datang, {{ session('admin_name') }}</span>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Action Buttons */
    .action-buttons {
        margin-bottom: 30px;
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        justify-content: center;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        font-size: 16px;
    }

    .btn-primary {
        background: #5a9b9e;
        color: white;
    }

    .btn-primary:hover {
        background: #4a8b8e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.3);
    }

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    .btn-info {
        background: #17a2b8;
        color: white;
    }

    .btn-info:hover {
        background: #138496;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(23, 162, 184, 0.3);
    }

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

    /* Summary Stats */
    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
        text-align: center;
    }

    .summary-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        border-left: 4px solid #5a9b9e;
    }

    .summary-number {
        font-size: 36px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 8px;
    }

    .summary-label {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* ========== PERBAIKAN UTAMA: SECTION DAN QUESTION CARDS ========== */
    
    /* Section Cards dengan counter reset untuk nomor pertanyaan */
    .section-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 40px;
        overflow: hidden;
        counter-reset: question-counter; /* Reset counter untuk setiap section */
    }

    .section-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 30px 35px;
        position: relative;
        overflow: hidden;
    }

    /* Decorative element untuk section header */
    .section-header::before {
        content: '';
        position: absolute;
        top: -50px;
        right: -50px;
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 50%;
        z-index: 1;
    }

    .section-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 10px;
        position: relative;
        z-index: 2;
    }

    .section-description {
        font-size: 16px;
        opacity: 0.9;
        line-height: 1.5;
        margin-bottom: 20px;
        position: relative;
        z-index: 2;
    }

    /* PERBAIKAN UTAMA: question-card dengan pemisah yang jelas */
    .question-card {
        border-bottom: none; /* Hilangkan border default */
        padding: 35px 40px;
        margin: 15px 20px 25px 20px; /* Margin untuk memberikan jarak dari tepi section */
        position: relative;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        transition: all 0.3s ease;
    }

    .question-card:hover {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.12);
        transform: translateY(-2px);
    }

    .question-card:last-child {
        margin-bottom: 20px;
    }

    /* Nomor pertanyaan di pojok kiri atas */
    .question-card::before {
        content: counter(question-counter);
        counter-increment: question-counter;
        position: absolute;
        top: 15px;
        left: 15px;
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        width: 32px;
        height: 32px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 14px;
        z-index: 3;
        box-shadow: 0 2px 8px rgba(90, 155, 158, 0.3);
    }

    /* Divider line antara pertanyaan yang lebih menarik */
    .question-card:not(:last-child)::after {
        content: '';
        position: absolute;
        bottom: -12px;
        left: 50%;
        transform: translateX(-50%);
        width: 80%;
        height: 2px;
        background: linear-gradient(90deg, transparent 0%, #5a9b9e 20%, #7fb3b6 50%, #5a9b9e 80%, transparent 100%);
        border-radius: 1px;
        z-index: 1;
    }

    .question-header {
        margin-bottom: 20px;
        padding-left: 50px; /* Beri ruang untuk nomor pertanyaan */
    }

    .question-text {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 10px;
        line-height: 1.4;
        padding-right: 20px;
    }

    .question-meta {
        display: flex;
        gap: 15px;
        color: #7f8c8d;
        font-size: 14px;
        flex-wrap: wrap;
        align-items: center;
    }

    .question-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
        background: #f8f9fa;
        padding: 6px 12px;
        border-radius: 20px;
        font-weight: 500;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .question-meta span:hover {
        background: #e9ecef;
        border-color: #dee2e6;
    }

    /* Response stats dengan grid yang lebih responsive */
    .response-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 15px;
        margin-bottom: 20px;
    }

    .stat-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        padding: 20px;
        border-radius: 10px;
        text-align: center;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
        position: relative;
        overflow: hidden;
    }

    .stat-item::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 3px;
        background: linear-gradient(90deg, #5a9b9e, #7fb3b6);
        border-radius: 10px 10px 0 0;
    }

    .stat-item:hover {
        border-color: #5a9b9e;
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.15);
        transform: translateY(-2px);
    }

    .stat-number {
        font-size: 20px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 5px;
    }

    .stat-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        font-weight: 600;
    }

    /* Response data styling yang lebih menarik */
    .response-data {
        margin-top: 20px;
        background: #f8f9fa;
        padding: 25px;
        border-radius: 12px;
        border-left: 4px solid #5a9b9e;
    }

    .chart-container {
        background: white;
        padding: 25px;
        border-radius: 10px;
        margin-top: 15px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
        border: 1px solid #f1f3f4;
    }

    .chart-container h4 {
        color: #2c3e50;
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 20px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .distribution-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .distribution-item:hover {
        background: #f8f9fa;
        border-radius: 6px;
        padding-left: 10px;
        padding-right: 10px;
    }

    .distribution-item:last-child {
        border-bottom: none;
    }

    .distribution-item span:first-child {
        font-weight: 500;
        color: #2c3e50;
    }

    .distribution-bar {
        height: 24px;
        background: linear-gradient(90deg, #5a9b9e 0%, #7fb3b6 100%);
        border-radius: 12px;
        margin-left: 15px;
        min-width: 30px;
        box-shadow: inset 0 1px 2px rgba(0, 0, 0, 0.1);
        position: relative;
        overflow: hidden;
    }

    .distribution-bar::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 50%;
        background: linear-gradient(180deg, rgba(255, 255, 255, 0.3) 0%, transparent 100%);
        border-radius: 12px 12px 0 0;
    }

    /* File responses styling */
    .file-responses {
        display: grid;
        gap: 15px;
        margin-top: 15px;
    }

    .file-response {
        display: flex;
        align-items: center;
        gap: 15px;
        padding: 15px;
        background: white;
        border-radius: 10px;
        border: 1px solid #e9ecef;
        border-left: 4px solid #28a745;
        transition: all 0.3s ease;
        box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    }

    .file-response:hover {
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        transform: translateY(-1px);
    }

    .file-icon {
        color: #28a745;
        font-size: 20px;
        background: rgba(40, 167, 69, 0.1);
        padding: 10px;
        border-radius: 8px;
    }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .file-date {
        font-size: 12px;
        color: #7f8c8d;
    }

    .file-actions {
        display: flex;
        gap: 8px;
    }

    .action-btn {
        padding: 6px 12px;
        border-radius: 4px;
        text-decoration: none;
        font-size: 12px;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .view-btn {
        background: #17a2b8;
        color: white;
    }

    .download-btn {
        background: #28a745;
        color: white;
    }

    /* Sample responses styling */
    .sample-responses {
        background: white;
        border-radius: 10px;
        padding: 20px;
        margin-top: 15px;
        border: 1px solid #e9ecef;
    }

    .sample-responses h4 {
        color: #2c3e50;
        font-size: 16px;
        font-weight: 600;
        margin-bottom: 15px;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .sample-response {
        padding: 12px 0;
        border-bottom: 1px solid #f1f3f4;
        transition: all 0.3s ease;
    }

    .sample-response:hover {
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px 10px;
    }

    .sample-response:last-child {
        border-bottom: none;
    }

    .response-text {
        font-style: italic;
        color: #495057;
        margin-bottom: 5px;
        line-height: 1.4;
    }

    .response-date {
        font-size: 12px;
        color: #7f8c8d;
        font-weight: 500;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
        background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
        border-radius: 12px;
        margin: 20px;
        border: 2px dashed #dee2e6;
    }

    .empty-state i {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
        color: #bdc3c7;
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
        max-width: 400px;
        margin-left: auto;
        margin-right: auto;
    }

    .admin-welcome {
        font-size: 14px;
        color: #7f8c8d;
    }

    /* Mobile responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .summary-stats {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .tab-item {
            padding: 15px 10px;
            font-size: 14px;
        }

        .question-card {
            padding: 25px 20px;
            margin: 10px 15px 20px 15px;
        }

        .question-header {
            padding-left: 40px;
        }

        .question-text {
            font-size: 16px;
        }

        .question-meta {
            flex-direction: column;
            gap: 10px;
            align-items: flex-start;
        }

        .question-meta span {
            font-size: 12px;
            padding: 4px 8px;
        }

        .response-stats {
            grid-template-columns: repeat(2, 1fr);
            gap: 10px;
        }

        .section-header {
            padding: 20px 25px;
        }

        .section-title {
            font-size: 20px;
        }

        .section-description {
            font-size: 14px;
        }

        .response-data {
            padding: 20px 15px;
        }

        .chart-container {
            padding: 20px 15px;
        }

        .distribution-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 8px;
        }

        .distribution-bar {
            width: 100%;
            margin-left: 0;
            height: 20px;
        }

        .empty-state {
            padding: 40px 15px;
            margin: 15px;
        }
        
        .empty-state i {
            font-size: 36px;
        }
        
        .empty-state h3 {
            font-size: 20px;
        }
    }

    /* Animation untuk smooth loading */
    .question-card {
        animation: fadeInUp 0.6s ease-out;
    }

    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    /* Smooth scroll behavior */
    html {
        scroll-behavior: smooth;
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <!-- Action Buttons -->
    <div class="action-buttons">
        <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
            <i class="fas fa-cogs"></i>
            Kelola Pertanyaan
        </a>
        <a href="{{ route('admin.export') }}" class="btn btn-success">
            <i class="fas fa-download"></i>
            Export Data
        </a>
    </div>

    <!-- Tab Navigation -->
    <div class="tab-navigation">
        <div class="tab-nav">
            <a href="{{ route('admin.dashboard', ['tab' => 'questions']) }}" 
                class="tab-item {{ request('tab', 'questions') === 'questions' ? 'active' : '' }}">
                <i class="tab-icon fas fa-question-circle"></i>
                Pertanyaan & Jawaban
            </a>
            <a href="{{ route('admin.dashboard', ['tab' => 'individual']) }}" 
                class="tab-item {{ request('tab') === 'individual' ? 'active' : '' }}">
                <i class="tab-icon fas fa-users"></i>
                Individual
            </a>
        </div>
    </div>

    <!-- Summary Stats -->
    <div class="summary-stats">
        <div class="summary-card">
            <div class="summary-number">{{ $totalSurveys }}</div>
            <div class="summary-label">Total Responden</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $questions->count() }}</div>
            <div class="summary-label">Total Pertanyaan</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $questions->where('is_required', true)->count() }}</div>
            <div class="summary-label">Wajib Diisi</div>
        </div>
        <div class="summary-card">
            <div class="summary-number">{{ $questions->sum(function($q) { return $q->responses->count(); }) }}</div>
            <div class="summary-label">Total Jawaban</div>
        </div>
    </div>

    <!-- Content Based on Available Data -->
    @if(isset($sectionStats) && count($sectionStats) > 0)
        <!-- Section-based View -->
        @foreach($sectionStats as $sectionStat)
            <div class="section-card">
                <div class="section-header">
                    <h2 class="section-title">
                        <i class="fas fa-layer-group"></i>
                        {{ $sectionStat['section']->title }}
                    </h2>
                    @if($sectionStat['section']->description)
                        <p class="section-description">{{ $sectionStat['section']->description }}</p>
                    @endif
                    <div class="section-meta">
                        <span><i class="fas fa-question-circle"></i> {{ $sectionStat['total_questions'] }} pertanyaan</span>
                        <span><i class="fas fa-comments"></i> {{ $sectionStat['total_responses'] }} jawaban</span>
                    </div>
                </div>

                @foreach($sectionStat['questions_stats'] as $stat)
                    <div class="question-card">
                        <div class="question-header">
                            <h3 class="question-text">{{ $stat['question']->question_text }}</h3>
                            <div class="question-meta">
                                <span><i class="fas fa-tag"></i> {{ $stat['question']->getQuestionTypeLabel() }}</span>
                                <span><i class="fas fa-users"></i> {{ $stat['total_responses'] }} responden</span>
                                <span><i class="fas fa-percentage"></i> {{ $stat['response_rate'] }}% tingkat respons</span>
                                @if($stat['question']->is_required)
                                    <span><i class="fas fa-asterisk"></i> Wajib diisi</span>
                                @endif
                            </div>
                        </div>

                        <div class="response-stats">
                            <div class="stat-item">
                                <div class="stat-number">{{ $stat['total_responses'] }}</div>
                                <div class="stat-label">Jawaban</div>
                            </div>
                            <div class="stat-item">
                                <div class="stat-number">{{ $stat['response_rate'] }}%</div>
                                <div class="stat-label">Tingkat Respons</div>
                            </div>
                        </div>

                        <div class="response-data">
                            @if(isset($stat['data']) && is_array($stat['data']) && count($stat['data']) > 0)
                                @if($stat['question']->question_type === 'linear_scale')
                                    <!-- Linear Scale Display -->
                                    <div class="chart-container">
                                        <h4><i class="fas fa-chart-bar"></i> Statistik Skala</h4>
                                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 15px; margin: 15px 0;">
                                            <div class="stat-item">
                                                <div class="stat-number">{{ $stat['data']['average'] ?? 0 }}</div>
                                                <div class="stat-label">Rata-rata</div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-number">{{ $stat['data']['min'] ?? 0 }}</div>
                                                <div class="stat-label">Minimum</div>
                                            </div>
                                            <div class="stat-item">
                                                <div class="stat-number">{{ $stat['data']['max'] ?? 0 }}</div>
                                                <div class="stat-label">Maximum</div>
                                            </div>
                                        </div>
                                        @if(isset($stat['data']['distribution']))
                                            <h5>Distribusi Nilai:</h5>
                                            @foreach($stat['data']['distribution'] as $value => $count)
                                                <div class="distribution-item">
                                                    <span>Nilai {{ $value }}</span>
                                                    <div style="display: flex; align-items: center;">
                                                        <span style="margin-right: 10px;">{{ $count }} orang</span>
                                                        <div class="distribution-bar" style="width: {{ ($count / $stat['total_responses']) * 200 }}px;"></div>
                                                    </div>
                                                </div>
                                            @endforeach
                                        @endif
                                    </div>
                                @else
                                    <!-- Multiple Choice / Checkbox Display -->
                                    <div class="chart-container">
                                        <h4><i class="fas fa-chart-pie"></i> Distribusi Jawaban</h4>
                                        @foreach($stat['data'] as $answer => $count)
                                            <div class="distribution-item">
                                                <span>{{ $answer }}</span>
                                                <div style="display: flex; align-items: center;">
                                                    <span style="margin-right: 10px;">{{ $count }} orang</span>
                                                    <div class="distribution-bar" style="width: {{ ($count / array_sum($stat['data'])) * 200 }}px;"></div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @elseif(isset($stat['response_data']) && is_array($stat['response_data']) && count($stat['response_data']) > 0)
                                <!-- File Upload Display -->
                                <div class="file-responses">
                                    <h4><i class="fas fa-file-upload"></i> File yang Diupload ({{ count($stat['response_data']) }})</h4>
                                    @foreach($stat['response_data'] as $file)
                                        <div class="file-response">
                                            <i class="fas fa-file file-icon"></i>
                                            <div class="file-info">
                                                <div class="file-name">{{ $file['filename'] }}</div>
                                                <div class="file-date">Upload: {{ \Carbon\Carbon::parse($file['upload_date'])->format('d/m/Y H:i') }}</div>
                                            </div>
                                            <div class="file-actions">
                                                @if(isset($file['file_data']['mime_type']) && str_starts_with($file['file_data']['mime_type'], 'image/'))
                                                    <a href="{{ route('admin.viewFile', $file['response_id']) }}" target="_blank" class="action-btn view-btn">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.downloadFile', $file['response_id']) }}" class="action-btn download-btn">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif(isset($stat['sample_responses']) && is_array($stat['sample_responses']) && count($stat['sample_responses']) > 0)
                                <!-- Text Responses Display -->
                                <div class="sample-responses">
                                    <h4><i class="fas fa-comment-dots"></i> Contoh Jawaban ({{ count($stat['sample_responses']) }} dari {{ $stat['total_responses'] }})</h4>
                                    @foreach($stat['sample_responses'] as $response)
                                        <div class="sample-response">
                                            <div class="response-text">"{{ $response['answer'] }}"</div>
                                            <div class="response-date">{{ $response['created_at'] }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <div class="empty-state">
                                    <i class="fas fa-inbox"></i>
                                    <p>Belum ada jawaban untuk pertanyaan ini.</p>
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endforeach
    @elseif($questions->count() > 0)
        <!-- Fallback: Simple Questions List -->
        <div class="section-card">
            <div class="section-header">
                <h2 class="section-title">
                    <i class="fas fa-list"></i>
                    Semua Pertanyaan
                </h2>
                <p class="section-description">Daftar pertanyaan survei dan statistik jawaban</p>
            </div>

            @foreach($questions as $question)
                <div class="question-card">
                    <div class="question-header">
                        <h3 class="question-text">{{ $question->question_text }}</h3>
                        <div class="question-meta">
                            <span><i class="fas fa-tag"></i> {{ $question->getQuestionTypeLabel() }}</span>
                            <span><i class="fas fa-users"></i> {{ $question->responses->count() }} responden</span>
                            @if($question->is_required)
                                <span><i class="fas fa-asterisk"></i> Wajib diisi</span>
                            @endif
                            @if($question->section)
                                <span><i class="fas fa-folder"></i> {{ $question->section->title }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="response-stats">
                        <div class="stat-item">
                            <div class="stat-number">{{ $question->responses->count() }}</div>
                            <div class="stat-label">Total Jawaban</div>
                        </div>
                        <div class="stat-item">
                            <div class="stat-number">{{ $totalSurveys > 0 ? round(($question->responses->count() / $totalSurveys) * 100, 1) : 0 }}%</div>
                            <div class="stat-label">Tingkat Respons</div>
                        </div>
                    </div>

                    @if($question->responses->count() > 0)
                        <div class="response-data">
                            @if($question->question_type === 'multiple_choice')
                                <!-- Multiple Choice Simple View -->
                                @php
                                    $answers = $question->responses->pluck('answer')->countBy();
                                @endphp
                                <div class="chart-container">
                                    <h4><i class="fas fa-chart-pie"></i> Distribusi Jawaban</h4>
                                    @foreach($answers as $answer => $count)
                                        <div class="distribution-item">
                                            <span>{{ $answer }}</span>
                                            <div style="display: flex; align-items: center;">
                                                <span style="margin-right: 10px;">{{ $count }} orang</span>
                                                <div class="distribution-bar" style="width: {{ ($count / $question->responses->count()) * 200 }}px;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($question->question_type === 'linear_scale')
                                <!-- Linear Scale Simple View -->
                                @php
                                    $responses = $question->responses->pluck('answer')->filter()->map(function($item) {
                                        return (int) $item;
                                    });
                                    $average = $responses->avg();
                                    $distribution = $responses->countBy();
                                @endphp
                                <div class="chart-container">
                                    <h4><i class="fas fa-chart-bar"></i> Statistik Skala</h4>
                                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(100px, 1fr)); gap: 15px; margin: 15px 0;">
                                        <div class="stat-item">
                                            <div class="stat-number">{{ round($average, 2) }}</div>
                                            <div class="stat-label">Rata-rata</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number">{{ $responses->min() }}</div>
                                            <div class="stat-label">Minimum</div>
                                        </div>
                                        <div class="stat-item">
                                            <div class="stat-number">{{ $responses->max() }}</div>
                                            <div class="stat-label">Maximum</div>
                                        </div>
                                    </div>
                                    <h5>Distribusi Nilai:</h5>
                                    @foreach($distribution as $value => $count)
                                        <div class="distribution-item">
                                            <span>Nilai {{ $value }}</span>
                                            <div style="display: flex; align-items: center;">
                                                <span style="margin-right: 10px;">{{ $count }} orang</span>
                                                <div class="distribution-bar" style="width: {{ ($count / $question->responses->count()) * 200 }}px;"></div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            @elseif($question->question_type === 'file_upload')
                                <!-- File Upload Simple View -->
                                @php
                                    $fileResponses = $question->responses->filter(function($response) {
                                        return $response->answer_data !== null;
                                    });
                                @endphp
                                <div class="file-responses">
                                    <h4><i class="fas fa-file-upload"></i> File yang Diupload ({{ $fileResponses->count() }})</h4>
                                    @foreach($fileResponses->take(5) as $response)
                                        <div class="file-response">
                                            <i class="fas fa-file file-icon"></i>
                                            <div class="file-info">
                                                <div class="file-name">{{ $response->answer }}</div>
                                                <div class="file-date">Upload: {{ $response->created_at->format('d/m/Y H:i') }}</div>
                                            </div>
                                            <div class="file-actions">
                                                @if(isset($response->answer_data['mime_type']) && str_starts_with($response->answer_data['mime_type'], 'image/'))
                                                    <a href="{{ route('admin.viewFile', $response->id) }}" target="_blank" class="action-btn view-btn">
                                                        <i class="fas fa-eye"></i> Lihat
                                                    </a>
                                                @endif
                                                <a href="{{ route('admin.downloadFile', $response->id) }}" class="action-btn download-btn">
                                                    <i class="fas fa-download"></i> Download
                                                </a>
                                            </div>
                                        </div>
                                    @endforeach
                                    @if($fileResponses->count() > 5)
                                        <div style="text-align: center; margin-top: 15px;">
                                            <a href="{{ route('admin.uploadedFiles') }}" class="btn btn-info">
                                                <i class="fas fa-eye"></i> Lihat Semua File ({{ $fileResponses->count() }})
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            @else
                                <!-- Text/Textarea Simple View -->
                                <div class="sample-responses">
                                    <h4><i class="fas fa-comment-dots"></i> Contoh Jawaban ({{ min(5, $question->responses->count()) }} dari {{ $question->responses->count() }})</h4>
                                    @foreach($question->responses->take(5) as $response)
                                        <div class="sample-response">
                                            <div class="response-text">"{{ Str::limit($response->answer, 100) }}"</div>
                                            <div class="response-date">{{ $response->created_at->format('d/m/Y H:i') }}</div>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                    @else
                        <div class="empty-state">
                            <i class="fas fa-inbox"></i>
                            <p>Belum ada jawaban untuk pertanyaan ini.</p>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>
    @else
        <!-- No Questions State -->
        <div class="empty-state">
            <i class="fas fa-question-circle"></i>
            <h3>Belum Ada Pertanyaan</h3>
            <p>Anda belum membuat pertanyaan survei. Mulai dengan membuat pertanyaan pertama.</p>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Pertanyaan Pertama
            </a>
        </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
    // Auto refresh setiap 30 detik untuk data real-time
    setTimeout(function() {
        // location.reload();
    }, 30000);
</script>
@endpush