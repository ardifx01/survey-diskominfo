{{-- resources/views/admin/dashboard-individual.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Individual - Admin Survei')
@section('active-dashboard', 'active')
@section('page-title', 'Dashboard Individual')
@section('page-subtitle', 'Data responden individual')

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

    /* Search and Filter Bar */
    .search-filter-bar {
        background: white;
        border-radius: 12px;
        padding: 25px;
        margin-bottom: 30px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        display: flex;
        gap: 15px;
        flex-wrap: wrap;
        align-items: center;
    }

    .search-input {
        flex: 1;
        min-width: 250px;
        padding: 12px 18px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: border-color 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .filter-select {
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        color: #495057;
        background: white;
        cursor: pointer;
        transition: border-color 0.3s ease;
    }

    .filter-select:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .search-btn {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        border: none;
        padding: 12px 20px;
        border-radius: 8px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .search-btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.3);
    }

    /* Response Cards */
    .response-card {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        margin-bottom: 25px;
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .response-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(0, 0, 0, 0.15);
    }

    .response-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        align-items: center;
    }

    .respondent-details h4 {
        margin: 0 0 8px 0;
        font-size: 20px;
        font-weight: 700;
    }

    .respondent-meta {
        display: flex;
        gap: 20px;
        font-size: 14px;
        opacity: 0.9;
        flex-wrap: wrap;
    }

    .respondent-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .response-body {
        padding: 30px;
    }

    .response-summary {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 25px;
    }

    .summary-item {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        padding: 20px;
        border-radius: 10px;
        border-left: 4px solid #5a9b9e;
        text-align: center;
    }

    .summary-value {
        font-size: 28px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 5px;
    }

    .summary-title {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .response-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .action-btn {
        padding: 10px 18px;
        border: none;
        border-radius: 6px;
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        text-decoration: none;
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .detail-btn {
        background: linear-gradient(135deg, #17a2b8 0%, #138496 100%);
        color: white;
    }

    .detail-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(23, 162, 184, 0.3);
    }

    .delete-btn {
        background: linear-gradient(135deg, #dc3545 0%, #c82333 100%);
        color: white;
    }

    .delete-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 8px rgba(220, 53, 69, 0.3);
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 80px 20px;
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        margin: 40px 0;
    }

    .empty-state i {
        font-size: 64px;
        color: #e9ecef;
        margin-bottom: 25px;
    }

    .empty-state h3 {
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 18px;
        color: #7f8c8d;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    /* Pagination */
    .pagination-wrapper {
        margin-top: 40px;
        display: flex;
        justify-content: center;
    }

    .pagination {
        display: flex;
        gap: 5px;
        list-style: none;
        margin: 0;
        padding: 0;
    }

    .page-item {
        border-radius: 6px;
        overflow: hidden;
    }

    .page-link {
        display: block;
        padding: 12px 16px;
        color: #5a9b9e;
        text-decoration: none;
        border: 1px solid #e9ecef;
        transition: all 0.3s ease;
    }

    .page-link:hover {
        background: #5a9b9e;
        color: white;
        border-color: #5a9b9e;
    }

    .page-item.active .page-link {
        background: #5a9b9e;
        color: white;
        border-color: #5a9b9e;
    }

    .page-item.disabled .page-link {
        color: #6c757d;
        background: #f8f9fa;
        border-color: #e9ecef;
        cursor: not-allowed;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .summary-stats {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .search-filter-bar {
            flex-direction: column;
            align-items: stretch;
        }

        .search-input {
            min-width: auto;
        }

        .tab-nav {
            flex-direction: column;
        }

        .tab-item {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }

        .tab-item:last-child {
            border-bottom: none;
        }

        .response-header {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .respondent-meta {
            justify-content: center;
        }

        .response-summary {
            grid-template-columns: 1fr;
        }

        .response-actions {
            flex-direction: column;
            gap: 10px;
        }
    }

    /* Detail Modal Styles */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        backdrop-filter: blur(5px);
    }

    .modal-content {
        background-color: white;
        margin: 5% auto;
        padding: 0;
        border-radius: 15px;
        width: 90%;
        max-width: 700px;
        max-height: 80vh;
        overflow: hidden;
        box-shadow: 0 20px 40px rgba(0, 0, 0, 0.2);
        position: relative;
    }

    .modal-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 25px 30px;
        display: flex;
        justify-content: between;
        align-items: center;
    }

    .modal-title {
        font-size: 20px;
        font-weight: 700;
        margin: 0;
        flex: 1;
    }

    .close {
        color: white;
        font-size: 28px;
        font-weight: bold;
        cursor: pointer;
        line-height: 1;
        opacity: 0.8;
        transition: opacity 0.3s ease;
    }

    .close:hover {
        opacity: 1;
    }

    .modal-body {
        padding: 30px;
        max-height: 60vh;
        overflow-y: auto;
    }

    .detail-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 10px;
        margin-bottom: 20px;
        border-left: 4px solid #5a9b9e;
    }

    .detail-info h4 {
        color: #2c3e50;
        margin-bottom: 15px;
        font-size: 18px;
    }

    .detail-info p {
        color: #7f8c8d;
        margin: 0;
        line-height: 1.6;
    }
</style>
@endpush

@section('content')
<!-- Action Buttons -->
<div class="action-buttons">
    <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
        <i class="fas fa-cog"></i>
        Kelola Pertanyaan
    </a>
    <a href="{{ route('survey.index') }}" class="btn btn-success">
        <i class="fas fa-eye"></i>
        Preview Survei
    </a>
    <a href="{{ route('admin.export') }}" class="btn btn-warning">
        <i class="fas fa-download"></i>
        Export Data
    </a>
</div>

<!-- Summary Statistics -->
<div class="summary-stats">
    <div class="summary-card">
        <div class="summary-number">{{ $questions->count() }}</div>
        <div class="summary-label">Total Pertanyaan</div>
    </div>
    <div class="summary-card">
        <div class="summary-number">{{ $totalSurveys }}</div>
        <div class="summary-label">Total Responden</div>
    </div>
    <div class="summary-card">
        <div class="summary-number">{{ $surveys->total() }}</div>
        <div class="summary-label">Total Survei</div>
    </div>
    <div class="summary-card">
        <div class="summary-number">{{ $surveys->sum(function($survey) { return $survey->responses->count(); }) }}</div>
        <div class="summary-label">Total Jawaban</div>
    </div>
</div>

<!-- Tab Navigation -->
<div class="tab-navigation">
    <div class="tab-nav">
        <a href="{{ route('admin.dashboard', ['tab' => 'questions']) }}" class="tab-item">
            <i class="fas fa-question-circle tab-icon"></i>
            <span>Pertanyaan</span>
        </a>
        <a href="{{ route('admin.dashboard', ['tab' => 'individual']) }}" class="tab-item active">
            <i class="fas fa-users tab-icon"></i>
            <span>Individual</span>
        </a>
    </div>
</div>

<!-- Search and Filter Bar -->
<div class="search-filter-bar">
    <input type="text" class="search-input" placeholder="🔍 Cari berdasarkan jawaban responden..." id="searchInput">
    <select class="filter-select" id="dateFilter">
        <option value="">Semua Tanggal</option>
        <option value="today">Hari Ini</option>
        <option value="week">Minggu Ini</option>
        <option value="month">Bulan Ini</option>
    </select>
    <button class="search-btn" onclick="filterResponses()">
        <i class="fas fa-search"></i> Filter
    </button>
</div>

<!-- Individual Responses -->
@if($surveys->count() > 0)
    <div id="responsesContainer">
        @foreach($surveys as $survey)
        <div class="response-card" data-survey-id="{{ $survey->id }}">
            <div class="response-header">
                <div class="respondent-details">
                    <h4>Responden #{{ $survey->id }}</h4>
                    <div class="respondent-meta">
                        <span><i class="fas fa-calendar-alt"></i> {{ $survey->created_at->format('d/m/Y H:i') }}</span>
                        <span><i class="fas fa-globe"></i> {{ $survey->ip_address ?: 'Tidak diketahui' }}</span>
                        @if($survey->responses->count() > 0)
                            <span><i class="fas fa-check-circle"></i> {{ $survey->responses->count() }} Jawaban</span>
                        @else
                            <span><i class="fas fa-clock"></i> Belum ada jawaban</span>
                        @endif
                    </div>
                </div>
            </div>

            <div class="response-body">
                <div class="response-summary">
                    <div class="summary-item">
                        <div class="summary-value">{{ $survey->responses->count() }}</div>
                        <div class="summary-title">Total Jawaban</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">{{ $survey->responses->whereNotNull('answer')->where('answer', '!=', '')->count() }}</div>
                        <div class="summary-title">Jawaban Terisi</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">{{ number_format(($survey->responses->whereNotNull('answer')->where('answer', '!=', '')->count() / max($questions->count(), 1)) * 100, 1) }}%</div>
                        <div class="summary-title">Tingkat Kelengkapan</div>
                    </div>
                    <div class="summary-item">
                        <div class="summary-value">{{ $survey->responses->where('question.question_type', 'file_upload')->whereNotNull('answer_data')->count() }}</div>
                        <div class="summary-title">File Diupload</div>
                    </div>
                </div>

                <!-- Preview Jawaban (3 pertanyaan pertama) -->
                @if($survey->responses->count() > 0)
                <div style="margin-bottom: 20px;">
                    <h5 style="color: #2c3e50; margin-bottom: 15px; font-size: 16px;">
                        <i class="fas fa-eye"></i> Preview Jawaban:
                    </h5>
                    @foreach($survey->responses->take(3) as $response)
                        @if($response->question && $response->answer)
                        <div style="background: #f8f9fa; padding: 12px 15px; margin-bottom: 8px; border-radius: 6px; border-left: 3px solid #5a9b9e;">
                            <strong style="color: #2c3e50; font-size: 14px;">{{ $response->question->question_text }}</strong>
                            <div style="color: #495057; font-size: 14px; margin-top: 5px;">
                                {{ Str::limit($response->answer, 100) }}
                            </div>
                        </div>
                        @endif
                    @endforeach
                    @if($survey->responses->count() > 3)
                        <small style="color: #7f8c8d; font-style: italic;">
                            <i class="fas fa-plus-circle"></i> Dan {{ $survey->responses->count() - 3 }} jawaban lainnya...
                        </small>
                    @endif
                </div>
                @endif

                <div class="response-actions">
                    <button class="action-btn detail-btn" onclick="showDetailModal({{ $survey->id }})">
                        <i class="fas fa-eye"></i> Lihat Detail
                    </button>
                    <form method="POST" action="{{ route('admin.deleteSurvey', $survey->id) }}" style="display: inline;" onsubmit="return confirm('Yakin ingin menghapus data survei ini?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete-btn">
                            <i class="fas fa-trash"></i> Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $surveys->appends(request()->query())->links() }}
    </div>
@else
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h3>Belum Ada Responden</h3>
        <p>Belum ada responden yang mengisi survei Anda. Bagikan link survei untuk mulai mengumpulkan data responden.</p>
        <a href="{{ route('survey.index') }}" class="btn btn-primary">
            <i class="fas fa-external-link-alt"></i> Buka Survei
        </a>
    </div>
@endif

<!-- Detail Modal -->
<div id="detailModal" class="modal">
    <div class="modal-content">
        <div class="modal-header">
            <h2 class="modal-title">Detail Responden</h2>
            <span class="close" onclick="closeDetailModal()">&times;</span>
        </div>
        <div class="modal-body" id="modalBody">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function filterResponses() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const dateFilter = document.getElementById('dateFilter').value;
        const responseCards = document.querySelectorAll('.response-card');

        responseCards.forEach(card => {
            const surveyId = card.dataset.surveyId;
            const cardText = card.textContent.toLowerCase();
            const cardDate = card.querySelector('.respondent-meta span').textContent;
            
            let showCard = true;

            // Search filter
            if (searchTerm && !cardText.includes(searchTerm)) {
                showCard = false;
            }

            // Date filter logic could be implemented here
            // This is a simplified version
            if (dateFilter && dateFilter !== '') {
                // Implement date filtering logic based on your needs
            }

            card.style.display = showCard ? 'block' : 'none';
        });
    }

    function showDetailModal(surveyId) {
        const modal = document.getElementById('detailModal');
        const modalBody = document.getElementById('modalBody');
        
        // Show loading state
        modalBody.innerHTML = `
            <div style="text-align: center; padding: 40px;">
                <i class="fas fa-spinner fa-spin" style="font-size: 32px; color: #5a9b9e; margin-bottom: 20px;"></i>
                <p style="color: #7f8c8d;">Memuat detail responden...</p>
            </div>
        `;
        
        modal.style.display = 'block';
        
        // Fetch survey detail via AJAX
        fetch(`/admin/survey/${surveyId}/detail`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                let detailHTML = `
                    <div class="detail-info">
                        <h4><i class="fas fa-info-circle"></i> Informasi Responden</h4>
                        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 15px; margin-top: 15px;">
                            <div><strong>ID Survei:</strong> #${data.survey.id}</div>
                            <div><strong>Tanggal:</strong> ${data.survey.created_at}</div>
                            <div><strong>IP Address:</strong> ${data.survey.ip_address}</div>
                        </div>
                    </div>
                `;

                data.sections.forEach((section, sectionIndex) => {
                    detailHTML += `
                        <div class="detail-section" style="margin-bottom: 30px;">
                            <div style="background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%); color: white; padding: 15px 20px; border-radius: 8px 8px 0 0; margin-bottom: 0;">
                                <h4 style="margin: 0; display: flex; align-items: center; gap: 10px;">
                                    <i class="fas fa-layer-group"></i>
                                    ${section.title}
                                </h4>
                                ${section.description ? `<p style="margin: 8px 0 0 0; opacity: 0.9; font-size: 14px;">${section.description}</p>` : ''}
                            </div>
                            <div style="border: 1px solid #e9ecef; border-top: none; border-radius: 0 0 8px 8px;">
                    `;

                    section.responses.forEach((response, responseIndex) => {
                        const isLast = responseIndex === section.responses.length - 1;
                        const borderClass = isLast ? '' : 'border-bottom: 1px solid #f8f9fa;';
                        
                        detailHTML += `
                            <div style="padding: 20px; ${borderClass}">
                                <div style="display: flex; justify-content: between; align-items: flex-start; margin-bottom: 12px;">
                                    <h5 style="margin: 0; color: #2c3e50; flex: 1; font-size: 16px;">${response.question_text}</h5>
                                    <div style="display: flex; gap: 10px; align-items: center;">
                                        <span style="background: #5a9b9e; color: white; padding: 4px 8px; border-radius: 12px; font-size: 11px; text-transform: uppercase;">${response.question_type_label}</span>
                                        ${response.is_required ? '<span style="color: #dc3545; font-size: 12px;"><i class="fas fa-star"></i> Wajib</span>' : '<span style="color: #6c757d; font-size: 12px;"><i class="fas fa-star-o"></i> Opsional</span>'}
                                    </div>
                                </div>
                                <div style="background: #f8f9fa; padding: 15px; border-radius: 6px; border-left: 4px solid #5a9b9e;">
                        `;

                        if (response.answer) {
                            if (response.question_type === 'linear_scale' && response.scale_info) {
                                detailHTML += `
                                    <div style="text-align: center;">
                                        <div style="font-size: 24px; font-weight: 700; color: #5a9b9e; margin-bottom: 10px;">${response.answer}</div>
                                        <div style="font-size: 14px; color: #7f8c8d;">
                                            Skala ${response.scale_info.min} - ${response.scale_info.max}
                                            ${response.scale_info.min_label || response.scale_info.max_label ? `<br><small>${response.scale_info.min_label} - ${response.scale_info.max_label}</small>` : ''}
                                        </div>
                                    </div>
                                `;
                            } else if (response.question_type === 'file_upload' && response.file_info) {
                                detailHTML += `
                                    <div style="display: flex; align-items: center; gap: 15px;">
                                        <i class="fas fa-file" style="font-size: 24px; color: #689f38;"></i>
                                        <div>
                                            <div style="font-weight: 600; color: #2c3e50;">${response.formatted_answer}</div>
                                            <div style="font-size: 14px; color: #7f8c8d;">File berhasil diupload</div>
                                        </div>
                                    </div>
                                `;
                            } else {
                                detailHTML += `<div style="color: #2c3e50; line-height: 1.5;">${response.formatted_answer}</div>`;
                            }
                        } else {
                            detailHTML += `<div style="color: #dc3545; font-style: italic;"><i class="fas fa-times-circle"></i> Tidak dijawab</div>`;
                        }

                        detailHTML += `
                                </div>
                            </div>
                        `;
                    });

                    detailHTML += `
                            </div>
                        </div>
                    `;
                });

                modalBody.innerHTML = detailHTML;
            })
            .catch(error => {
                console.error('Error:', error);
                modalBody.innerHTML = `
                    <div class="detail-info">
                        <h4><i class="fas fa-exclamation-triangle" style="color: #dc3545;"></i> Error</h4>
                        <p style="color: #dc3545;">Terjadi kesalahan saat memuat detail responden. Silakan coba lagi.</p>
                        <div style="text-align: center; margin-top: 20px;">
                            <button class="btn btn-primary" onclick="closeDetailModal()">
                                <i class="fas fa-times"></i> Tutup
                            </button>
                        </div>
                    </div>
                `;
            });
    }

    function closeDetailModal() {
        const modal = document.getElementById('detailModal');
        modal.style.display = 'none';
    }

    // Close modal when clicking outside
    window.onclick = function(event) {
        const modal = document.getElementById('detailModal');
        if (event.target === modal) {
            closeDetailModal();
        }
    }

    // Auto-hide success messages
    document.addEventListener('DOMContentLoaded', function() {
        const successMessage = document.querySelector('.success-message');
        if (successMessage) {
            setTimeout(() => {
                successMessage.style.display = 'none';
            }, 5000);
        }

        // Add search on enter key
        document.getElementById('searchInput').addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                filterResponses();
            }
        });

        // Auto filter on date change
        document.getElementById('dateFilter').addEventListener('change', function() {
            filterResponses();
        });
    });

    // Card animation on scroll
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.opacity = '1';
                entry.target.style.transform = 'translateY(0)';
            }
        });
    }, {
        threshold: 0.1
    });

    document.querySelectorAll('.response-card').forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(30px)';
        card.style.transition = `opacity 0.6s ease ${index * 0.1}s, transform 0.6s ease ${index * 0.1}s`;
        observer.observe(card);
    });
</script>
@endpush