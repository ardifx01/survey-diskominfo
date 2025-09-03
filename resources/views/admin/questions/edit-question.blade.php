{{-- resources/views/admin/questions/edit-question.blade.php --}}
@extends('layouts.admin')

@section('title', 'Edit Pertanyaan - Admin Survei')
@section('active-questions', 'active')
@section('page-title', 'Edit Pertanyaan')
@section('page-subtitle', 'Perbarui pertanyaan: {{ $question->section->title }}')

@section('breadcrumb')
<div class="breadcrumb">
    <a href="{{ route('admin.questions.index') }}">Pertanyaan</a>
    <span class="breadcrumb-separator">></span>
    <span>{{ $question->section->title }}</span>
    <span class="breadcrumb-separator">></span>
    <span>Edit Pertanyaan</span>
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
        min-height: 100px;
        resize: vertical;
    }

    .form-help {
        font-size: 14px;
        color: #7f8c8d;
        margin-top: 5px;
    }

    /* Question Type Cards */
    .question-type-cards {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
        gap: 15px;
        margin-top: 15px;
    }

    .type-card {
        border: 2px solid #e9ecef;
        border-radius: 10px;
        padding: 20px;
        cursor: pointer;
        transition: all 0.3s ease;
        position: relative;
    }

    .type-card:hover {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.05);
    }

    .type-card.selected {
        border-color: #5a9b9e;
        background: rgba(90, 155, 158, 0.1);
    }

    .type-card input[type="radio"] {
        position: absolute;
        opacity: 0;
        pointer-events: none;
    }

    .type-title {
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 8px;
        font-size: 16px;
    }

    .type-description {
        color: #7f8c8d;
        font-size: 14px;
        line-height: 1.4;
    }

    /* Options Container */
    .options-container, .scale-container {
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        padding: 20px;
        margin-top: 15px;
        opacity: 0;
        max-height: 0;
        overflow: hidden;
        transition: all 0.3s ease;
    }

    .options-container.show, .scale-container.show {
        opacity: 1;
        max-height: 500px;
    }

    .option-item {
        display: flex;
        align-items: center;
        gap: 10px;
        margin-bottom: 12px;
    }

    .option-input {
        flex: 1;
        padding: 12px 15px;
        border: 1px solid #ddd;
        border-radius: 6px;
        font-size: 14px;
    }

    .remove-option {
        background: #dc3545;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 8px 12px;
        cursor: pointer;
        font-size: 12px;
        transition: background 0.3s ease;
    }

    .remove-option:hover {
        background: #c82333;
    }

    .add-option {
        background: #28a745;
        color: white;
        border: none;
        border-radius: 6px;
        padding: 10px 15px;
        cursor: pointer;
        font-size: 14px;
        margin-top: 10px;
        transition: background 0.3s ease;
    }

    .add-option:hover {
        background: #218838;
    }

    /* Scale Settings */
    .scale-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-bottom: 15px;
    }

    /* Checkbox */
    .checkbox-group {
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .checkbox-input {
        width: 18px;
        height: 18px;
        accent-color: #5a9b9e;
    }

    .checkbox-label {
        color: #2c3e50;
        font-weight: 500;
        margin: 0;
        cursor: pointer;
    }

    /* Form Actions */
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
        <div class="form-title"><i class="fas fa-edit"></i> Edit Pertanyaan</div>
        <div class="form-subtitle">Perbarui informasi pertanyaan yang sudah ada</div>
    </div>

    <form method="POST" action="{{ route('admin.questions.update-question', $question->id) }}" class="form-body" id="questionForm">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label class="form-label" for="question_text">Teks Pertanyaan *</label>
            <textarea 
                id="question_text" 
                name="question_text" 
                class="form-input form-textarea" 
                placeholder="Tuliskan pertanyaan yang akan ditampilkan kepada responden"
                required
            >{{ old('question_text', $question->question_text) }}</textarea>
            <div class="form-help">Gunakan bahasa yang jelas dan mudah dipahami</div>
        </div>

        <div class="form-group">
            <label class="form-label" for="question_description">Deskripsi Pertanyaan (Opsional)</label>
            <textarea 
                id="question_description" 
                name="question_description" 
                class="form-input form-textarea" 
                placeholder="Contoh: Penulisan nama menggunakan huruf kapital dan gelar menyesuaikan, Contoh : INTANIA SARAH, S.Kom."
                style="min-height: 80px;"
            >{{ old('question_description', $question->question_description) }}</textarea>
            <div class="form-help">Deskripsi akan ditampilkan di bawah pertanyaan untuk memberikan panduan kepada responden</div>
        </div>

        <div class="form-group">
            <label class="form-label">Jenis Pertanyaan *</label>
            <div class="question-type-cards">
                <div class="type-card {{ old('question_type', $question->question_type) == 'short_text' ? 'selected' : '' }}" onclick="selectType('short_text')">
                    <input type="radio" name="question_type" value="short_text" id="type_short_text" {{ old('question_type', $question->question_type) == 'short_text' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-edit"></i> Jawaban Singkat</div>
                    <div class="type-description">Untuk teks pendek seperti nama, email, dll</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'long_text' ? 'selected' : '' }}" onclick="selectType('long_text')">
                    <input type="radio" name="question_type" value="long_text" id="type_long_text" {{ old('question_type', $question->question_type) == 'long_text' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-file-alt"></i> Paragraf</div>
                    <div class="type-description">Untuk jawaban panjang atau saran</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'selected' : '' }}" onclick="selectType('multiple_choice')">
                    <input type="radio" name="question_type" value="multiple_choice" id="type_multiple_choice" {{ old('question_type', $question->question_type) == 'multiple_choice' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-dot-circle"></i> Pilihan Ganda</div>
                    <div class="type-description">Pilih satu dari beberapa opsi</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'checkbox' ? 'selected' : '' }}" onclick="selectType('checkbox')">
                    <input type="radio" name="question_type" value="checkbox" id="type_checkbox" {{ old('question_type', $question->question_type) == 'checkbox' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-check-square"></i> Kotak Centang</div>
                    <div class="type-description">Bisa pilih lebih dari satu opsi</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'dropdown' ? 'selected' : '' }}" onclick="selectType('dropdown')">
                    <input type="radio" name="question_type" value="dropdown" id="type_dropdown" {{ old('question_type', $question->question_type) == 'dropdown' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-list"></i> Drop-down</div>
                    <div class="type-description">Pilih satu dari menu turun</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'file_upload' ? 'selected' : '' }}" onclick="selectType('file_upload')">
                    <input type="radio" name="question_type" value="file_upload" id="type_file_upload" {{ old('question_type', $question->question_type) == 'file_upload' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-paperclip"></i> Upload File</div>
                    <div class="type-description">Responden bisa kirim file</div>
                </div>

                <div class="type-card {{ old('question_type', $question->question_type) == 'linear_scale' ? 'selected' : '' }}" onclick="selectType('linear_scale')">
                    <input type="radio" name="question_type" value="linear_scale" id="type_linear_scale" {{ old('question_type', $question->question_type) == 'linear_scale' ? 'checked' : '' }}>
                    <div class="type-title"><i class="fas fa-sliders-h"></i> Skala Linier</div>
                    <div class="type-description">Rating dengan skala angka</div>
                </div>
            </div>
        </div>

        <!-- Options Container untuk Multiple Choice, Checkbox, Dropdown -->
        <div class="options-container {{ in_array(old('question_type', $question->question_type), ['multiple_choice', 'checkbox', 'dropdown']) ? 'show' : '' }}" id="optionsContainer">
            <h4 style="margin-bottom: 15px; color: #2c3e50;"><i class="fas fa-list"></i> Opsi Pilihan</h4>
            <div id="optionsList">
                @if(old('options'))
                    @foreach(old('options') as $index => $option)
                    <div class="option-item">
                        <input type="text" name="options[]" class="option-input" placeholder="Opsi {{ $index + 1 }}" value="{{ $option }}">
                        <button type="button" class="remove-option" onclick="removeOption(this)">Hapus</button>
                    </div>
                    @endforeach
                @elseif($question->options)
                    @foreach($question->options as $index => $option)
                    <div class="option-item">
                        <input type="text" name="options[]" class="option-input" placeholder="Opsi {{ $index + 1 }}" value="{{ $option }}">
                        <button type="button" class="remove-option" onclick="removeOption(this)">Hapus</button>
                    </div>
                    @endforeach
                @else
                    <div class="option-item">
                        <input type="text" name="options[]" class="option-input" placeholder="Opsi 1">
                        <button type="button" class="remove-option" onclick="removeOption(this)" style="display: none;">Hapus</button>
                    </div>
                    <div class="option-item">
                        <input type="text" name="options[]" class="option-input" placeholder="Opsi 2">
                        <button type="button" class="remove-option" onclick="removeOption(this)" style="display: none;">Hapus</button>
                    </div>
                @endif
            </div>
            <button type="button" class="add-option" onclick="addOption()">
                <i class="fas fa-plus"></i> Tambah Opsi
            </button>
        </div>

        <!-- Scale Container untuk Linear Scale -->
        <div class="scale-container {{ old('question_type', $question->question_type) == 'linear_scale' ? 'show' : '' }}" id="scaleContainer">
            <h4 style="margin-bottom: 15px; color: #2c3e50;"><i class="fas fa-sliders-h"></i> Pengaturan Skala</h4>
            <div class="scale-row">
                <div>
                    <label class="form-label" for="scale_min">Nilai Minimum *</label>
                    <input type="number" id="scale_min" name="scale_min" class="form-input" min="1" max="10" value="{{ old('scale_min', $question->settings['scale_min'] ?? 1) }}">
                </div>
                <div>
                    <label class="form-label" for="scale_max">Nilai Maksimum *</label>
                    <input type="number" id="scale_max" name="scale_max" class="form-input" min="1" max="10" value="{{ old('scale_max', $question->settings['scale_max'] ?? 5) }}">
                </div>
            </div>
            <div class="scale-row">
                <div>
                    <label class="form-label" for="scale_min_label">Label Minimum (Opsional)</label>
                    <input type="text" id="scale_min_label" name="scale_min_label" class="form-input" placeholder="Contoh: Sangat Tidak Puas" value="{{ old('scale_min_label', $question->settings['scale_min_label'] ?? '') }}">
                </div>
                <div>
                    <label class="form-label" for="scale_max_label">Label Maksimum (Opsional)</label>
                    <input type="text" id="scale_max_label" name="scale_max_label" class="form-input" placeholder="Contoh: Sangat Puas" value="{{ old('scale_max_label', $question->settings['scale_max_label'] ?? '') }}">
                </div>
            </div>
        </div>

        <div class="form-group">
            <div class="checkbox-group">
                <input type="checkbox" id="is_required" name="is_required" class="checkbox-input" value="1" {{ old('is_required', $question->is_required) ? 'checked' : '' }}>
                <label class="checkbox-label" for="is_required">Pertanyaan wajib dijawab</label>
            </div>
            <div class="form-help">Jika dicentang, responden harus mengisi pertanyaan ini untuk melanjutkan</div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left"></i> Batal
            </a>
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-save"></i> Update Pertanyaan
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

        // Show/hide options container
        const optionsContainer = document.getElementById('optionsContainer');
        const scaleContainer = document.getElementById('scaleContainer');

        optionsContainer.classList.remove('show');
        scaleContainer.classList.remove('show');

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
            <button type="button" class="remove-option" onclick="removeOption(this)">Hapus</button>
        `;
        
        optionsList.appendChild(optionItem);
        updateRemoveButtons();
    }

    function removeOption(button) {
        button.parentElement.remove();
        updateRemoveButtons();
        updateOptionPlaceholders();
    }

    function updateRemoveButtons() {
        const options = document.querySelectorAll('.option-item');
        const removeButtons = document.querySelectorAll('.remove-option');
        
        removeButtons.forEach((btn, index) => {
            btn.style.display = options.length > 2 ? 'block' : 'none';
        });
    }

    function updateOptionPlaceholders() {
        const inputs = document.querySelectorAll('.option-input');
        inputs.forEach((input, index) => {
            input.placeholder = `Opsi ${index + 1}`;
        });
    }

    // Initialize form state
    document.addEventListener('DOMContentLoaded', function() {
        updateRemoveButtons();
        
        // Auto focus pada textarea pertama
        document.getElementById('question_text').focus();
    });

    // Form validation
    document.getElementById('questionForm').addEventListener('submit', function(e) {
        const selectedType = document.querySelector('input[name="question_type"]:checked');
        
        if (!selectedType) {
            e.preventDefault();
            alert('Silakan pilih jenis pertanyaan.');
            return;
        }

        // Validate options for multiple choice, checkbox, dropdown
        if (['multiple_choice', 'checkbox', 'dropdown'].includes(selectedType.value)) {
            const options = document.querySelectorAll('.option-input');
            const filledOptions = Array.from(options).filter(input => input.value.trim());
            
            if (filledOptions.length < 2) {
                e.preventDefault();
                alert('Pertanyaan pilihan harus memiliki minimal 2 opsi.');
                return;
            }
        }

        // Validate scale for linear_scale
        if (selectedType.value === 'linear_scale') {
            const scaleMin = parseInt(document.getElementById('scale_min').value);
            const scaleMax = parseInt(document.getElementById('scale_max').value);
            
            if (scaleMin >= scaleMax) {
                e.preventDefault();
                alert('Nilai maksimum harus lebih besar dari nilai minimum.');
                return;
            }
        }
    });
</script>
@endpush