{{-- resources/views/admin/dashboard-individual.blade.php --}}
@extends('layouts.admin')

@section('title', 'Dashboard Individual - Admin Survei')
@section('active-dashboard', 'active')
@section('page-title', 'Dashboard Survei')
@section('page-subtitle', 'Jawaban individual per responden')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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

    /* Search and Filter */
    .search-filter-bar {
        background: white;
        padding: 25px 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        display: flex;
        gap: 20px;
        align-items: center;
        flex-wrap: wrap;
    }

    .search-input {
        flex: 1;
        padding: 12px 18px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        min-width: 250px;
        transition: border-color 0.3s ease;
    }

    .search-input:focus {
        outline: none;
        border-color: #5a9b9e;
    }

    .filter-select {
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        background: white;
        min-width: 150px;
    }

    .search-btn {
        padding: 12px 20px;
        background: #5a9b9e;
        color: white;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: all 0.3s ease;
    }

    .search-btn:hover {
        background: #4a8b8e;
        transform: translateY(-2px);
    }

    /* Individual Response Cards */
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
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
    }

    .response-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 20px 25px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .respondent-info {
        display: flex;
        align-items: center;
        gap: 15px;
    }

    .respondent-avatar {
        width: 50px;
        height: 50px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        font-weight: 700;
    }

    .respondent-details h4 {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .respondent-meta {
        font-size: 14px;
        opacity: 0.9;
    }

    .response-actions {
        display: flex;
        gap: 10px;
    }

    .btn-action {
        padding: 8px 12px;
        border: 1px solid rgba(255, 255, 255, 0.3);
        background: rgba(255, 255, 255, 0.1);
        color: white;
        border-radius: 6px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 12px;
        text-decoration: none;
    }

    .btn-action:hover {
        background: rgba(255, 255, 255, 0.2);
        color: white;
    }

    .response-body {
        padding: 25px;
    }

    .answers-grid {
        display: grid;
        gap: 20px;
    }

    .answer-item {
        display: flex;
        flex-direction: column;
        gap: 8px;
        padding: 15px;
        background: #f8f9fa;
        border-radius: 8px;
        border-left: 4px solid #5a9b9e;
    }

    .question-text {
        font-weight: 600;
        color: #2c3e50;
        font-size: 14px;
        line-height: 1.4;
    }

    .answer-text {
        color: #495057;
        font-size: 16px;
        line-height: 1.5;
    }

    .answer-text.empty {
        color: #7f8c8d;
        font-style: italic;
    }

    .question-type {
        font-size: 11px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* File Answer Styling */
    .file-answer {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #e8f5e8;
        border-radius: 6px;
        color: #2e7d32;
    }

    .file-answer i {
        font-size: 18px;
    }

    /* Scale Answer Styling */
    .scale-answer {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .scale-value {
        background: #5a9b9e;
        color: white;
        padding: 5px 12px;
        border-radius: 50%;
        font-weight: 700;
        min-width: 35px;
        text-align: center;
    }

    .scale-labels {
        font-size: 12px;
        color: #7f8c8d;
    }

    /* Pagination */
    .pagination-container {
        display: flex;
        justify-content: center;
        margin-top: 40px;
    }

    .pagination {
        display: flex;
        gap: 5px;
        align-items: center;
    }

    .pagination a,
    .pagination span {
        padding: 10px 15px;
        border: 1px solid #e9ecef;
        color: #6c757d;
        text-decoration: none;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .pagination a:hover {
        background: #5a9b9e;
        color: white;
        border-color: #5a9b9e;
    }

    .pagination .active span {
        background: #5a9b9e;
        color: white;
        border-color: #5a9b9e;
    }

    .pagination .disabled span {
        color: #ccc;
        cursor: not-allowed;
    }

    /* Empty State */
    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
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

    /* Responsive */
            @media (max-width: 768px) {
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

        .search-filter-bar {
            flex-direction: column;
            gap: 15px;
            padding: 20px;
        }

        .search-input {
            min-width: 100%;
        }

        .response-header {
            flex-direction: column;
            gap: 15px;
            text-align: center;
            padding: 20px;
        }

        .respondent-info {
            justify-content: center;
        }

        .response-body {
            padding: 20px 15px;
        }

        .answer-item {
            padding: 12px;
        }
    }
</style>
@endpush

@section('content')
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
    <input type="text" class="search-input" placeholder="🔍 Cari berdasarkan nama, email, atau jawaban..." id="searchInput">
    <select class="filter-select" id="genderFilter">
        <option value="">Semua Jenis Kelamin</option>
        <option value="laki_laki">Laki-laki</option>
        <option value="perempuan">Perempuan</option>
    </select>
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
                <div class="respondent-info">
                    <div class="respondent-avatar">
                        {{ strtoupper(substr($survey->nama, 0, 2)) }}
                    </div>
                    <div class="respondent-details">
                        <h4>{{ $survey->nama }}</h4>
                        <div class="respondent-meta">
                            <i class="fas fa-{{ $survey->jenis_kelamin === 'laki_laki' ? 'mars' : 'venus' }}"></i>
                            {{ $survey->jenis_kelamin_label }} • {{ $survey->usia }} tahun • 
                            <i class="fas fa-clock"></i> {{ $survey->created_at->format('d/m/Y H:i') }}
                        </div>
                    </div>
                </div>
                <div class="response-actions">
                    <a href="#" class="btn-action" onclick="viewDetail({{ $survey->id }})">
                        <i class="fas fa-eye"></i> Detail
                    </a>
                    <a href="#" class="btn-action" onclick="deleteSurvey({{ $survey->id }})">
                        <i class="fas fa-trash"></i> Hapus
                    </a>
                </div>
            </div>

            <div class="response-body">
                <div class="answers-grid">
                    @forelse($survey->responses->take(5) as $response)
                        <div class="answer-item">
                            <div class="question-text">
                                {{ $response->question->question_text }}
                                <span class="question-type">({{ $response->question->getQuestionTypeLabel() }})</span>
                            </div>
                            
                            @if($response->question->question_type === 'file_upload' && $response->answer_data)
                                <div class="file-answer">
                                    <i class="fas fa-file"></i>
                                    <span>{{ $response->answer }}</span>
                                    <small>({{ number_format($response->answer_data['size'] / 1024, 1) }} KB)</small>
                                </div>
                            @elseif($response->question->question_type === 'linear_scale')
                                <div class="scale-answer">
                                    <div class="scale-value">{{ $response->answer }}</div>
                                    @if(isset($response->question->settings['scale_min_label']) || isset($response->question->settings['scale_max_label']))
                                        <div class="scale-labels">
                                            {{ $response->question->settings['scale_min_label'] ?? '' }} - 
                                            {{ $response->question->settings['scale_max_label'] ?? '' }}
                                        </div>
                                    @endif
                                </div>
                            @elseif($response->answer)
                                <div class="answer-text">{{ Str::limit($response->answer, 150) }}</div>
                            @else
                                <div class="answer-text empty">Tidak dijawab</div>
                            @endif
                        </div>
                    @empty
                        <div class="answer-item">
                            <div class="answer-text empty">Belum ada jawaban untuk survei ini</div>
                        </div>
                    @endforelse
                    
                    @if($survey->responses->count() > 5)
                        <div class="answer-item" style="border-left-color: #17a2b8; background: #e8f4f8;">
                            <div class="answer-text" style="color: #17a2b8; font-weight: 600;">
                                <i class="fas fa-plus-circle"></i>
                                {{ $survey->responses->count() - 5 }} jawaban lainnya. Klik "Detail" untuk melihat semua.
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    <!-- Pagination -->
    <div class="pagination-container">
        {{ $surveys->appends(request()->query())->links('custom-pagination') }}
    </div>

@else
    <div class="empty-state">
        <i class="fas fa-users"></i>
        <h3>Belum Ada Responden</h3>
        <p>Belum ada yang mengisi survei. Bagikan link survei kepada target responden untuk mulai mengumpulkan data.</p>
        <a href="{{ route('survey.index') }}" class="btn btn-primary" style="margin-top: 20px;">
            <i class="fas fa-share"></i> Lihat Link Survei
        </a>
    </div>
@endif

<!-- Detail Modal -->
<div id="detailModal" style="display: none; position: fixed; top: 0; left: 0; right: 0; bottom: 0; background: rgba(0,0,0,0.8); z-index: 1000; overflow-y: auto;">
    <div style="max-width: 800px; margin: 50px auto; background: white; border-radius: 15px; overflow: hidden;">
        <div style="background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%); color: white; padding: 25px 30px; display: flex; justify-content: space-between; align-items: center;">
            <h3><i class="fas fa-user"></i> Detail Responden</h3>
            <button onclick="closeDetail()" style="background: none; border: none; color: white; font-size: 24px; cursor: pointer;">&times;</button>
        </div>
        <div id="detailContent" style="padding: 30px; max-height: 600px; overflow-y: auto;">
            <!-- Content will be loaded here -->
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Search and Filter Functions
    function filterResponses() {
        const searchTerm = document.getElementById('searchInput').value.toLowerCase();
        const genderFilter = document.getElementById('genderFilter').value;
        const dateFilter = document.getElementById('dateFilter').value;
        
        const responseCards = document.querySelectorAll('.response-card');
        
        responseCards.forEach(card => {
            const surveyText = card.textContent.toLowerCase();
            const surveyId = card.dataset.surveyId;
            
            let showCard = true;
            
            // Text search
            if (searchTerm && !surveyText.includes(searchTerm)) {
                showCard = false;
            }
            
            // Gender filter
            if (genderFilter) {
                const genderIcon = card.querySelector('.fa-mars, .fa-venus');
                const isLakiLaki = genderIcon && genderIcon.classList.contains('fa-mars');
                if (genderFilter === 'laki_laki' && !isLakiLaki) showCard = false;
                if (genderFilter === 'perempuan' && isLakiLaki) showCard = false;
            }
            
            // Date filter (basic implementation)
            // Note: For production, this should be handled server-side
            
            card.style.display = showCard ? 'block' : 'none';
        });
    }

    // Real-time search
    document.getElementById('searchInput').addEventListener('input', function() {
        clearTimeout(this.searchTimeout);
        this.searchTimeout = setTimeout(filterResponses, 300);
    });

    // View Detail Function
    function viewDetail(surveyId) {
        const modal = document.getElementById('detailModal');
        const content = document.getElementById('detailContent');
        
        content.innerHTML = '<div style="text-align: center; padding: 40px;"><i class="fas fa-spinner fa-spin" style="font-size: 24px; color: #5a9b9e;"></i><br>Memuat data...</div>';
        modal.style.display = 'block';
        
        // Simulate API call (replace with actual AJAX call)
        setTimeout(() => {
            // This should be replaced with actual AJAX call to get full survey details
            content.innerHTML = `
                <div style="text-align: center; color: #7f8c8d;">
                    <i class="fas fa-info-circle" style="font-size: 48px; margin-bottom: 20px;"></i>
                    <h4>Fitur Detail Responden</h4>
                    <p>Implementasi penuh memerlukan endpoint API untuk mengambil detail lengkap survei ID: ${surveyId}</p>
                    <p>Fitur ini akan menampilkan semua jawaban responden dalam format yang lebih detail.</p>
                </div>
            `;
        }, 1000);
    }

    // Close Detail Modal
    function closeDetail() {
        document.getElementById('detailModal').style.display = 'none';
    }

    // Delete Survey Function
    function deleteSurvey(surveyId) {
        if (confirm('Yakin ingin menghapus data responden ini?\n\nData yang dihapus tidak dapat dikembalikan.')) {
            // Create form and submit
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admin/survey/${surveyId}`;
            form.innerHTML = `
                @csrf
                @method('DELETE')
            `;
            document.body.appendChild(form);
            form.submit();
        }
    }

    // Close modal when clicking outside
    document.getElementById('detailModal').addEventListener('click', function(e) {
        if (e.target === this) {
            closeDetail();
        }
    });

    // Keyboard shortcuts
    document.addEventListener('keydown', function(e) {
        // Escape to close modal
        if (e.key === 'Escape') {
            closeDetail();
        }
        
        // Ctrl+F to focus search
        if (e.ctrlKey && e.key === 'f') {
            e.preventDefault();
            document.getElementById('searchInput').focus();
        }
    });

    // Auto-refresh every 30 seconds (optional)
    setInterval(function() {
        // You can implement auto-refresh functionality here
        // window.location.reload();
    }, 30000);
</script>
@endpush