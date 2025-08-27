{{-- resources/views/admin/questions/create-question.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah Pertanyaan - Admin Survei')
@section('active-questions', 'active')
@section('page-title', 'Tambah Pertanyaan')
@section('page-subtitle', 'Buat pertanyaan baru untuk bagian: {{ $section->title }}')

@section('breadcrumb')
<div class="breadcrumb">
    <a href="{{ route('admin.questions.index') }}">Pertanyaan</a>
    <span class="breadcrumb-separator">></span>
    <span>{{ $section->title }}</span>
    <span class="breadcrumb-separator">></span>
    <span>Tambah Pertanyaan</span>
</div>
@endsection

@push('styles')
<style>
    /* Form Styles */
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        max-width: 900px;
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

    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-top: 10px;
    }

    .checkbox-input {
        width: auto;
        margin: 0;
    }

    .checkbox-label {
        margin: 0;
        font-weight: normal;
        cursor: pointer;
    }

    /* Question Type Styles */
    .question-type-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 15px;
        margin-top: 10px;
    }

    .type-card {
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 15px;
        cursor: pointer;
        transition: all 0.3s ease;
        background: white;
    }

    .type-card:hover {
        border-color: #5a9b9e;
        background: #f8fdfd;
    }

    .type-card.selected {
        border-color: #5a9b9e;
        background: #e8f4f8;
    }

    .type-card input[type="radio"] {
        display: none;
    }

    .type-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .type-description {
        font-size: 14px;
        color: #7f8c8d;
    }

    /* Options Management */
    .options-container {
        display: none;
        margin-top: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .options-container.show {
        display: block;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 10px;
    }

    .option-input {
        flex: 1;
        padding: 10px 15px;
        border: 1px solid #dee2e6;
        border-radius: 6px;
        font-size: 14px;
    }

    .btn-remove-option {
        background: #dc3545;
        color: white;
        border: none;
        padding: 8px 12px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 12px;
    }

    .btn-add-option {
        background: #28a745;
        color: white;
        border: none;
        padding: 10px 15px;
        border-radius: 6px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
    }

    /* Scale Settings */
    .scale-container {
        display: none;
        margin-top: 15px;
        padding: 20px;
        background: #f8f9fa;
        border-radius: 8px;
        border: 1px solid #e9ecef;
    }

    .scale-container.show {
        display: block;
    }

    .scale-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
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

    @media (max-width: 768px) {
        .form-container {
            margin: 0;
            border-radius: 8px;
        }

        .form-body {
            padding: 20px;
        }

        .question-type-cards {
            grid-template-columns: 1fr;
        }

        .scale-row {
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
        <div class="form-title">❓ Detail Pertanyaan</div>
        <div class="form-subtitle">Isi informasi lengkap pertanyaan yang akan ditambahkan</div>
    </div>

    <form method="POST" action="{{ route('admin.questions.store-question', $section->id) }}" class="form-body" id="questionForm">
        @csrf
        
        <div class="form-group">
            <label class="form-label" for="question_text">Teks Pertanyaan *</label>
            <textarea 
                id="question_text" 
                name="question_text" 
                class="form-input form-textarea" 
                placeholder="Tuliskan pertanyaan yang akan ditampilkan kepada responden"
                required
            >{{ old('question_text') }}</textarea>
            <div class="form-help">Gunakan bahasa yang jelas dan mudah dipahami</div>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Pertanyaan *</label>
            <div class="question-type-cards">
                <div class="type-card" onclick="selectType('short_text')">
                    <input type="radio" name="question_type" value="short_text" id="type_short_text" {{ old('question_type') == 'short_text' ? 'checked' : '' }}>
                    <div class="type-title">📝 Jawaban Singkat</div>
                    <div class="type-description">Untuk teks pendek seperti nama, email, dll</div>
                </div>

                <div class="type-card" onclick="selectType('long_text')">
                    <input type="radio" name="question_type" value="long_text" id="type_long_text" {{ old('question_type') == 'long_text' ? 'checked' : '' }}>
                    <div class="type-title">📄 Paragraf</div>
                    <div class="type-description">Untuk jawaban panjang atau saran</div>
                </div>

                <div class="type-card" onclick="selectType('multiple_choice')">
                    <input type="radio" name="question_type" value="multiple_choice" id="type_multiple_choice" {{ old('question_type') == 'multiple_choice' ? 'checked' : '' }}>
                    <div class="type-title">🔘 Pilihan Ganda</div>
                    <div class="type-description">Pilih satu dari beberapa opsi</div>
                </div>

                <div class="type-card" onclick="selectType('checkbox')">
                    <input type="radio" name="question_type" value="checkbox" id="type_checkbox" {{ old('question_type') == 'checkbox' ? 'checked' : '' }}>
                    <div class="type-title">☑️ Kotak Centang</div>
                    <div class="type-description">Bisa pilih lebih dari satu opsi</div>
                </div>

                <div class="type-card" onclick="selectType('dropdown')">
                    <input type="radio" name="question_type" value="dropdown" id="type_dropdown" {{ old('question_type') == 'dropdown' ? 'checked' : '' }}>
                    <div class="type-title">📋 Drop-down</div>
                    <div class="type-description">Pilih satu dari menu turun</div>
                </div>

                <div class="type-card" onclick="selectType('file_upload')">
                    <input type="radio" name="question_type" value="file_upload" id="type_file_upload" {{ old('question_type') == 'file_upload' ? 'checked' : '' }}>
                    <div class="type-title">📎 Upload File</div>
                    <div class="type-description">Responden bisa kirim file</div>
                </div>

                <div class="type-card" onclick="selectType('linear_scale')">
                    <input type="radio" name="question_type" value="linear_scale" id="type_linear_scale" {{ old('question_type') == 'linear_scale' ? 'checked' : '' }}>
                    <div class="type-title">📊 Skala Linier</div>
                    <div class="type-description">Memberi nilai dengan angka (1-5, 1-10, dll)</div>
                </div>
            </div>
        </div>

        <!-- Options Container for Multiple Choice, Checkbox, Dropdown -->
        <div id="optionsContainer" class="options-container">
            <h4 style="margin-bottom: 15px;">⚙️ Opsi Jawaban</h4>
            <div id="optionsList">
                <div class="option-item">
                    <input type="text" name="options[]" class="option-input" placeholder="Opsi 1" value="{{ old('options.0') }}">
                    <button type="button" class="btn-remove-option" onclick="removeOption(this)">❌</button>
                </div>
                <div class="option-item">
                    <input type="text" name="options[]" class="option-input" placeholder="Opsi 2" value="{{ old('options.1') }}">
                    <button type="button" class="btn-remove-option" onclick="removeOption(this)">❌</button>
                </div>
            </div>
            <button type="button" class="btn-add-option" onclick="addOption()">➕ Tambah Opsi</button>
        </div>

        <!-- Scale Settings for Linear Scale -->
        <div id="scaleContainer" class="scale-container">
            <h4 style="margin-bottom: 15px;">📊 Pengaturan Skala</h4>
            <div class="scale-row">
                <div>
                    <label class="form-label" for="scale_min">Nilai Minimum</label>
                    <input type="number" id="scale_min" name="scale_min" class="form-input" value="{{ old('scale_min', 1) }}" min="1" max="10">
                </div>
                <div>
                    <label class="form-label" for="scale_max">Nilai Maksimum</label>
                    <input type="number" id="scale_max" name="scale_max" class="form-input" value="{{ old('scale_max', 5) }}" min="1" max="10">
                </div>
            </div>
            <div class="scale-row">
                <div>
                    <label class="form-label" for="scale_min_label">Label Minimum (Opsional)</label>
                    <input type="text" id="scale_min_label" name="scale_min_label" class="form-input" placeholder="Contoh: Sangat Tidak Puas" value="{{ old('scale_min_label') }}">
                </div>
                <div>
                    <label class="form-label" for="scale_max_label">Label Maksimum (Opsional)</label>
                    <input type="text" id="scale_max_label" name="scale_max_label" class="form-input" placeholder="Contoh: Sangat Puas" value="{{ old('scale_max_label') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="is_required" name="is_required" class="checkbox-input" value="1" {{ old('is_required') ? 'checked' : '' }}>
                <label class="checkbox-label" for="is_required">Pertanyaan wajib dijawab</label>
            </div>
            <div class="form-help">Jika dicentang, responden harus mengisi pertanyaan ini untuk melanjutkan</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                ← Batal
            </a>
            <button type="submit" class="btn btn-primary">
                💾 Simpan Pertanyaan
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    function selectType(type) {
        // Remove selected class from all cards
        document.querySelectorAll('.type-card').forEach(card => {
            card.classList.remove('selected');
        });

        // Add selected class to clicked card
        event.currentTarget.classList.add('selected');

        // Check the radio button
        document.getElementById('type_' + type).checked = true;

        // Show/hide relevant containers
        const optionsContainer = document.getElementById('optionsContainer');
        const scaleContainer = document.getElementById('scaleContainer');

        // Hide both containers first
        optionsContainer.classList.remove('show');
        scaleContainer.classList.remove('show');

        // Show relevant container based on type
        if (['multiple_choice', 'checkbox', 'dropdown'].includes(type)) {
            optionsContainer.classList.add('show');
        } else if (type === 'linear_scale') {
            scaleContainer.classList.add('show');
        }
    }

    function addOption() {
        const optionsList = document.getElementById('optionsList');
        const optionCount = optionsList.children.length + 1;
        
        const optionItem = document.createElement('div');
        optionItem.className = 'option-item';
        optionItem.innerHTML = `
            <input type="text" name="options[]" class="option-input" placeholder="Opsi ${optionCount}">
            <button type="button" class="btn-remove-option" onclick="removeOption(this)">❌</button>
        `;
        
        optionsList.appendChild(optionItem);
    }

    function removeOption(button) {
        const optionItem = button.parentElement;
        const optionsList = document.getElementById('optionsList');
        
        if (optionsList.children.length > 2) {
            optionItem.remove();
            
            // Update placeholders
            const options = optionsList.querySelectorAll('.option-input');
            options.forEach((input, index) => {
                input.placeholder = `Opsi ${index + 1}`;
            });
        } else {
            alert('Minimal harus ada 2 opsi');
        }
    }

    // Initialize on page load
    document.addEventListener('DOMContentLoaded', function() {
        // Check if there's an old question type selected
        const checkedType = document.querySelector('input[name="question_type"]:checked');
        if (checkedType) {
            selectType(checkedType.value);
        }

        // Auto focus on question text
        document.getElementById('question_text').focus();
    });

    // Form validation
    document.getElementById('questionForm').addEventListener('submit', function(e) {
        const questionType = document.querySelector('input[name="question_type"]:checked');
        
        if (!questionType) {
            e.preventDefault();
            alert('Silakan pilih jenis pertanyaan');
            return;
        }

        // Validate options for multiple choice, checkbox, dropdown
        if (['multiple_choice', 'checkbox', 'dropdown'].includes(questionType.value)) {
            const options = document.querySelectorAll('input[name="options[]"]');
            const filledOptions = Array.from(options).filter(input => input.value.trim() !== '');
            
            if (filledOptions.length < 2) {
                e.preventDefault();
                alert('Minimal harus ada 2 opsi yang diisi');
                return;
            }
        }

        // Validate scale settings for linear scale
        if (questionType.value === 'linear_scale') {
            const scaleMin = parseInt(document.getElementById('scale_min').value);
            const scaleMax = parseInt(document.getElementById('scale_max').value);
            
            if (scaleMin >= scaleMax) {
                e.preventDefault();
                alert('Nilai maksimum harus lebih besar dari nilai minimum');
                return;
            }
        }
    });
</script>
@endpush