{{-- resources/views/admin/users/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen User - Admin Survei')
@section('active-users', 'active')
@section('page-title', 'Manajemen User')
@section('page-subtitle', 'Kelola admin dan super admin sistem')

@section('header-actions')
<div class="header-actions">
    @if(session('admin_role') === 'super_admin')
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            <span class="btn-icon"><i class="fas fa-plus"></i></span>
            Tambah User
        </a>
    @endif
    <span class="admin-welcome">{{ session('admin_name') }} ({{ ucfirst(str_replace('_', ' ', session('admin_role'))) }})</span>
</div>
@endsection

@push('styles')
<style>
    .user-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
        color: white;
        padding: 20px 25px;
    }

    .table-title {
        font-size: 18px;
        font-weight: 600;
        margin-bottom: 5px;
    }

    .table-subtitle {
        font-size: 14px;
        opacity: 0.8;
    }

    .table-content {
        padding: 0;
    }

    .user-item {
        padding: 20px 25px;
        border-bottom: 1px solid #e9ecef;
        display: flex;
        justify-content: space-between;
        align-items: center;
        transition: background-color 0.3s ease;
    }

    .user-item:last-child {
        border-bottom: none;
    }

    .user-item:hover {
        background-color: #f8f9fa;
    }

    .user-info {
        flex: 1;
    }

    .user-name {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
    }

    .user-meta {
        display: flex;
        gap: 20px;
        align-items: center;
    }

    .user-username {
        font-size: 14px;
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

    .user-last-login {
        font-size: 12px;
        color: #95a5a6;
    }

    .user-actions {
        display: flex;
        gap: 10px;
        align-items: center;
    }

    .btn {
        padding: 8px 16px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 6px;
        font-size: 14px;
    }

    .btn-warning {
        background: #f39c12;
        color: white;
    }

    .btn-warning:hover {
        background: #e67e22;
        transform: translateY(-1px);
    }

    .btn-danger {
        background: #e74c3c;
        color: white;
    }

    .btn-danger:hover {
        background: #c0392b;
        transform: translateY(-1px);
    }

    .btn-primary {
        background: #5a9b9e;
        color: white;
    }

    .btn-primary:hover {
        background: #4a8b8e;
        transform: translateY(-1px);
    }

    .empty-state {
        text-align: center;
        padding: 60px 20px;
        color: #7f8c8d;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .current-user {
        background: #f8f9fa;
        border-left: 4px solid #5a9b9e;
    }

    @media (max-width: 768px) {
        .user-item {
            flex-direction: column;
            align-items: flex-start;
            gap: 15px;
        }

        .user-actions {
            width: 100%;
            justify-content: flex-end;
        }

        .user-meta {
            flex-direction: column;
            align-items: flex-start;
            gap: 5px;
        }
    }
</style>
@endpush

@section('content')
<div class="user-table">
    <div class="table-header">
        <div class="table-title">Daftar User Admin</div>
        <div class="table-subtitle">Kelola akses administrator sistem</div>
    </div>

    <div class="table-content">
        @if($users->count() > 0)
            @foreach($users as $user)
                <div class="user-item {{ $user->id === session('admin_id') ? 'current-user' : '' }}">
                    <div class="user-info">
                        <div class="user-name">
                            {{ $user->name }}
                            @if($user->id === session('admin_id'))
                                <span style="color: #5a9b9e; font-size: 14px;">(Anda)</span>
                            @endif
                        </div>
                        <div class="user-meta">
                            {{-- <span class="user-username">@{{ $user->username }}</span> --}}
                            <span class="user-role role-{{ str_replace('_', '-', $user->role) }}">
                                {{ ucfirst(str_replace('_', ' ', $user->role)) }}
                            </span>
                            @if($user->last_login_at)
                                <span class="user-last-login">
                                    Terakhir login: {{ $user->last_login_at->format('d/m/Y H:i') }}
                                </span>
                            @else
                                <span class="user-last-login">Belum pernah login</span>
                            @endif
                        </div>
                    </div>

                    <div class="user-actions">
                        <!-- Edit Password: Super admin bisa edit semua, admin hanya diri sendiri -->
                        @if(session('admin_role') === 'super_admin' || $user->id === session('admin_id'))
                            <a href="{{ route('admin.users.edit-password', $user->id) }}" class="btn btn-warning">
                                Ubah Password
                            </a>
                        @endif

                        <!-- Delete: Hanya super admin dan tidak bisa hapus diri sendiri -->
                        @if(session('admin_role') === 'super_admin' && $user->id !== session('admin_id'))
                            <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" 
                                  style="display: inline;" 
                                  onsubmit="return confirm('Yakin ingin menghapus user {{ $user->name }}?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    Hapus
                                </button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        @else
            <div class="empty-state">
                <div class="empty-icon"><i class="fas fa-users"></i></div>
                <h3>Belum ada user</h3>
                <p>Silakan tambah user admin pertama</p>
            </div>
        @endif
    </div>
</div>
@endsection