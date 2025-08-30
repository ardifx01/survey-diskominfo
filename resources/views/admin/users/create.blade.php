{{-- resources/views/admin/users/create.blade.php --}}
@extends('layouts.admin')

@section('title', 'Tambah User - Admin Survei')
@section('active-users', 'active')
@section('page-title', 'Tambah User Baru')
@section('page-subtitle', 'Buat akun admin atau super admin baru')

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
        max-width: 600px;
        margin: 0 auto;
    }

    .form-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
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

    .form-group {
        margin-bottom: 25px;
    }

    .form-label {
        display: block;
        margin-bottom: 8px;
        font-weight: 600;
        color: #2c3e50;
    }

    .form-input, .form-select {
        width: 100%;
        padding: 12px 15px;
        border: 2px solid #e9ecef;
        border-radius: 8px;
        font-size: 16px;
        transition: all 0.3s ease;
        background: white;
    }

    .form-input:focus, .form-select:focus {
        outline: none;
        border-color: #5a9b9e;
        box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
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
    }

    .form-actions {
        display: flex;
        gap: 15px;
        justify-content: flex-end;
        margin-top: 30px;
        padding-top: 25px;
        border-top: 1px solid #e9ecef;
    }

    .role-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-top: 10px;
        border-left: 4px solid #17a2b8;
    }

    .role-info h5 {
        color: #17a2b8;
        margin-bottom: 10px;
        font-size: 14px;
        font-weight: 600;
    }

    .role-info ul {
        font-size: 13px;
        color: #6c757d;
        margin-left: 15px;
    }

    .role-info li {
        margin-bottom: 5px;
    }
</style>
@endpush

@section('content')
<div class="form-container">
    <div class="form-header">
        <div class="form-title">Tambah User Baru</div>
        <div class="form-subtitle">Buat akun admin atau super admin</div>
    </div>

    <div class="form-body">
        <form method="POST" action="{{ route('admin.users.store') }}">
            @csrf
            
            <div class="form-group">
                <label class="form-label" for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" class="form-input" 
                       placeholder="Masukkan nama lengkap" required 
                       value="{{ old('name') }}">
                @error('name')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="username">Username</label>
                <input type="text" id="username" name="username" class="form-input" 
                       placeholder="Masukkan username" required 
                       value="{{ old('username') }}">
                <div class="form-help">Username harus unik dan tidak boleh sama dengan yang sudah ada</div>
                @error('username')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="role">Role</label>
                <select id="role" name="role" class="form-select" required onchange="showRoleInfo()">
                    <option value="">Pilih Role</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Admin</option>
                    <option value="super_admin" {{ old('role') === 'super_admin' ? 'selected' : '' }}>Super Admin</option>
                </select>
                @error('role')
                    <div class="form-error">{{ $message }}</div>
                @enderror

                <div id="role-admin-info" class="role-info" style="display: none;">
                    <h5>🔵 Hak Akses Admin:</h5>
                    <ul>
                        <li>Melihat dashboard dan data survei</li>
                        <li>Mengelola pertanyaan dan section survei</li>
                        <li>Mengubah password sendiri</li>
                    </ul>
                </div>

                <div id="role-super-admin-info" class="role-info" style="display: none;">
                    <h5>🔴 Hak Akses Super Admin:</h5>
                    <ul>
                        <li>Semua hak akses Admin</li>
                        <li>Menambahkan user admin baru</li>
                        <li>Mengubah password semua user</li>
                        <li>Menghapus user admin</li>
                    </ul>
                </div>
            </div>

            <div class="form-group">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" name="password" class="form-input" 
                       placeholder="Masukkan password" required>
                <div class="form-help">Minimum 6 karakter</div>
                @error('password')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="password_confirmation">Konfirmasi Password</label>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-input" 
                       placeholder="Ulangi password" required>
                <div class="form-help">Harus sama dengan password di atas</div>
                @error('password_confirmation')
                    <div class="form-error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-actions">
                <a href="{{ route('admin.users.index') }}" class="btn btn-secondary">
                    Batal
                </a>
                <button type="submit" class="btn btn-primary">
                    Simpan User
                </button>
            </div>
        </form>
    </div>
</div>

<script>
function showRoleInfo() {
    const roleSelect = document.getElementById('role');
    const adminInfo = document.getElementById('role-admin-info');
    const superAdminInfo = document.getElementById('role-super-admin-info');
    
    // Hide all info boxes
    adminInfo.style.display = 'none';
    superAdminInfo.style.display = 'none';
    
    // Show relevant info
    if (roleSelect.value === 'admin') {
        adminInfo.style.display = 'block';
    } else if (roleSelect.value === 'super_admin') {
        superAdminInfo.style.display = 'block';
    }
}

// Show info on page load if there's old input
document.addEventListener('DOMContentLoaded', function() {
    showRoleInfo();
});
</script>
@endsection