{{-- resources/views/admin/uploaded-files.blade.php --}}
@extends('layouts.admin')

@section('title', 'File yang Diupload - Admin Survei')
@section('active-files', 'active')
@section('page-title', 'File yang Diupload')
@section('page-subtitle', 'Kelola file yang diupload responden')

@section('header-actions')
<div class="header-actions">
    <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left"></i> Kembali ke Dashboard
    </a>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .files-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 6px 20px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .files-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 25px 30px;
    }

    .files-title {
        font-size: 24px;
        font-weight: 700;
        margin-bottom: 5px;
    }

    .files-subtitle {
        opacity: 0.9;
        font-size: 16px;
    }

    .files-body {
        padding: 0;
    }

    .file-item {
        display: flex;
        align-items: center;
        gap: 20px;
        padding: 25px 30px;
        border-bottom: 1px solid #f8f9fa;
        transition: background-color 0.3s ease;
    }

    .file-item:last-child {
        border-bottom: none;
    }

    .file-item:hover {
        background: #f8f9fa;
    }

    .file-icon {
        width: 50px;
        height: 50px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 20px;
        color: white;
        font-weight: 600;
    }

    .file-icon.image { background: #17a2b8; }
    .file-icon.document { background: #dc3545; }
    .file-icon.spreadsheet { background: #28a745; }
    .file-icon.presentation { background: #fd7e14; }
    .file-icon.archive { background: #6f42c1; }
    .file-icon.default { background: #6c757d; }

    .file-info {
        flex: 1;
    }

    .file-name {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .file-meta {
        display: flex;
        gap: 20px;
        color: #7f8c8d;
        font-size: 14px;
        flex-wrap: wrap;
    }

    .file-meta span {
        display: flex;
        align-items: center;
        gap: 5px;
    }

    .file-actions {
        display: flex;
        gap: 10px;
    }

    .action-btn {
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-size: 14px;
        font-weight: 600;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        gap: 6px;
    }

    .view-btn {
        background: #17a2b8;
        color: white;
    }

    .view-btn:hover {
        background: #138496;
        transform: translateY(-1px);
    }

    .download-btn {
        background: #28a745;
        color: white;
    }

    .download-btn:hover {
        background: #218838;
        transform: translateY(-1px);
    }

    .stats-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .stat-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-left: 4px solid #5a9b9e;
    }

    .stat-number {
        font-size: 32px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .empty-state {
        text-align: center;
        padding: 80px 20px;
        color: #7f8c8d;
    }

    .empty-state i {
        font-size: 64px;
        margin-bottom: 25px;
        opacity: 0.5;
    }

    .empty-state h3 {
        font-size: 28px;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .empty-state p {
        font-size: 18px;
        line-height: 1.6;
        margin-bottom: 30px;
    }

    .pagination-wrapper {
        margin-top: 30px;
        display: flex;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .file-item {
            flex-direction: column;
            text-align: center;
            gap: 15px;
        }

        .file-meta {
            justify-content: center;
        }

        .file-actions {
            justify-content: center;
        }

        .stats-cards {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }
    }
</style>
@endpush

@section('content')
<!-- Statistics Cards -->
<div class="stats-cards">
    <div class="stat-card">
        <div class="stat-number">{{ $fileResponses->total() }}</div>
        <div class="stat-label">Total File</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $fileResponses->where('answer_data.mime_type', 'like', 'image/%')->count() }}</div>
        <div class="stat-label">Gambar</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ $fileResponses->where('answer_data.mime_type', 'like', 'application/%')->count() }}</div>
        <div class="stat-label">Dokumen</div>
    </div>
    <div class="stat-card">
        <div class="stat-number">{{ number_format($fileResponses->sum(function($item) { return $item->answer_data['size'] ?? 0; }) / 1024 / 1024, 2) }}</div>
        <div class="stat-label">MB Total</div>
    </div>
</div>

<!-- Files List -->
@if($fileResponses->count() > 0)
    <div class="files-container">
        <div class="files-header">
            <div class="files-title">
                <i class="fas fa-file-upload"></i>
                File yang Diupload
            </div>
            <div class="files-subtitle">
                Daftar semua file yang diupload oleh responden survei
            </div>
        </div>

        <div class="files-body">
            @foreach($fileResponses as $fileResponse)
                @php
                    $mimeType = $fileResponse->answer_data['mime_type'] ?? '';
                    $size = $fileResponse->answer_data['size'] ?? 0;
                    $extension = $fileResponse->answer_data['extension'] ?? '';
                    
                    // Determine file icon class
                    $iconClass = 'default';
                    $iconType = 'fas fa-file';
                    
                    if (str_starts_with($mimeType, 'image/')) {
                        $iconClass = 'image';
                        $iconType = 'fas fa-image';
                    } elseif (in_array($extension, ['pdf', 'doc', 'docx'])) {
                        $iconClass = 'document';
                        $iconType = 'fas fa-file-alt';
                    } elseif (in_array($extension, ['xls', 'xlsx', 'csv'])) {
                        $iconClass = 'spreadsheet';
                        $iconType = 'fas fa-file-excel';
                    } elseif (in_array($extension, ['ppt', 'pptx'])) {
                        $iconClass = 'presentation';
                        $iconType = 'fas fa-file-powerpoint';
                    } elseif (in_array($extension, ['zip', 'rar', '7z'])) {
                        $iconClass = 'archive';
                        $iconType = 'fas fa-file-archive';
                    }
                @endphp

                <div class="file-item">
                    <div class="file-icon {{ $iconClass }}">
                        <i class="{{ $iconType }}"></i>
                    </div>

                    <div class="file-info">
                        <div class="file-name">{{ $fileResponse->answer_data['filename'] ?? 'File tidak diketahui' }}</div>
                        <div class="file-meta">
                            <span><i class="fas fa-question-circle"></i> {{ $fileResponse->question->question_text }}</span>
                            <span><i class="fas fa-user"></i> Responden #{{ $fileResponse->survey_id }}</span>
                            <span><i class="fas fa-calendar-alt"></i> {{ $fileResponse->created_at->format('d/m/Y H:i') }}</span>
                            @if($size > 0)
                                <span><i class="fas fa-hdd"></i> {{ number_format($size / 1024, 1) }} KB</span>
                            @endif
                            @if($mimeType)
                                <span><i class="fas fa-info-circle"></i> {{ $mimeType }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="file-actions">
                        @if(str_starts_with($mimeType, 'image/'))
                            <a href="{{ route('admin.viewFile', $fileResponse->id) }}" target="_blank" class="action-btn view-btn">
                                <i class="fas fa-eye"></i> Lihat
                            </a>
                        @endif
                        <a href="{{ route('admin.downloadFile', $fileResponse->id) }}" class="action-btn download-btn">
                            <i class="fas fa-download"></i> Download
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <!-- Pagination -->
    <div class="pagination-wrapper">
        {{ $fileResponses->links() }}
    </div>
@else
    <div class="files-container">
        <div class="empty-state">
            <i class="fas fa-file-upload"></i>
            <h3>Belum Ada File</h3>
            <p>Belum ada responden yang mengupload file. File yang diupload melalui pertanyaan file upload akan muncul di sini.</p>
            <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
                <i class="fas fa-plus"></i> Buat Pertanyaan File Upload
            </a>
        </div>
    </div>
@endif
@endsection