{{-- resources/views/admin/assets/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Upload Asset - Admin Survei')
@section('active-assets', 'active')
@section('page-title', 'Upload Asset Baru')
@section('page-subtitle', 'Upload logo atau asset gambar untuk sistem')

@section('header-actions')
<div class="header-actions">
    <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">
        <span class="btn-icon">←</span>
        Kembali
    </a>
</div>
@endsection

@push('styles')
<style>
    .form-container {
        max-width: 600px;
        margin: 0 auto;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .form-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 25px 30px;
        text-align: center;
    }

    .form-title {
        font-size: 20px;
        font-weight: 600;
        margin-bottom: 5px;
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
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .form-input, .form-select, .form-textarea {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 14px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus, .form-select:focus, .form-textarea:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .form-textarea {
        resize: vertical;
        min-height: 80px;
    }

    .file-upload-area {
        border: 2px dashed #e9ecef;
        border-radius: 8px;
        padding: 40px 20px;
        text-align: center;
        transition: all 0.3s ease;
        background: #f8f9fa;
        cursor: pointer;
        position: relative;
        overflow: hidden;
    }

    .file-upload-area:hover {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.05);
    }

    .file-upload-area.dragover {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.1);
    }

    .file-upload-icon {
        font-size: 48px;
        color: #bdc3c7;
        margin-bottom: 15px;
    }

    .file-upload-text {
        font-size: 16px;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .file-upload-subtext {
        font-size: 12px;
        color: #95a5a6;
    }

    .file-input {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        opacity: 0;
        cursor: pointer;
    }

    .file-preview {
        display: none;
        margin-top: 15px;
        padding: 15px;
        background: white;
        border: 1px solid #e9ecef;
        border-radius: 8px;
    }

    .file-preview-img {
        max-width: 200px;
        max-height: 150px;
        border-radius: 4px;
        margin-bottom: 10px;
    }

    .file-preview-info {
        font-size: 12px;
        color: #7f8c8d;
    }

    .form-help {
        font-size: 12px;
        color: #95a5a6;
        margin-top: 5px;
    }

    .form-error {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
    }

    .type-info {
        background: #f8f9fa;
        border-left: 4px solid #5a9b9e;
        padding: 15px;
        margin-top: 10px;
        border-radius: 0 8px 8px 0;
    }

    .type-info h5 {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
    }

    .type-info p {
        font-size: 12px;
        color: #7f8c8d;
        margin: 0;
        line-height: 1.4;
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: center;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
        margin-top: 30px;
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
        font-size: 14px;
        min-width: 120px;
        justify-content: center;
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
        background: #95a5a6;
        color: white;
    }

    .btn-secondary:hover {
        background: #7f8c8d;
        transform: translateY(-2px);
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="form-title">Upload Asset Baru</div>
        <div class="form-subtitle">Upload logo atau asset gambar untuk sistem survei</div>
    </div>

    <div class="form-body">
        <form method="POST" action="{{ route('admin.assets.store') }}" enctype="multipart/form-data">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="type">Tipe Asset</label>
                <select id="type" name="type" class="form-select" required onchange="showTypeInfo()">
                    <option value="">Pilih Tipe Asset</option>
                    @foreach($availableTypes as $key => $label)
                    <option value="{{ $key }}" {{ old('type') === $key ? 'selected' : '' }}>{{ $label }}</option>
                    @endforeach
                </select>
                @error('type')
                    <div class="form-error">{{ $message }}</div>
                @enderror

                <div id="type-logo-info" class="type-info" style="display: none;">
                    <h5>Logo</h5>
                    <p>Logo yang akan ditampilkan di header halaman survei. Anda bisa menambahkan beberapa logo sekaligus.</p>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="file">File Gambar</label>
                <div class="file-upload-area" id="fileUploadArea">
                    <div class="file-upload-icon"></div>
                    <div class="file-upload-text">Klik atau seret file gambar ke sini</div>
                    <div class="file-upload-subtext">Format: JPEG, PNG, JPG, GIF, SVG (Max: 2MB)</div>
                    <input type="file" id="file" name="file" class="file-input" accept="image/*" required onchange="previewFile()">
                </div>
                
                <div class="file-preview" id="filePreview">
                    <img id="previewImg" class="file-preview-img" src="" alt="Preview">
                    <div class="file-preview-info">
                        <div id="previewName"></div>
                        <div id="previewSize"></div>
                    </div>
                </div>
                
                @error('file')
                    <div class="form-error">{{ $message }}</div>
                @enderror
                <div class="form-help">Ukuran file maksimal 2MB. Format yang didukung: JPEG, PNG, JPG, GIF, SVG</div>
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.assets.index') }}" class="btn btn-secondary">
                    ← Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Upload Logo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showTypeInfo() {
    // Hide all info boxes
    const infoBoxes = document.querySelectorAll('.type-info');
    infoBoxes.forEach(box => box.style.display = 'none');
    
    // Show selected info box
    const selectedType = document.getElementById('type').value;
    if (selectedType) {
        const infoBox = document.getElementById('type-' + selectedType + '-info');
        if (infoBox) {
            infoBox.style.display = 'block';
        }
    }
}

function previewFile() {
    const fileInput = document.getElementById('file');
    const filePreview = document.getElementById('filePreview');
    const previewImg = document.getElementById('previewImg');
    const previewName = document.getElementById('previewName');
    const previewSize = document.getElementById('previewSize');
    
    if (fileInput.files && fileInput.files[0]) {
        const file = fileInput.files[0];
        const reader = new FileReader();
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewName.textContent = file.name;
            previewSize.textContent = formatFileSize(file.size);
            filePreview.style.display = 'block';
        };
        
        reader.readAsDataURL(file);
    }
}

function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
}

// Drag and drop functionality
const fileUploadArea = document.getElementById('fileUploadArea');
const fileInput = document.getElementById('file');

fileUploadArea.addEventListener('dragover', function(e) {
    e.preventDefault();
    e.stopPropagation();
    fileUploadArea.classList.add('dragover');
});

fileUploadArea.addEventListener('dragleave', function(e) {
    e.preventDefault();
    e.stopPropagation();
    fileUploadArea.classList.remove('dragover');
});

fileUploadArea.addEventListener('drop', function(e) {
    e.preventDefault();
    e.stopPropagation();
    fileUploadArea.classList.remove('dragover');
    
    const files = e.dataTransfer.files;
    if (files.length > 0) {
        fileInput.files = files;
        previewFile();
    }
});
</script>
@endsection