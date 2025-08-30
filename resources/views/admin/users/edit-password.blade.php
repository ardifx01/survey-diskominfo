{{-- resources/views/admin/users/edit-password.blade.php --}}
@extends('layouts.admin')

@section('title', 'Ubah Password - Admin Survei')
@section('active-users', 'active')
@section('page-title', 'Ubah Password')
@section('page-subtitle', 'Ubah password untuk {{ $user->name }}')

@section('header-actions')
<div class="header-actions">
    <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
        <span class="btn-icon">←</span>
        Kembali
    </a>
    <span class="admin-welcome">{{ session('admin_name') }}</span>
</div>
@endsection

@push('styles')
<style>
    .form-container {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #f39c12 0%, #e67e22 100%);
        color: white;
        padding: 25px 30px;
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

    .user-info {
        background: #f8f9fa;
        padding: 20px;
        border-radius: 8px;
        margin-bottom: 25px;
        border-left: 4px solid #f39c12;
    }

    .user-info h4 {
        color: #2c3e50;
        margin-bottom: 10px;
        font-size: 16px;
    }

    .user-detail {
        display: flex;
        justify-content: space-between;
        margin-bottom: 8px;
        font-size: 14px;
    }

    .user-detail strong {
        color: #2c3e50;
    }

    .user-detail span {
        color: #7f8c8d;
    }

    .user-role {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .role-super-admin {
        background: #e74c3c;
        color: white;
    }

    .role-admin {
        background: #3498db;
        color: white;
    }

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
    }

    .form-input {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus {
        outline: none;
        border-color: #f39c12;
        box-shadow: 0 0 0 3px rgba(243, 156, 18, 0.1);
    }

    .form-help {
        font-size: 12px;
        color: #7f8c8d;
        margin-top: 5px;
    }

    .form-error {
        color: #e74c3c;
        font-size: 12px;
        margin-top: 5px;
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
        font-size: 16px;
    }

    .btn-warning {
        background: #f39c12;
        color: white;
    }

    .btn-warning:hover {
        background: #e67e22;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(243, 156, 18, 0.3);
    }

    .btn-secondary {
        background: #6c757d;
        color: white;
    }

    .btn-secondary:hover {
        background: #5a6268;
        transform: translateY(-2px);
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }

    .security-note {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        color: #856404;
        padding: 15px;
        border-radius: 8px;
        margin-bottom: 25px;
        font-size: 14px;
    }

    .security-note strong {
        color: #856404;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="form-title">🔑 Ubah Password</div>
        <div class="form-subtitle">Ganti password untuk akun {{ $user->name }}</div>
    </div>

    <div class="form-body">
        <div class="user-info">
            <h4>📋 Informasi User</h4>
            <div class="user-detail">
                <strong>Nama:</strong>
                <span>{{ $user->name }}</span>
            </div>
            <div class="user-detail">
                <strong>Username:</strong>
                <span>@{{ $user->username }}</span>
            </div>
            <div class="user-detail">
                <strong>Role:</strong>
                <span class="user-role role-{{ str_replace('_', '-', $user->role) }}">
                    {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                </span>
            </div>
            @if($user->last_login_at)
                <div class="user-detail">
                    <strong>Terakhir Login:</strong>
                    <span>{{ $user->last_login_at->format('d/m/Y H:i') }}</span>
                </div>
            @endif
        </div>

        <div class="security-note">
            <strong>⚠️ Catatan Keamanan:</strong>
            Setelah password diubah, user harus login ulang dengan password baru. 
            Pastikan password yang kuat untuk menjaga keamanan sistem.
        </div>

        <form method="POST" action="{{ route('admin.users.update-password', $user->id) }}">
            @csrf
            @method('PUT')
            
            <div class="form-group">
                <label class="form-label" for="password">Password Baru</label>
                <input type="password" id="password" name="password" class="form-input" 
                        placeholder="Masukkan password baru" required>
                <div class="form-help">Minimum 6 karakter</div>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                        placeholder="Ulangi password baru" required>
                <div class="form-help">Harus sama dengan password baru</div>
                @error('password_confirmation')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-warning">
                    🔑 Ubah Password
                </button>
            </div>
        </form>
    </div>
</div>
@endsection