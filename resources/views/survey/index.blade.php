<?php
// ==============================================
// resources/views/survey/index.blade.php
// ==============================================
?>

@extends('layouts.app')

@section('title', 'Survei Kepuasan Layanan Diskominfo Lamongan')

@push('styles')
<style>
    .progress-container {
        background: white;
        border-bottom: 1px solid #e9ecef;
    }

    .progress-bar {
        height: 4px;
        background: #e9ecef;
        position: relative;
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: #5a9b9e;
        width: 33.33%;
        transition: width 0.5s ease;
    }

    .step-indicator {
        display: flex;
        justify-content: center;
        align-items: center;
        padding: 20px;
        gap: 15px;
    }

    .step {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 600;
        color: #6c757d;
        transition: all 0.3s ease;
        position: relative;
    }

    .step.active {
        background: #5a9b9e;
        color: white;
    }

    .step.completed {
        background: #28a745;
        color: white;
    }

    .step::after {
        content: '';
        position: absolute;
        right: -20px;
        top: 50%;
        transform: translateY(-50%);
        width: 25px;
        height: 2px;
        background: #e9ecef;
    }

    .step:last-child::after {
        display: none;
    }

    .step.completed::after {
        background: #28a745;
    }

    .question-container {
        display: none;
        opacity: 0;
        transform: translateY(20px);
        transition: all 0.4s ease;
        max-width: 600px;
        margin: 0 auto;
    }

    .question-container.active {
        display: block;
        opacity: 1;
        transform: translateY(0);
    }

    .question-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .question-title {
        font-size: 24px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .question-subtitle {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.5;
    }

    .form-group {
        margin-bottom: 30px;
    }

    .form-label {
        display: block;
        margin-bottom: 15px;
        font-weight: 600;
        color: #2c3e50;
        font-size: 18px;
    }

    .form-input {
        width: 100%;
        padding: 18px 20px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: #fff;
    }

    .form-input:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
    }

    .radio-group {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 15px;
        margin-top: 15px;
    }

    .radio-option {
        position: relative;
    }

    .radio-option input[type="radio"] {
        display: none;
    }

    .radio-option label {
        display: block;
        padding: 20px;
        background: #f8f9fa;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        cursor: pointer;
        text-align: center;
        font-weight: 500;
        font-size: 16px;
        transition: all 0.3s ease;
        color: #495057;
    }

    .radio-option input[type="radio"]:checked + label {
        background: #5a9b9e;
        color: white;
        border-color: #5a9b9e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.3);
    }

    .radio-option label:hover {
        border-color: #5a9b9e;
        background: #f1f8f9;
    }

    .btn-container {
        text-align: center;
        margin-top: 40px;
    }

    .btn-next {
        background-color: #5a9b9e;
        color: white;
        border: none;
        padding: 18px 40px;
        font-size: 16px;
        font-weight: 600;
        border-radius: 8px;
        cursor: pointer;
        transition: all 0.3s ease;
        min-width: 200px;
    }

    .btn-next:hover {
        background-color: #4a8b8e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.3);
    }

    .btn-next:disabled {
        background-color: #bdc3c7;
        cursor: not-allowed;
        transform: none;
        box-shadow: none;
    }

    .illustration {
        text-align: center;
        margin-bottom: 30px;
    }

    .illustration-placeholder {
        width: 200px;
        height: 150px;
        background: #f8f9fa;
        border: 2px dashed #dee2e6;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 48px;
        color: #adb5bd;
    }

    .success-message {
        display: none;
        text-align: center;
        padding: 60px 40px;
        color: #28a745;
        max-width: 600px;
        margin: 0 auto;
    }

    .success-icon {
        font-size: 80px;
        margin-bottom: 30px;
        color: #28a745;
    }

    .success-message h3 {
        font-size: 28px;
        margin-bottom: 15px;
        color: #2c3e50;
    }

    .success-message p {
        font-size: 16px;
        line-height: 1.6;
        color: #6c757d;
    }

    .error-message {
        background: #f8d7da;
        border: 1px solid #f5c6cb;
        color: #721c24;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 20px;
        display: none;
    }

    @media (max-width: 768px) {
        .radio-group {
            grid-template-columns: 1fr;
            gap: 12px;
        }
        
        .step-indicator {
            padding: 15px;
            gap: 10px;
        }
        
        .step {
            width: 35px;
            height: 35px;
            font-size: 14px;
        }
    }
</style>
@endpush

@section('content')
<div class="progress-container">
    <div class="progress-bar">
        <div class="progress-fill" id="progressBar"></div>
    </div>
    
    <div class="step-indicator">
        <div class="step active" id="step1">1</div>
        <div class="step" id="step2">2</div>
        <div class="step" id="step3">3</div>
    </div>
</div>

<div class="error-message" id="errorMessage"></div>

<form id="surveyForm">
    @csrf
    <!-- Question 1: Nama -->
    <div class="question-container active" id="question1">
        <div class="illustration">
            <div class="illustration-placeholder">👤</div>
        </div>
        
        <div class="question-header">
            <h3 class="question-title">Identitas Peserta</h3>
            <p class="question-subtitle">Silakan isi data diri Anda untuk memulai survei kepuasan layanan</p>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="nama">Nama Lengkap *</label>
            <input type="text" id="nama" name="nama" class="form-input" placeholder="Masukkan nama lengkap Anda" required>
        </div>
        
        <div class="btn-container">
            <button type="button" class="btn-next" onclick="nextQuestion(1)" disabled id="btn1">
                Lanjut ke Pertanyaan Berikutnya
            </button>
        </div>
    </div>

    <!-- Question 2: Jenis Kelamin -->
    <div class="question-container" id="question2">
        <div class="illustration">
            <div class="illustration-placeholder">⚥</div>
        </div>
        
        <div class="question-header">
            <h3 class="question-title">Data Demografi</h3>
            <p class="question-subtitle">Bagaimana pendapat Saudara tentang kesesuaian persyaratan pelayanan dengan jenis pelayanannya.</p>
        </div>
        
        <div class="form-group">
            <label class="form-label">Jenis Kelamin *</label>
            <div class="radio-group">
                <div class="radio-option">
                    <input type="radio" id="perempuan" name="jenis_kelamin" value="perempuan" required>
                    <label for="perempuan">Perempuan</label>
                </div>
                <div class="radio-option">
                    <input type="radio" id="laki_laki" name="jenis_kelamin" value="laki_laki" required>
                    <label for="laki_laki">Laki-laki</label>
                </div>
            </div>
        </div>
        
        <div class="btn-container">
            <button type="button" class="btn-next" onclick="nextQuestion(2)" disabled id="btn2">
                Lanjut ke Pertanyaan Berikutnya
            </button>
        </div>
    </div>

    <!-- Question 3: Usia -->
    <div class="question-container" id="question3">
        <div class="illustration">
            <div class="illustration-placeholder">🎂</div>
        </div>
        
        <div class="question-header">
            <h3 class="question-title">Informasi Usia</h3>
            <p class="question-subtitle">Mohon lengkapi informasi usia Anda untuk melanjutkan ke tahap evaluasi layanan</p>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="usia">Usia (Tahun) *</label>
            <input type="number" id="usia" name="usia" class="form-input" placeholder="Masukkan usia Anda" min="15" max="100" required>
        </div>
        
        <div class="btn-container">
            <button type="button" class="btn-next" onclick="submitSurvey()" disabled id="btn3">
                Selesaikan Data Pribadi
            </button>
        </div>
    </div>

    <div class="success-message" id="successMessage">
        <div class="success-icon">✅</div>
        <h3>Terima Kasih!</h3>
        <p>Data pribadi Anda telah berhasil disimpan. Survei kepuasan layanan akan dilanjutkan dengan pertanyaan evaluasi layanan Dinas Komunikasi dan Informatika Kabupaten Lamongan.</p>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let currentQuestion = 1;
    const totalQuestions = 3;

    // Setup CSRF token for AJAX requests
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    // Form validation and navigation
    document.getElementById('nama').addEventListener('input', function() {
        const btn = document.getElementById('btn1');
        btn.disabled = this.value.trim() === '';
    });

    document.querySelectorAll('input[name="jenis_kelamin"]').forEach(radio => {
        radio.addEventListener('change', function() {
            const btn = document.getElementById('btn2');
            btn.disabled = false;
        });
    });

    document.getElementById('usia').addEventListener('input', function() {
        const btn = document.getElementById('btn3');
        const isValid = this.value >= 15 && this.value <= 100 && this.value !== '';
        btn.disabled = !isValid;
    });

    function showError(message) {
        const errorDiv = document.getElementById('errorMessage');
        errorDiv.textContent = message;
        errorDiv.style.display = 'block';
        setTimeout(() => {
            errorDiv.style.display = 'none';
        }, 5000);
    }

    function nextQuestion(current) {
        // Validate current question
        if (current === 1) {
            const nama = document.getElementById('nama').value.trim();
            if (!nama) {
                showError('Mohon isi nama lengkap Anda');
                return;
            }
        } else if (current === 2) {
            const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
            if (!jenisKelamin) {
                showError('Mohon pilih jenis kelamin');
                return;
            }
        }

        // Hide current question
        document.getElementById('question' + current).classList.remove('active');
        
        // Show next question
        const nextQ = current + 1;
        if (nextQ <= totalQuestions) {
            setTimeout(() => {
                document.getElementById('question' + nextQ).classList.add('active');
                currentQuestion = nextQ;
                updateProgress();
                updateSteps();
            }, 300);
        }
    }

    function submitSurvey() {
        const usia = document.getElementById('usia').value;
        if (!usia || usia < 15 || usia > 100) {
            showError('Mohon isi usia dengan benar (15-100 tahun)');
            return;
        }

        // Disable submit button
        const btn = document.getElementById('btn3');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        // Prepare form data
        const formData = {
            nama: document.getElementById('nama').value.trim(),
            jenis_kelamin: document.querySelector('input[name="jenis_kelamin"]:checked').value,
            usia: parseInt(document.getElementById('usia').value),
            _token: document.querySelector('input[name="_token"]').value
        };

        // Submit to Laravel backend
        fetch('{{ route("survey.store") }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify(formData)
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Hide current question
                document.getElementById('question3').classList.remove('active');
                
                // Show success message
                setTimeout(() => {
                    document.getElementById('successMessage').style.display = 'block';
                    updateProgress(100);
                    
                    // Mark all steps as completed
                    document.querySelectorAll('.step').forEach(step => {
                        step.classList.add('completed');
                        step.classList.remove('active');
                    });
                }, 300);
            } else {
                showError(data.message || 'Terjadi kesalahan saat menyimpan data.');
                btn.disabled = false;
                btn.textContent = 'Selesaikan Data Pribadi';
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showError('Terjadi kesalahan jaringan. Silakan coba lagi.');
            btn.disabled = false;
            btn.textContent = 'Selesaikan Data Pribadi';
        });
    }

    function updateProgress(customPercentage = null) {
        const progressBar = document.getElementById('progressBar');
        const percentage = customPercentage || (currentQuestion / totalQuestions) * 100;
        progressBar.style.width = percentage + '%';
    }

    function updateSteps() {
        document.querySelectorAll('.step').forEach((step, index) => {
            step.classList.remove('active', 'completed');
            if (index + 1 < currentQuestion) {
                step.classList.add('completed');
            } else if (index + 1 === currentQuestion) {
                step.classList.add('active');
            }
        });
    }

    // Initialize
    document.addEventListener('DOMContentLoaded', function() {
        updateProgress();
        updateSteps();
    });
</script>
@endpush