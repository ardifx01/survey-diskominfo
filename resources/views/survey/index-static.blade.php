{{-- resources/views/survey/index-static.blade.php
@extends('layouts.app')

@section('title', 'Survei Kepuasan Layanan Diskominfo Lamongan')

@push('styles')
<style>
    .progress-container {
        background: white;
        border-bottom: 1px solid #e9ecef;
        position: relative;
        padding: 20px 0;
    }

    .progress-bar {
        height: 4px;
        background: #e9ecef;
        position: relative;
        overflow: visible;
        margin: 0 60px;
    }

    .progress-fill {
        height: 100%;
        background: #5a9b9e;
        width: 33.33%;
        transition: width 0.5s ease;
    }

    .progress-logo-container {
        position: absolute;
        top: -25px;
        left: 33.33%;
        transform: translateX(-50%);
        transition: left 0.5s ease;
        z-index: 10;
    }

    .progress-speech-bubble {
        position: absolute;
        bottom: 45px;
        left: 50%;
        transform: translateX(-50%);
        background: #2c3e50;
        color: white;
        padding: 8px 12px;
        border-radius: 15px;
        font-size: 14px;
        font-weight: 600;
        white-space: nowrap;
        opacity: 0;
        animation: bounceIn 0.6s ease forwards;
    }

    .progress-speech-bubble::after {
        content: '';
        position: absolute;
        top: 100%;
        left: 50%;
        transform: translateX(-50%);
        width: 0;
        height: 0;
        border-left: 6px solid transparent;
        border-right: 6px solid transparent;
        border-top: 6px solid #2c3e50;
    }

    .progress-logo {
        width: 50px;
        height: 50px;
        background: white;
        border: 3px solid #5a9b9e;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        position: relative;
    }

    .logo-placeholder {
        width: 40px;
        height: 40px;
        background: #f8f9fa;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 12px;
        color: #5a9b9e;
        font-weight: 600;
    }

    @keyframes bounceIn {
        0% {
            opacity: 0;
            transform: translateX(-50%) scale(0.3);
        }
        50% {
            opacity: 1;
            transform: translateX(-50%) scale(1.1);
        }
        100% {
            opacity: 1;
            transform: translateX(-50%) scale(1);
        }
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
        display: flex;
        gap: 15px;
        justify-content: center;
        align-items: center;
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

    .btn-back {
        background-color: #6c757d;
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

    .btn-back:hover {
        background-color: #5a6268;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
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

        .btn-container {
            flex-direction: column;
            gap: 10px;
        }

        .btn-next, .btn-back {
            min-width: 100%;
        }

        .progress-bar {
            margin: 0 30px;
        }

        .progress-logo {
            width: 40px;
            height: 40px;
        }

        .logo-placeholder {
            width: 30px;
            height: 30px;
            font-size: 10px;
        }

        .progress-speech-bubble {
            font-size: 12px;
            padding: 6px 10px;
            bottom: 35px;
        }
    }
</style>
@endpush

@section('content')
<div class="progress-container">
    <div class="progress-bar">
        <div class="progress-fill" id="progressBar"></div>
        <div class="progress-logo-container" id="progressLogoContainer">
            <div class="progress-speech-bubble" id="progressBubble">33%</div>
            <div class="progress-logo">
                <div class="logo-placeholder" id="logoPlaceholder">
                    <img src="{{ asset('images/logos/logo-diskominfo.png') }}" alt="Logo Diskominfo" style="width: 100%; height: 100%; object-fit: cover; border-radius: 50%;" onerror="this.style.display='none'; this.nextElementSibling.style.display='flex';">
                    <span style="display: none;">LOGO</span>
                </div>
            </div>
        </div>
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
            <button type="button" class="btn-back" onclick="prevQuestion(2)">
                Kembali
            </button>
            <button type="button" class="btn-next" onclick="nextQuestion(2)" disabled id="btn2">
                Lanjut ke Pertanyaan Berikutnya
            </button>
        </div>
    </div>

    <!-- Question 3: Usia -->
    <div class="question-container" id="question3">
        <div class="question-header">
            <h3 class="question-title">Informasi Usia</h3>
            <p class="question-subtitle">Mohon lengkapi informasi usia Anda untuk melanjutkan ke tahap evaluasi layanan</p>
        </div>
        
        <div class="form-group">
            <label class="form-label" for="usia">Usia (Tahun) *</label>
            <input type="number" id="usia" name="usia" class="form-input" placeholder="Masukkan usia Anda" min="6" max="100" required>
        </div>
        
        <div class="btn-container">
            <button type="button" class="btn-back" onclick="prevQuestion(3)">
                Kembali
            </button>
            <button type="button" class="btn-next" onclick="submitSurvey()" disabled id="btn3">
                Selesaikan Data Pribadi
            </button>
        </div>
    </div>

    <div class="success-message" id="successMessage">
        <div class="success-icon">SUCCESS</div>
        <h3>Terima Kasih!</h3>
        <p>Data pribadi Anda telah berhasil disimpan. Survei kepuasan layanan akan dilanjutkan dengan pertanyaan evaluasi layanan Dinas Komunikasi dan Informatika Kabupaten Lamongan.</p>
    </div>
</form>
@endsection

@push('scripts')
<script>
    let currentQuestion = 1;
    const totalQuestions = 3;

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
        const isValid = this.value >= 6 && this.value <= 100 && this.value !== '';
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

    function prevQuestion(current) {
        // Hide current question
        document.getElementById('question' + current).classList.remove('active');
        
        // Show previous question
        const prevQ = current - 1;
        if (prevQ >= 1) {
            setTimeout(() => {
                document.getElementById('question' + prevQ).classList.add('active');
                currentQuestion = prevQ;
                updateProgress();
                updateSteps();
            }, 300);
        }
    }

    function submitSurvey() {
        const usia = document.getElementById('usia').value;
        if (!usia || usia < 6 || usia > 100) {
            showError('Minimal usia 6 tahun');
            return;
        }

        // Validate all fields
        const nama = document.getElementById('nama').value.trim();
        const jenisKelamin = document.querySelector('input[name="jenis_kelamin"]:checked');
        
        if (!nama) {
            showError('Mohon isi nama lengkap Anda');
            return;
        }
        
        if (!jenisKelamin) {
            showError('Mohon pilih jenis kelamin');
            return;
        }

        // Disable submit button
        const btn = document.getElementById('btn3');
        btn.disabled = true;
        btn.textContent = 'Menyimpan...';

        // Prepare form data as FormData for better compatibility
        const formData = new FormData();
        formData.append('nama', nama);
        formData.append('jenis_kelamin', jenisKelamin.value);
        formData.append('usia', parseInt(document.getElementById('usia').value));
        formData.append('_token', document.querySelector('input[name="_token"]').value);

        // Submit to Laravel backend
        fetch('{{ route("survey.store") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: formData
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
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
        const progressLogoContainer = document.getElementById('progressLogoContainer');
        const progressBubble = document.getElementById('progressBubble');
        
        const percentage = customPercentage || (currentQuestion / totalQuestions) * 100;
        progressBar.style.width = percentage + '%';
        
        // Update posisi logo mengikuti progress
        progressLogoContainer.style.left = percentage + '%';
        
        // Update text di speech bubble
        progressBubble.textContent = Math.round(percentage) + '%';
        
        // Trigger animasi bubble
        progressBubble.style.animation = 'none';
        progressBubble.offsetHeight; // Trigger reflow
        progressBubble.style.animation = 'bounceIn 0.6s ease forwards';
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
@endpush --}}