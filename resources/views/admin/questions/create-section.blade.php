{{-- resources/views/admin/questions/create-section.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Bagian - Admin Survei</title>
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
        }

        .page-title {
            font-size: 24px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 5px;
        }

        .page-subtitle {
            color: #7f8c8d;
            font-size: 14px;
        }

        .content-body {
            padding: 30px;
        }

        /* Form Styles */
        .form-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            margin: 0 auto;
        }

        .form-header {
            background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
            color: white;
            padding: 25px 30px;
            border-radius: 12px 12px 0 0;
        }

        .form-title {
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 8px;
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
            font-size: 16px;
        }

        .form-input {
            width: 100%;
            padding: 15px 18px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 16px;
            transition: all 0.3s ease;
            background: #fff;
            font-family: inherit;
        }

        .form-input:focus {
            outline: none;
            border-color: #5a9b9e;
            box-shadow: 0 0 0 3px rgba(90, 155, 158, 0.1);
        }

        .form-textarea {
            min-height: 120px;
            resize: vertical;
        }

        .form-help {
            font-size: 14px;
            color: #7f8c8d;
            margin-top: 5px;
        }

        .form-actions {
            display: flex;
            gap: 15px;
            justify-content: flex-end;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #e9ecef;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 16px;
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

        .btn-secondary {
            background: #6c757d;
            color: white;
        }

        .btn-secondary:hover {
            background: #5a6268;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(108, 117, 125, 0.3);
        }

        .btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }

        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .breadcrumb {
            margin-bottom: 20px;
        }

        .breadcrumb a {
            color: #5a9b9e;
            text-decoration: none;
        }

        .breadcrumb a:hover {
            text-decoration: underline;
        }

        .breadcrumb-separator {
            margin: 0 8px;
            color: #7f8c8d;
        }

        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
            }

            .main-content {
                margin-left: 0;
            }

            .content-body {
                padding: 20px 15px;
            }

            .form-container {
                margin: 0;
                border-radius: 8px;
            }

            .form-body {
                padding: 20px;
            }

            .form-actions {
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
                <a href="{{ route('admin.dashboard') }}" class="menu-item">
                    <span class="menu-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.questions.index') }}" class="menu-item active">
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
                <h1 class="page-title">Tambah Bagian Baru</h1>
                <p class="page-subtitle">Buat bagian baru untuk mengelompokkan pertanyaan survei</p>
            </div>

            <div class="content-body">
                <div class="breadcrumb">
                    <a href="{{ route('admin.questions.index') }}">Pertanyaan</a>
                    <span class="breadcrumb-separator">></span>
                    <span>Tambah Bagian</span>
                </div>

                @if ($errors->any())
                    <div class="error-message">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="form-container">
                    <div class="form-header">
                        <div class="form-title">📝 Informasi Bagian</div>
                        <div class="form-subtitle">Isi detail bagian yang akan ditambahkan ke survei</div>
                    </div>

                    <form method="POST" action="{{ route('admin.questions.store-section') }}" class="form-body">
                        @csrf
                        
                        <div class="form-group">
                            <label class="form-label" for="title">Judul Bagian *</label>
                            <input 
                                type="text" 
                                id="title" 
                                name="title" 
                                class="form-input" 
                                placeholder="Contoh: Data Diri, Evaluasi Layanan, dll" 
                                value="{{ old('title') }}"
                                required
                            >
                            <div class="form-help">Judul ini akan ditampilkan sebagai header bagian</div>
                        </div>

                        <div class="form-group">
                            <label class="form-label" for="description">Deskripsi Bagian</label>
                            <textarea 
                                id="description" 
                                name="description" 
                                class="form-input form-textarea" 
                                placeholder="Jelaskan tujuan atau instruksi untuk bagian ini (opsional)"
                            >{{ old('description') }}</textarea>
                            <div class="form-help">Deskripsi akan ditampilkan di bawah judul untuk memberikan konteks kepada responden</div>
                        </div>

                        <div class="form-actions">
                            <a href="{{ route('admin.questions.index') }}" class="btn btn-secondary">
                                ← Batal
                            </a>
                            <button type="submit" class="btn btn-primary">
                                💾 Simpan Bagian
                            </button>
                        </div>
                    </form>
                </div>

                <div style="margin-top: 30px; padding: 20px; background: #e8f4f8; border-radius: 8px; border-left: 4px solid #5a9b9e;">
                    <h4 style="color: #2c3e50; margin-bottom: 10px;">💡 Tips Membuat Bagian</h4>
                    <ul style="color: #5a6c7d; line-height: 1.6;">
                        <li><strong>Kelompokkan pertanyaan serupa:</strong> Misalnya "Data Diri", "Evaluasi Layanan", "Saran"</li>
                        <li><strong>Urutan logis:</strong> Mulai dari informasi umum, lalu spesifik</li>
                        <li><strong>Tidak terlalu panjang:</strong> Maksimal 5-7 pertanyaan per bagian</li>
                        <li><strong>Judul yang jelas:</strong> Gunakan bahasa yang mudah dipahami responden</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>

    <script>
        // Auto focus pada input pertama
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('title').focus();
        });

        // Preview judul saat mengetik
        document.getElementById('title').addEventListener('input', function() {
            const title = this.value.trim();
            const formTitle = document.querySelector('.form-title');
            if (title) {
                formTitle.textContent = `📝 ${title}`;
            } else {
                formTitle.textContent = '📝 Informasi Bagian';
            }
        });
    </script>
</body>
</html>