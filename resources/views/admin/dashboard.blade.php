{{-- resources/views/admin/dashboard.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - Survei Kepuasan Diskominfo Lamongan</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            min-height: 100vh;
            color: #2c3e50;
        }

        .admin-header {
            background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
            color: white;
            padding: 20px 30px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .admin-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .admin-title {
            font-size: 20px;
            font-weight: 700;
        }

        .admin-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .admin-welcome {
            font-size: 14px;
            opacity: 0.9;
        }

        .btn {
            padding: 8px 16px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: 500;
            font-size: 14px;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }

        .btn-export {
            background: #28a745;
            color: white;
        }

        .btn-export:hover {
            background: #218838;
        }

        .btn-logout {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .btn-logout:hover {
            background: rgba(255, 255, 255, 0.3);
        }

        .dashboard-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 30px;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 40px;
        }

        .stat-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            text-align: center;
            border-left: 4px solid #5a9b9e;
        }

        .stat-number {
            font-size: 32px;
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

        .charts-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
            margin-bottom: 40px;
        }

        .chart-card {
            background: white;
            padding: 25px;
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

        .data-table {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
            margin-bottom: 30px;
        }

        .table-header {
            background: #5a9b9e;
            color: white;
            padding: 20px 25px;
            font-size: 18px;
            font-weight: 600;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .table-actions {
            display: flex;
            gap: 10px;
        }

        .table-container {
            overflow-x: auto;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
        }

        .table th {
            background: #f8f9fa;
            padding: 15px 10px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid #dee2e6;
            font-size: 14px;
        }

        .table td {
            padding: 15px 10px;
            border-bottom: 1px solid #dee2e6;
            color: #495057;
            font-size: 14px;
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

        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 4px;
            text-decoration: none;
            font-size: 12px;
            font-weight: 500;
        }

        .btn-delete:hover {
            background: #c82333;
        }

        .pagination {
            display: flex;
            justify-content: center;
            gap: 8px;
            margin-top: 20px;
        }

        .pagination a, .pagination span {
            padding: 8px 12px;
            border: 1px solid #dee2e6;
            border-radius: 4px;
            text-decoration: none;
            color: #495057;
            font-size: 14px;
        }

        .pagination .current {
            background: #5a9b9e;
            color: white;
            border-color: #5a9b9e;
        }

        .pagination a:hover {
            background: #f8f9fa;
        }

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 12px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .daily-stats {
            margin-top: 15px;
        }

        .daily-item {
            display: flex;
            justify-content: space-between;
            padding: 8px 0;
            border-bottom: 1px solid #f0f0f0;
        }

        .daily-item:last-child {
            border-bottom: none;
        }

        @media (max-width: 768px) {
            .admin-nav {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .admin-actions {
                flex-wrap: wrap;
                justify-content: center;
            }

            .dashboard-container {
                padding: 20px 15px;
            }

            .charts-section {
                grid-template-columns: 1fr;
            }

            .stats-grid {
                grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            }

            .table-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .table th, .table td {
                padding: 10px 8px;
                font-size: 13px;
            }
        }
    </style>
</head>
<body>
    <div class="admin-header">
        <div class="admin-nav">
            <div class="admin-title">Dashboard Administrator</div>
            <div class="admin-actions">
                <span class="admin-welcome">Selamat datang, {{ session('admin_name') }}</span>
                <a href="{{ route('admin.export') }}" class="btn btn-export">Export CSV</a>
                <a href="{{ route('admin.logout') }}" class="btn btn-logout">Logout</a>
            </div>
        </div>
    </div>

    <div class="dashboard-container">
        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

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
                <div class="stat-number">{{ $surveys->currentPage() }}</div>
                <div class="stat-label">Halaman {{ $surveys->currentPage() }} dari {{ $surveys->lastPage() }}</div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="charts-section">
            <!-- Age Distribution -->
            <div class="chart-card">
                <h3 class="chart-title">Distribusi Usia</h3>
                <div>
                    @forelse($ageStats as $ageStat)
                        @if($ageStat->age_group)
                            <div style="display: flex; justify-content: space-between; margin-bottom: 10px; padding: 8px; background: #f8f9fa; border-radius: 6px;">
                                <span>{{ $ageStat->age_group }} tahun</span>
                                <strong>{{ $ageStat->count }} orang</strong>
                            </div>
                        @endif
                    @empty
                        <p style="text-align: center; color: #7f8c8d;">Belum ada data</p>
                    @endforelse
                </div>
            </div>

            <!-- Daily Stats -->
            <div class="chart-card">
                <h3 class="chart-title">Statistik 7 Hari Terakhir</h3>
                <div class="daily-stats">
                    @forelse($dailyStats as $daily)
                        <div class="daily-item">
                            <span>{{ \Carbon\Carbon::parse($daily->date)->format('d/m/Y') }}</span>
                            <strong>{{ $daily->count }} responden</strong>
                        </div>
                    @empty
                        <p style="text-align: center; color: #7f8c8d; padding: 20px;">Belum ada data 7 hari terakhir</p>
                    @endforelse
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="data-table">
            <div class="table-header">
                <span>Semua Data Survei ({{ $surveys->total() }} total)</span>
                <div class="table-actions">
                    <a href="{{ route('survey.index') }}" class="btn" style="background: rgba(255,255,255,0.2); color: white;">Lihat Form Survei</a>
                </div>
            </div>
            <div class="table-container">
                <table class="table">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Usia</th>
                            <th>IP Address</th>
                            <th>User Agent</th>
                            <th>Tanggal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($surveys as $survey)
                        <tr>
                            <td>{{ ($surveys->currentPage() - 1) * $surveys->perPage() + $loop->iteration }}</td>
                            <td><strong>{{ $survey->nama }}</strong></td>
                            <td>
                                <span class="gender-badge {{ $survey->jenis_kelamin === 'laki_laki' ? 'badge-male' : 'badge-female' }}">
                                    {{ $survey->jenis_kelamin_label }}
                                </span>
                            </td>
                            <td>{{ $survey->usia }} tahun</td>
                            <td style="font-family: monospace; font-size: 12px;">{{ $survey->ip_address ?? '-' }}</td>
                            <td style="font-size: 11px; max-width: 200px; word-break: break-all;">
                                {{ Str::limit($survey->user_agent ?? '-', 50) }}
                            </td>
                            <td style="font-size: 12px;">{{ $survey->created_at->format('d/m/Y H:i') }}</td>
                            <td>
                                <a href="#" onclick="if(confirm('Yakin ingin menghapus data {{ $survey->nama }}?')) { document.getElementById('delete-{{ $survey->id }}').submit(); }" class="btn-delete">Hapus</a>
                                <form id="delete-{{ $survey->id }}" action="{{ route('admin.deleteSurvey', $survey->id) }}" method="POST" style="display: none;">
                                    @csrf
                                    @method('DELETE')
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="8" style="text-align: center; color: #7f8c8d; padding: 40px;">
                                Belum ada data survei
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Pagination -->
        @if($surveys->hasPages())
        <div class="pagination">
            {{-- Previous Page Link --}}
            @if ($surveys->onFirstPage())
                <span>&laquo; Sebelumnya</span>
            @else
                <a href="{{ $surveys->previousPageUrl() }}">&laquo; Sebelumnya</a>
            @endif

            {{-- Pagination Elements --}}
            @foreach ($surveys->getUrlRange(1, $surveys->lastPage()) as $page => $url)
                @if ($page == $surveys->currentPage())
                    <span class="current">{{ $page }}</span>
                @else
                    <a href="{{ $url }}">{{ $page }}</a>
                @endif
            @endforeach

            {{-- Next Page Link --}}
            @if ($surveys->hasMorePages())
                <a href="{{ $surveys->nextPageUrl() }}">Selanjutnya &raquo;</a>
            @else
                <span>Selanjutnya &raquo;</span>
            @endif
        </div>
        @endif
    </div>
</body>
</html>