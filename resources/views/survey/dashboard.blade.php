<?php
// ==============================================
// resources/views/survey/dashboard.blade.php
// ==============================================
?>

@extends('layouts.app')

@section('title', 'Dashboard Survei Kepuasan')

@push('styles')
<style>
    .dashboard-container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
    }

    .dashboard-header {
        text-align: center;
        margin-bottom: 40px;
    }

    .dashboard-title {
        font-size: 28px;
        font-weight: 700;
        color: #2c3e50;
        margin-bottom: 10px;
    }

    .dashboard-subtitle {
        font-size: 16px;
        color: #7f8c8d;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .stat-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        border-left: 4px solid #5a9b9e;
    }

    .stat-number {
        font-size: 36px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 8px;
    }

    .stat-label {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .charts-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 20px;
        margin-bottom: 40px;
    }

    .chart-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .chart-title {
        font-size: 18px;
        font-weight: 600;
        color: #2c3e50;
        margin-bottom: 20px;
        text-align: center;
    }

    .gender-chart {
        display: flex;
        justify-content: space-around;
        align-items: center;
    }

    .gender-item {
        text-align: center;
    }

    .gender-circle {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 24px;
        font-weight: 700;
        color: white;
        margin-bottom: 10px;
    }

    .male {
        background: #3498db;
    }

    .female {
        background: #e91e63;
    }

    .age-bars {
        space-y: 10px;
    }

    .age-bar {
        margin-bottom: 15px;
    }

    .age-label {
        font-size: 14px;
        color: #2c3e50;
        margin-bottom: 5px;
        display: flex;
        justify-content: space-between;
    }

    .age-progress {
        height: 20px;
        background: #e9ecef;
        border-radius: 10px;
        overflow: hidden;
    }

    .age-fill {
        height: 100%;
        background: #5a9b9e;
        transition: width 0.5s ease;
    }

    .recent-table {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .table-header {
        background: #5a9b9e;
        color: white;
        padding: 20px;
        font-size: 18px;
        font-weight: 600;
    }

    .table-content {
        padding: 0;
    }

    .table {
        width: 100%;
        border-collapse: collapse;
    }

    .table th {
        background: #f8f9fa;
        padding: 15px;
        text-align: left;
        font-weight: 600;
        color: #2c3e50;
        border-bottom: 1px solid #dee2e6;
    }

    .table td {
        padding: 15px;
        border-bottom: 1px solid #dee2e6;
        color: #495057;
    }

    .table tr:hover {
        background: #f8f9fa;
    }

    .gender-badge {
        padding: 4px 12px;
        border-radius: 20px;
        font-size: 12px;
        font-weight: 500;
    }

    .badge-male {
        background: #e3f2fd;
        color: #1976d2;
    }

    .badge-female {
        background: #fce4ec;
        color: #c2185b;
    }

    .export-btn {
        background: #28a745;
        color: white;
        border: none;
        padding: 12px 24px;
        border-radius: 8px;
        font-weight: 600;
        text-decoration: none;
        display: inline-block;
        margin-bottom: 20px;
        transition: all 0.3s ease;
    }

    .export-btn:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    @media (max-width: 768px) {
        .charts-grid {
            grid-template-columns: 1fr;
        }
        
        .dashboard-container {
            padding: 15px;
        }
        
        .stat-card {
            padding: 20px;
        }
        
        .chart-card {
            padding: 20px;
        }
        
        .table {
            font-size: 14px;
        }
        
        .table th, .table td {
            padding: 10px 8px;
        }
    }
</style>
@endpush

@section('content')
<div class="dashboard-container">
    <div class="dashboard-header">
        <h1 class="dashboard-title">Dashboard Survei Kepuasan</h1>
        <p class="dashboard-subtitle">Statistik dan data survei kepuasan layanan Diskominfo Lamongan</p>
        
        <a href="{{ route('survey.export') }}" class="export-btn">
            📊 Export Data CSV
        </a>
    </div>

    <!-- Statistics Cards -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-number">{{ $totalSurveys }}</div>
            <div class="stat-label">Total Responden</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $maleCount }}</div>
            <div class="stat-label">Laki-laki</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ $femaleCount }}</div>
            <div class="stat-label">Perempuan</div>
        </div>
        <div class="stat-card">
            <div class="stat-number">{{ date('Y') }}</div>
            <div class="stat-label">Tahun Survei</div>
        </div>
    </div>

    <!-- Charts -->
    <div class="charts-grid">
        <!-- Gender Distribution -->
        <div class="chart-card">
            <h3 class="chart-title">Distribusi Jenis Kelamin</h3>
            <div class="gender-chart">
                <div class="gender-item">
                    <div class="gender-circle male">{{ $maleCount }}</div>
                    <div>Laki-laki</div>
                    <div style="font-size: 12px; color: #7f8c8d;">
                        {{ $totalSurveys > 0 ? round(($maleCount / $totalSurveys) * 100, 1) : 0 }}%
                    </div>
                </div>
                <div class="gender-item">
                    <div class="gender-circle female">{{ $femaleCount }}</div>
                    <div>Perempuan</div>
                    <div style="font-size: 12px; color: #7f8c8d;">
                        {{ $totalSurveys > 0 ? round(($femaleCount / $totalSurveys) * 100, 1) : 0 }}%
                    </div>
                </div>
            </div>
        </div>

        <!-- Age Distribution -->
        <div class="chart-card">
            <h3 class="chart-title">Distribusi Usia</h3>
            <div class="age-bars">
                @foreach($ageStats as $ageStat)
                @if($ageStat->age_group)
                <div class="age-bar">
                    <div class="age-label">
                        <span>{{ $ageStat->age_group }} tahun</span>
                        <span>{{ $ageStat->count }} orang</span>
                    </div>
                    <div class="age-progress">
                        <div class="age-fill" style="width: {{ $totalSurveys > 0 ? ($ageStat->count / $totalSurveys) * 100 : 0 }}%"></div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Surveys Table -->
    <div class="recent-table">
        <div class="table-header">
            📋 Responden Terbaru
        </div>
        <div class="table-content">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama</th>
                        <th>Jenis Kelamin</th>
                        <th>Usia</th>
                        <th>Tanggal</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($recentSurveys as $survey)
                    <tr>
                        <td>#{{ $survey->id }}</td>
                        <td>{{ $survey->nama }}</td>
                        <td>
                            <span class="gender-badge {{ $survey->jenis_kelamin === 'laki_laki' ? 'badge-male' : 'badge-female' }}">
                                {{ $survey->jenis_kelamin_label }}
                            </span>
                        </td>
                        <td>{{ $survey->usia }} tahun</td>
                        <td>{{ $survey->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" style="text-align: center; color: #7f8c8d; padding: 40px;">
                            Belum ada data survei
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection