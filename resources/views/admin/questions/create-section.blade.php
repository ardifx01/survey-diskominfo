{{-- resources/views/admin/questions/create-section.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Bagian - Admin Survei')
@section('active-questions', 'active')
@section('page-title', 'Tambah Bagian Baru')
@section('page-subtitle', 'Buat bagian baru untuk mengelompokkan pertanyaan survei')

@section('breadcrumb')
<div class="breadcrumb">
    <a href="{{ route('admin.questions.index') }}">Pertanyaan</a>
    <span class="breadcrumb-separator">></span>
    <span>Tambah Bagian</span>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    /* Form Styles */
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 800px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
        color: white;
        padding: 25px 30px;
        border-radius: 12px 12px 0 0;
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 8px;
    }

    .form-subtitle {
        font-size: 14px;
        opacity: 0.9;
    }

    .form-body {
        padding: 30px;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 16px;
    }

    .form-input {
        width: 100%;
        padding: 15px 18px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #fff;
        font-family: inherit;
    }

    .form-input:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .form-textarea {
        min-height: 120px;
        resize: vertical;
    }

    .form-help {
        font-size: 14px;
        color: #7f8c8d;
        margin-top: 5px;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .btn {
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        font-size: 16px;
        display: inline-flex;
        align-items: center;
        gap: 8px;
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .btn:disabled {
        opacity: 0.6;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .tips-box {
        margin-top: 30px;
        padding: 20px;
        background: #e8f4f8;
        border-radius: 8px;
        border-left: 4px solid #5a9b9e;
    }

    .tips-title {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 16px;
        font-weight: 600;
    }

    .tips-list {
        color: #5a6c7d;
        line-height: 1.6;
    }

    .tips-list li {
        margin-bottom: 8px;
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 0;
            border-radius: 8px;
        }

        .form-body {
            padding: 20px;
        }

        .form-actions {
            flex-direction: column;
        }
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="form-title"><i class="fas fa-file-alt"></i> Informasi Bagian</div>
        <div class="form-subtitle">Isi detail bagian yang akan ditambahkan ke survei</div>
    </div>

    <form method="POST" action="{{ route('admin.questions.store-section') }}" class="form-body">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="title">Judul Bagian *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-input" 
                placeholder="Contoh: Data Diri, Evaluasi Layanan, dll" 
                value="{{ old('title') }}"
                required
            >
            <div class="form-help">Judul ini akan ditampilkan sebagai header bagian</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="description">Deskripsi Bagian</label>
            <textarea 
                id="description" 
                name="description" 
                class="form-input form-textarea" 
                placeholder="Jelaskan tujuan atau instruksi untuk bagian ini (opsional)"
            >{{ old('description') }}</textarea>
            <div class="form-help">Deskripsi akan ditampilkan di bawah judul untuk memberikan konteks kepada responden</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Bagian
            </button>
        </div>
    </form>
</div>

<div class="tips-box">
    <h4 class="tips-title"><i class="fas fa-lightbulb"></i> Tips Membuat Bagian</h4>
    <ul class="tips-list">
        <li><strong>Kelompokkan pertanyaan serupa:</strong> Misalnya "Data Diri", "Evaluasi Layanan", "Saran"</li>
        <li><strong>Urutan logis:</strong> Mulai dari informasi umum, lalu spesifik</li>
        <li><strong>Tidak terlalu panjang:</strong> Maksimal 5-7 pertanyaan per bagian</li>
        <li><strong>Judul yang jelas:</strong> Gunakan bahasa yang mudah dipahami responden</li>
    </ul>
</div>
@endsection

@push('scripts')
<script>
    // Auto focus pada input pertama
    document.addEventListener('DOMContentLoaded', function() {
        document.getElementById('title').focus();
    });

    // Preview judul saat mengetik
    document.getElementById('title').addEventListener('input', function() {
        const title = this.value.trim();
        const formTitle = document.querySelector('.form-title');
        if (title) {
            formTitle.innerHTML = `<i class="fas fa-file-alt"></i> ${title}`;
        } else {
            formTitle.innerHTML = '<i class="fas fa-file-alt"></i> Informasi Bagian';
        }
    });
</script>
@endpush