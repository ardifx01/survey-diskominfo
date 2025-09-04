{{-- resources/views/admin/footer-links/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Footer Link - Admin')
@section('active-footer-links', 'active')
@section('page-title', 'Tambah Footer Link')
@section('page-subtitle', 'Tambahkan link baru untuk footer website')

@section('breadcrumb')
<div class="breadcrumb">
    <a href="{{ route('admin.dashboard') }}">Dashboard</a>
    <span class="breadcrumb-separator">></span>
    <a href="{{ route('admin.footer-links.index') }}">Footer Links</a>
    <span class="breadcrumb-separator">></span>
    <span>Tambah Link</span>
</div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 600px;
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

    .form-select {
        width: 100%;
        padding: 15px 18px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #fff;
        font-family: inherit;
    }

    .form-select:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .form-help {
        font-size: 14px;
        color: #7f8c8d;
        margin-top: 5px;
    }

    .category-cards {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .category-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
        text-align: center;
    }

    .category-card:hover {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.05);
    }

    .category-card.selected {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.1);
    }

    .category-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .category-icon {
        font-size: 24px;
        color: #5a9b9e;
        margin-bottom: 10px;
    }

    .category-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .category-description {
        color: #7f8c8d;
        font-size: 14px;
        line-height: 1.4;
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
        padding: 12px 25px;
        border: none;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
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

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
    }

    .error-message {
        color: #dc3545;
        font-size: 14px;
        margin-top: 5px;
    }

    @media (max-width: 768px) {
        .form-container {
            margin: 0;
            border-radius: 8px;
        }

        .form-body {
            padding: 20px;
        }

        .category-cards {
            grid-template-columns: 1fr;
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
        <div class="form-title"><i class="fas fa-link"></i> Tambah Footer Link</div>
        <div class="form-subtitle">Tambahkan link baru yang akan ditampilkan di footer website</div>
    </div>

    <form method="POST" action="{{ route('admin.footer-links.store') }}" class="form-body">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="title">Judul Link *</label>
            <input 
                type="text" 
                id="title" 
                name="title" 
                class="form-input" 
                placeholder="Contoh: Website Resmi, Tentang Kami, dll" 
                value="{{ old('title') }}"
                required
            >
            @error('title')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">Nama link yang akan ditampilkan di footer</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="url">URL Link *</label>
            <input 
                type="url" 
                id="url" 
                name="url" 
                class="form-input" 
                placeholder="https://example.com" 
                value="{{ old('url') }}"
                required
            >
            @error('url')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">URL lengkap dengan https:// atau http://</div>
        </div>

        <div class="form-group">
            <label class="form-label">Kategori Link *</label>
            <div class="category-cards">
                <div class="category-card {{ old('category') == 'layanan' ? 'selected' : '' }}" onclick="selectCategory('layanan')">
                    <input type="radio" name="category" value="layanan" id="category_layanan" {{ old('category') == 'layanan' ? 'checked' : '' }}>
                    <div class="category-icon">
                        <i class="fas fa-cogs"></i>
                    </div>
                    <div class="category-title">Layanan</div>
                    <div class="category-description">Link untuk layanan yang disediakan</div>
                </div>

                <div class="category-card {{ old('category') == 'informasi' ? 'selected' : '' }}" onclick="selectCategory('informasi')">
                    <input type="radio" name="category" value="informasi" id="category_informasi" {{ old('category') == 'informasi' ? 'checked' : '' }}>
                    <div class="category-icon">
                        <i class="fas fa-info-circle"></i>
                    </div>
                    <div class="category-title">Informasi</div>
                    <div class="category-description">Link untuk informasi umum</div>
                </div>
            </div>
            @error('category')
                <div class="error-message">{{ $message }}</div>
            @enderror
            <div class="form-help">Pilih kategori untuk menentukan pengelompokan link di footer</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.footer-links.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Simpan Link
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function selectCategory(category) {
        // Remove selected class from all cards
        document.querySelectorAll('.category-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to clicked card
        event.currentTarget.classList.add('selected');
        
        // Check the radio button
        document.getElementById('category_' + category).checked = true;
    }

    // Initialize form state
    document.addEventListener('DOMContentLoaded', function() {
        // Auto focus pada input pertama
        document.getElementById('title').focus();

        // Check if there's a selected category from old input
        const checkedCategory = document.querySelector('input[name="category"]:checked');
        if (checkedCategory) {
            const card = checkedCategory.closest('.category-card');
            if (card) {
                card.classList.add('selected');
            }
        }
    });

    // Form validation
    document.getElementById('questionForm')?.addEventListener('submit', function(e) {
        const selectedCategory = document.querySelector('input[name="category"]:checked');
        
        if (!selectedCategory) {
            e.preventDefault();
            alert('Silakan pilih kategori link.');
            return;
        }
    });
</script>
@endpush