{{-- resources/views/admin/assets/index.blade.php --}}
@extends('layouts.admin')

@section('title', 'Manajemen Assets - Admin Survei')
@section('active-assets', 'active')
@section('page-title', 'Manajemen Assets')
@section('page-subtitle', 'Kelola logo dan asset gambar sistem')

@section('header-actions')
<div class="header-actions">
    <a href="{{ route('admin.assets.create') }}" class="btn btn-primary">
        <span class="btn-icon"></span>
        Upload Asset
    </a>
    <span class="admin-welcome">{{ $currentAdmin->name }} ({{ ucfirst(str_replace('_', ' ', $currentAdmin->role)) }})</span>
</div>
@endsection

@push('styles')
<style>
    .assets-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
        gap: 20px;
        margin-bottom: 30px;
    }

    .asset-card {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .asset-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.15);
    }

    .asset-card.active {
        border: 2px solid #5a9b9e;
        box-shadow: 0 4px 20px rgba(90, 155, 158, 0.3);
    }

    .asset-preview {
        height: 200px;
        background: #f8f9fa;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
    }

    .asset-preview img {
        max-width: 100%;
        max-height: 100%;
        object-fit: contain;
    }

    .asset-status {
        position: absolute;
        top: 10px;
        right: 10px;
        padding: 4px 8px;
        border-radius: 12px;
        font-size: 11px;
        font-weight: 600;
        text-transform: uppercase;
    }

    .status-active {
        background: #27ae60;
        color: white;
    }

    .status-inactive {
        background: #95a5a6;
        color: white;
    }

    .asset-info {
        padding: 15px;
    }

    .asset-type {
        color: #5a9b9e;
        font-size: 12px;
        font-weight: 600;
        text-transform: uppercase;
        margin-bottom: 5px;
    }

    .asset-name {
        font-size: 14px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 5px;
        word-break: break-all;
    }

    .asset-description {
        font-size: 12px;
        color: #7f8c8d;
        margin-bottom: 10px;
        line-height: 1.4;
    }

    .asset-meta {
        font-size: 11px;
        color: #95a5a6;
        margin-bottom: 15px;
    }

    .asset-actions {
        display: flex;
        gap: 8px;
        justify-content: space-between;
    }

    .btn {
        padding: 6px 12px;
        border-radius: 6px;
        text-decoration: none;
        font-weight: 500;
        transition: all 0.3s ease;
        border: none;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-size: 12px;
        flex: 1;
        justify-content: center;
    }

    .btn-success {
        background: #27ae60;
        color: white;
    }

    .btn-success:hover {
        background: #219a52;
        transform: translateY(-1px);
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
        grid-column: 1 / -1;
    }

    .empty-icon {
        font-size: 48px;
        margin-bottom: 20px;
        opacity: 0.5;
    }

    .type-legend {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        padding: 20px;
        margin-bottom: 20px;
    }

    .legend-title {
        font-size: 16px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 15px;
    }

    .legend-items {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 15px;
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 10px;
        padding: 10px;
        background: #f8f9fa;
        border-radius: 8px;
    }

    .legend-color {
        width: 12px;
        height: 12px;
        border-radius: 50%;
        background: #5a9b9e;
    }

    .legend-text {
        font-size: 14px;
        color: #2c3e50;
    }

    @media (max-width: 768px) {
        .assets-grid {
            grid-template-columns: 1fr;
        }
        
        .asset-actions {
            flex-direction: column;
        }
        
        .btn {
            flex: none;
        }
    }
</style>
@endpush

@section('content')
<div class="type-legend">
    <div class="legend-title">Tipe Assets</div>
    <div class="legend-items">
        @foreach($availableTypes as $key => $label)
        <div class="legend-item">
            <div class="legend-color"></div>
            <span class="legend-text">{{ $label }}</span>
        </div>
        @endforeach
    </div>
</div>

<div class="assets-grid">
    @if($assets->count() > 0)
        @foreach($assets as $asset)
        <div class="asset-card {{ $asset->is_active ? 'active' : '' }}">
            <div class="asset-preview">
                <img src="{{ $asset->file_url }}" alt="{{ $asset->original_name }}">
                <div class="asset-status {{ $asset->is_active ? 'status-active' : 'status-inactive' }}">
                    {{ $asset->is_active ? 'AKTIF' : 'NONAKTIF' }}
                </div>
            </div>
            
            <div class="asset-info">
                <div class="asset-type">{{ $availableTypes[$asset->type] ?? $asset->type }}</div>
                <div class="asset-name">{{ $asset->original_name }}</div>
                
                <div class="asset-meta">
                    Diupload: {{ $asset->created_at->format('d/m/Y H:i') }}
                </div>
                
                <div class="asset-actions">
                    @if(!$asset->is_active)
                    <form method="POST" action="{{ route('admin.assets.toggle', $asset->id) }}" style="flex: 1;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-success">
                            Aktifkan
                        </button>
                    </form>
                    @else
                    <form method="POST" action="{{ route('admin.assets.toggle', $asset->id) }}" style="flex: 1;">
                        @csrf
                        @method('PUT')
                        <button type="submit" class="btn btn-warning">
                            Nonaktifkan
                        </button>
                    </form>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.assets.destroy', $asset->id) }}" 
                          style="flex: 1;" 
                          onsubmit="return confirm('Yakin ingin menghapus asset {{ $asset->original_name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    @else
        <div class="empty-state">
            <div class="empty-icon"></div>
            <h3>Belum ada asset</h3>
            <p>Upload asset pertama untuk logo sistem</p>
        </div>
    @endif
</div>
@endsection