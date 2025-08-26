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
            color: #2c3e50;
        }

        .admin-layout {
            display: flex;
            min-height: 100vh;
        }

        /* Sidebar */
        .sidebar {
            width: 250px;
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            position: fixed;
            height: 100vh;
            overflow-y: auto;
        }

        .sidebar-header {
            padding: 20px;
            background: rgba(0, 0, 0, 0.1);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
        }

        .sidebar-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .sidebar-subtitle {
            font-size: 12px;
            opacity: 0.8;
        }

        .sidebar-menu {
            padding: 20px 0;
        }

        .menu-item {
            display: block;
            padding: 15px 20px;
            color: white;
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
            border-left-color: #5a9b9e;
        }

        .menu-item.active {
            background: rgba(90, 155, 158, 0.2);
            border-left-color: #5a9b9e;
        }

        .menu-icon {
            display: inline-block;
            width: 20px;
            margin-right: 10px;
        }

        .logout-section {
            position: absolute;
            bottom: 20px;
            left: 20px;
            right: 20px;
        }

        .logout-btn {
            display: block;
            padding: 10px 15px;
            background: rgba(231, 76, 60, 0.2);
            color: white;
            text-decoration: none;
            border-radius: 6px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .logout-btn:hover {
            background: rgba(231, 76, 60, 0.3);
        }

        /* Main Content */
        .main-content {
            flex: 1;
            margin-left: 250px;
            background: #f8f9fa;
        }

        .content-header {
            background: white;
            padding: 20px 30px;
            border-bottom: 1px solid #e9ecef;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .page-info h1 {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .page-info p {
            color: #7f8c8d;
            font-size: 14px;
        }

        .header-actions {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .admin-welcome {
            font-size: 14px;
            color: #7f8c8d;
        }

        .content-body {
            padding: 30px;
        }

        /* Stats Cards */
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

        /* Action Buttons */
        .action-buttons {
            margin-bottom: 30px;
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
        }

        .btn {
            padding: 12px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 8px;
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
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        /* Charts Section */
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

        /* Data Table */
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

        /* Survey Type Switcher */
        .survey-type-switcher {
            background: white;
            padding: 20px 25px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-bottom: 30px;
        }

        .switch-header {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .switch-options {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .switch-option {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .switch-option input[type="radio"] {
            margin: 0;
        }

        .switch-option label {
            font-size: 14px;
            color: #495057;
            cursor: pointer;
        }

        .survey-info {
            margin-top: 15px;
            padding: 15px;
            background: #e8f4f8;
            border-radius: 8px;
            border-left: 4px solid #5a9b9e;
        }

        .info-static {
            display: block;
        }

        .info-dynamic {
            display: none;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s ease;
            }

            .sidebar.open {
                transform: translateX(0);
            }

            .main-content {
                margin-left: 0;
            }

            .content-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .content-body {
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

            .action-buttons {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <div class="admin-layout">
        <!-- Sidebar -->
        <div class="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">Admin Panel</div>
                <div class="sidebar-subtitle">Survei Kepuasan Diskominfo</div>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item active">
                    <span class="menu-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.questions.index') }}" class="menu-item">
                    <span class="menu-icon">❓</span>
                    Pertanyaan
                </a>
            </div>

            <div class="logout-section">
                <a href="{{ route('admin.logout') }}" class="logout-btn">
                    Logout
                </a>
            </div>
        </div>

        <!-- Main Content -->
        <div class="main-content">
            <div class="content-header">
                <div class="page-info">
                    <h1>Dashboard Administrator</h1>
                    <p>Kelola survei kepuasan masyarakat</p>
                </div>
                <div class="header-actions">
                    <span class="admin-welcome">Selamat datang, {{ session('admin_name') }}</span>
                </div>
            </div>

            <div class="content-body">
                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Survey Type Switcher -->
                <div class="survey-type-switcher">
                    <div class="switch-header">🎯 Mode Survei Aktif</div>
                    <div class="switch-options">
                        <div class="switch-option">
                            <input type="radio" id="survey_static" name="survey_type" value="static" checked>
                            <label for="survey_static">Survei Statis (Data Diri)</label>
                        </div>
                        <div class="switch-option">
                            <input type="radio" id="survey_dynamic" name="survey_type" value="dynamic">
                            <label for="survey_dynamic">Survei Dinamis (Custom)</label>
                        </div>
                    </div>
                    
                    <div class="survey-info">
                        <div class="info-static">
                            <strong>📝 Survei Statis:</strong> Form sederhana dengan 3 pertanyaan tetap (Nama, Jenis Kelamin, Usia)
                        </div>
                        <div class="info-dynamic">
                            <strong>⚙️ Survei Dinamis:</strong> Survei dengan pertanyaan custom yang bisa Anda atur sendiri melalui menu Pertanyaan
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.export') }}" class="btn btn-success">
                        <span>📥</span>
                        Export Data CSV
                    </a>
                    <a href="{{ route('survey.index') }}" class="btn btn-primary" id="previewSurveyBtn">
                        <span>👁️</span>
                        Preview Survei
                    </a>
                    <a href="{{ route('admin.questions.index') }}" class="btn btn-warning">
                        <span>⚙️</span>
                        Kelola Pertanyaan
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
        </div>
    </div>

    <script>
        // Survey type switcher
        document.addEventListener('DOMContentLoaded', function() {
            const staticRadio = document.getElementById('survey_static');
            const dynamicRadio = document.getElementById('survey_dynamic');
            const infoStatic = document.querySelector('.info-static');
            const infoDynamic = document.querySelector('.info-dynamic');
            const previewBtn = document.getElementById('previewSurveyBtn');

            function updateSurveyInfo() {
                if (staticRadio.checked) {
                    infoStatic.style.display = 'block';
                    infoDynamic.style.display = 'none';
                    previewBtn.href = '{{ route("survey.index") }}';
                } else {
                    infoStatic.style.display = 'none';
                    infoDynamic.style.display = 'block';
                    previewBtn.href = '/dynamic-survey';
                }
            }

            staticRadio.addEventListener('change', updateSurveyInfo);
            dynamicRadio.addEventListener('change', updateSurveyInfo);

            // Initialize
            updateSurveyInfo();

            // Auto hide success message
            const successMessage = document.querySelector('.success-message');
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
</body>
</html>