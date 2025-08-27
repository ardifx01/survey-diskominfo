{{-- resources/views/survey/no-questions.blade.php --}}
@extends('layouts.app')

@section('title', 'Survei Belum Tersedia - Diskominfo Lamongan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<style>
    .no-questions-container {
        max-width: 600px;
        margin: 50px auto;
        padding: 60px 40px;
        text-align: center;
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .no-questions-icon {
        font-size: 80px;
        margin-bottom: 30px;
        color: #7f8c8d;
    }

    .no-questions-title {
        font-size: 28px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
    }

    .no-questions-message {
        font-size: 16px;
        color: #7f8c8d;
        line-height: 1.6;
        margin-bottom: 40px;
    }

    .admin-info {
        background: #e8f4f8;
        border: 1px solid #bee5eb;
        border-radius: 8px;
        padding: 20px;
        margin-bottom: 30px;
    }

    .admin-info h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 18px;
    }

    .admin-info p {
        color: #5a6c7d;
        margin-bottom: 15px;
        font-size: 14px;
    }

    .admin-login-btn {
        background: #5a9b9e;
        color: white;
        padding: 12px 24px;
        border-radius: 8px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        display: inline-block;
    }

    .admin-login-btn:hover {
        background: #4a8b8e;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(90, 155, 158, 0.3);
        text-decoration: none;
        color: white;
    }

    .contact-info {
        background: #f8f9fa;
        border-radius: 8px;
        padding: 20px;
        margin-top: 20px;
    }

    .contact-info h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .contact-info p {
        color: #6c757d;
        font-size: 14px;
        margin-bottom: 5px;
    }

    @media (max-width: 768px) {
        .no-questions-container {
            margin: 20px;
            padding: 40px 20px;
        }

        .no-questions-icon {
            font-size: 60px;
        }

        .no-questions-title {
            font-size: 24px;
        }
    }
</style>
@endpush

@section('content')
<div class="no-questions-container">
    <div class="no-questions-icon">
        <i class="fas fa-clipboard-list"></i>
    </div>
    
    <h2 class="no-questions-title">Survei Belum Tersedia</h2>
    
    <p class="no-questions-message">
        Maaf, survei kepuasan masyarakat belum dikonfigurasi oleh administrator. 
        Silakan hubungi administrator untuk mengaktifkan survei atau coba kembali lagi nanti.
    </p>
</div>
@endsection