{{-- resources/views/admin/dashboard-summary.blade.php
@extends('layouts.admin')

@section('title', 'Dashboard Admin - Survei Kepuasan Diskominfo Lamongan')
@section('active-dashboard', 'active')
@section('page-title', 'Dashboard Survei')
@section('page-subtitle', 'Ringkasan dan statistik survei kepuasan')

@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
<style>
    /* Tab Navigation */
    .tab-navigation {
        background: white;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
        overflow: hidden;
    }

    .tab-nav {
        display: flex;
        background: #f8f9fa;
    }

    .tab-item {
        flex: 1;
        padding: 20px 25px;
        text-align: center;
        background: #f8f9fa;
        color: #6c757d;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        border-right: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .tab-item:last-child {
        border-right: none;
    }

    .tab-item:hover {
        background: #e9ecef;
        color: #495057;
    }

    .tab-item.active {
        background: #5a9b9e;
        color: white;
    }

    .tab-icon {
        font-size: 18px;
    }

    /* Summary Stats */
    .summary-stats {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
        gap: 20px;
        margin-bottom: 40px;
    }

    .summary-card {
        background: white;
        padding: 25px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        text-align: center;
        position: relative;
        overflow: hidden;
    }

    .summary-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, #5a9b9e, #4a8b8e);
    }

    .summary-number {
        font-size: 36px;
        font-weight: 700;
        color: #5a9b9e;
        margin-bottom: 8px;
    }

    .summary-label {
        font-size: 14px;
        color: #7f8c8d;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .summary-icon {
        position: absolute;
        top: 20px;
        right: 20px;
        font-size: 24px;
        color: #5a9b9e;
        opacity: 0.3;
    }

    /* Charts Grid */
    .charts-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
        gap: 30px;
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
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 10px;
    }

    .chart-container {
        position: relative;
        height: 300px;
        margin-bottom: 20px;
    }

    .chart-stats {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
        padding-top: 20px;
        border-top: 1px solid #e9ecef;
    }

    .chart-stat {
        text-align: center;
    }

    .chart-stat-number {
        font-size: 24px;
        font-weight: 700;
        color: #5a9b9e;
    }

    .chart-stat-label {
        font-size: 12px;
        color: #7f8c8d;
        text-transform: uppercase;
    }

    /* Response Timeline */
    .timeline-card {
        background: white;
        padding: 30px;
        border-radius: 12px;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        margin-bottom: 30px;
    }

    .timeline-chart {
        position: relative;
        height: 200px;
    }

    /* Action Buttons */
    .action-buttons {
        display: flex;
        gap: 15px;
        justify-content: center;
        margin-bottom: 30px;
        flex-wrap: wrap;
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

    .btn-success {
        background: #28a745;
        color: white;
    }

    .btn-success:hover {
        background: #218838;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(40, 167, 69, 0.3);
    }

    .btn-warning {
        background: #ffc107;
        color: #212529;
    }

    .btn-warning:hover {
        background: #e0a800;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(255, 193, 7, 0.3);
    }

    @media (max-width: 768px) {
        .tab-nav {
            flex-direction: column;
        }

        .tab-item {
            border-right: none;
            border-bottom: 1px solid #e9ecef;
        }

        .charts-grid {
            grid-template-columns: 1fr;
        }

        .action-buttons {
            flex-direction: column;
            align-items: center;
        }

        .summary-stats {
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
        }

        .chart-container {
            height: 250px;
        }
    }
</style>
@endpush

@section('content')
<!-- Tab Navigation -->
<div class="tab-navigation">
    <div class="tab-nav">
        <a href="{{ route('admin.dashboard', ['tab' => 'summary']) }}" class="tab-item active">
            <i class="fas fa-chart-pie tab-icon"></i>
            <span>Ringkasan</span>
        </a>
        <a href="{{ route('admin.dashboard', ['tab' => 'questions']) }}" class="tab-item">
            <i class="fas fa-question-circle tab-icon"></i>
            <span>Pertanyaan</span>
        </a>
        <a href="{{ route('admin.dashboard', ['tab' => 'individual']) }}" class="tab-item">
            <i class="fas fa-users tab-icon"></i>
            <span>Individual</span>
        </a>
    </div>
</div>

<!-- Action Buttons -->
<div class="action-buttons">
    <a href="{{ route('admin.questions.index') }}" class="btn btn-primary">
        <i class="fas fa-cog"></i>
        Kelola Pertanyaan
    </a>
    <a href="{{ route('survey.index') }}" class="btn btn-success">
        <i class="fas fa-eye"></i>
        Preview Survei
    </a>
    <a href="{{ route('admin.export') }}" class="btn btn-warning">
        <i class="fas fa-download"></i>
        Export Data
    </a>
</div>

<!-- Summary Statistics -->
<div class="summary-stats">
    <div class="summary-card">
        <i class="fas fa-users summary-icon"></i>
        <div class="summary-number">{{ $totalSurveys }}</div>
        <div class="summary-label">Total Responden</div>
    </div>
    <div class="summary-card">
        <i class="fas fa-question-circle summary-icon"></i>
        <div class="summary-number">{{ $questions->count() }}</div>
        <div class="summary-label">Total Pertanyaan</div>
    </div>
    <div class="summary-card">
        <i class="fas fa-comments summary-icon"></i>
        <div class="summary-number">{{ $totalResponses }}</div>
        <div class="summary-label">Total Jawaban</div>
    </div>
    <div class="summary-card">
        <i class="fas fa-calendar summary-icon"></i>
        <div class="summary-number">{{ $dailyStats->sum('count') }}</div>
        <div class="summary-label">Minggu Ini</div>
    </div>
</div>

<!-- Response Timeline -->
<div class="timeline-card">
    <h3 class="chart-title">
        <i class="fas fa-chart-line"></i>
        Trend Responden (7 Hari Terakhir)
    </h3>
    <div class="timeline-chart">
        <canvas id="timelineChart"></canvas>
    </div>
</div>

<!-- Charts Grid -->
<div class="charts-grid">
    <!-- Gender Distribution -->
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-venus-mars"></i>
            Distribusi Jenis Kelamin
        </h3>
        <div class="chart-container">
            <canvas id="genderChart"></canvas>
        </div>
        <div class="chart-stats">
            <div class="chart-stat">
                <div class="chart-stat-number">{{ $maleCount }}</div>
                <div class="chart-stat-label">Laki-laki</div>
            </div>
            <div class="chart-stat">
                <div class="chart-stat-number">{{ $femaleCount }}</div>
                <div class="chart-stat-label">Perempuan</div>
            </div>
        </div>
    </div>

    <!-- Age Distribution -->
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-birthday-cake"></i>
            Distribusi Usia
        </h3>
        <div class="chart-container">
            <canvas id="ageChart"></canvas>
        </div>
        <div class="chart-stats">
            <div class="chart-stat">
                <div class="chart-stat-number">{{ max($ageGroups) }}</div>
                <div class="chart-stat-label">Tertinggi</div>
            </div>
            <div class="chart-stat">
                <div class="chart-stat-number">{{ array_sum($ageGroups) }}</div>
                <div class="chart-stat-label">Total</div>
            </div>
        </div>
    </div>

    <!-- Response Rate -->
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-percentage"></i>
            Tingkat Partisipasi
        </h3>
        <div class="chart-container">
            <canvas id="participationChart"></canvas>
        </div>
        <div class="chart-stats">
            <div class="chart-stat">
                <div class="chart-stat-number">{{ $totalSurveys > 0 ? number_format(($totalResponses / ($questions->count() * $totalSurveys)) * 100, 1) : 0 }}%</div>
                <div class="chart-stat-label">Rata-rata</div>
            </div>
            <div class="chart-stat">
                <div class="chart-stat-number">{{ $questions->count() }}</div>
                <div class="chart-stat-label">Pertanyaan</div>
            </div>
        </div>
    </div>

    <!-- Question Types -->
    <div class="chart-card">
        <h3 class="chart-title">
            <i class="fas fa-list"></i>
            Jenis Pertanyaan
        </h3>
        <div class="chart-container">
            <canvas id="questionTypeChart"></canvas>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Chart.js Configuration
    Chart.defaults.font.family = "'Segoe UI', Tahoma, Geneva, Verdana, sans-serif";
    Chart.defaults.color = '#2c3e50';

    // Color Palette
    const colors = {
        primary: '#5a9b9e',
        secondary: '#4a8b8e',
        success: '#28a745',
        warning: '#ffc107',
        danger: '#dc3545',
        info: '#17a2b8',
        male: '#3498db',
        female: '#e91e63'
    };

    // Timeline Chart
    const timelineCtx = document.getElementById('timelineChart').getContext('2d');
    new Chart(timelineCtx, {
        type: 'line',
        data: {
            labels: @json(collect($responseRates)->pluck('formatted_date')),
            datasets: [{
                label: 'Jumlah Responden',
                data: @json(collect($responseRates)->pluck('count')),
                borderColor: colors.primary,
                backgroundColor: colors.primary + '20',
                borderWidth: 3,
                fill: true,
                tension: 0.4,
                pointBackgroundColor: colors.primary,
                pointBorderColor: '#ffffff',
                pointBorderWidth: 2,
                pointRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e9ecef'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            }
        }
    });

    // Gender Chart
    const genderCtx = document.getElementById('genderChart').getContext('2d');
    new Chart(genderCtx, {
        type: 'doughnut',
        data: {
            labels: ['Laki-laki', 'Perempuan'],
            datasets: [{
                data: [{{ $maleCount }}, {{ $femaleCount }}],
                backgroundColor: [colors.male, colors.female],
                borderWidth: 0
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        padding: 20,
                        usePointStyle: true,
                        font: {
                            size: 14
                        }
                    }
                }
            },
            cutout: '60%'
        }
    });

    // Age Chart
    const ageCtx = document.getElementById('ageChart').getContext('2d');
    new Chart(ageCtx, {
        type: 'bar',
        data: {
            labels: @json(array_keys($ageGroups)),
            datasets: [{
                label: 'Jumlah Responden',
                data: @json(array_values($ageGroups)),
                backgroundColor: colors.primary,
                borderRadius: 8,
                borderSkipped: false,
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: '#e9ecef'
                    }
                },
                x: {
                    grid: {
                        display: false
                    }
                }
            } --}}