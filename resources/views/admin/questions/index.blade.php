{{-- resources/views/admin/questions/index.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manajemen Pertanyaan - Admin Survei</title>
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

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .btn-danger:hover {
            background: #c82333;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .btn-warning:hover {
            background: #e0a800;
        }

        .btn-sm {
            padding: 6px 12px;
            font-size: 12px;
        }

        /* Sections Container */
        .sections-container {
            display: grid;
            gap: 30px;
        }

        .section-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .section-header {
            background: linear-gradient(135deg, #5a9b9e 0%, #4a8b8e 100%);
            color: white;
            padding: 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .section-title {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .section-description {
            font-size: 14px;
            opacity: 0.9;
        }

        .section-actions {
            display: flex;
            gap: 10px;
        }

        .section-body {
            padding: 0;
        }

        .questions-list {
            border-collapse: collapse;
            width: 100%;
        }

        .questions-list th {
            background: #f8f9fa;
            padding: 15px;
            text-align: left;
            font-weight: 600;
            color: #2c3e50;
            border-bottom: 1px solid #dee2e6;
        }

        .questions-list td {
            padding: 15px;
            border-bottom: 1px solid #dee2e6;
        }

        .questions-list tr:hover {
            background: #f8f9fa;
        }

        .question-type-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 500;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .badge-short-text { background: #e3f2fd; color: #1976d2; }
        .badge-long-text { background: #f3e5f5; color: #7b1fa2; }
        .badge-multiple-choice { background: #e8f5e8; color: #388e3c; }
        .badge-checkbox { background: #fff3e0; color: #f57c00; }
        .badge-dropdown { background: #fce4ec; color: #c2185b; }
        .badge-file-upload { background: #f1f8e9; color: #689f38; }
        .badge-linear-scale { background: #e0f2f1; color: #00796b; }

        .status-badge {
            padding: 4px 8px;
            border-radius: 12px;
            font-size: 11px;
            font-weight: 500;
        }

        .status-active {
            background: #d4edda;
            color: #155724;
        }

        .status-inactive {
            background: #f8d7da;
            color: #721c24;
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

        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
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

            .content-body {
                padding: 20px 15px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .section-header {
                flex-direction: column;
                gap: 15px;
                text-align: center;
            }

            .section-actions {
                justify-content: center;
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
                <h1 class="page-title">Manajemen Pertanyaan</h1>
                <p class="page-subtitle">Kelola bagian dan pertanyaan survei kepuasan</p>
            </div>

            <div class="content-body">
                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                <!-- Action Buttons -->
                <div class="action-buttons">
                    <a href="{{ route('admin.questions.create-section') }}" class="btn btn-primary">
                        <span>➕</span>
                        Tambahkan Bagian
                    </a>
                    <a href="{{ route('survey.index') }}" class="btn btn-success">
                        <span>👁️</span>
                        Preview Survei
                    </a>
                </div>

                <!-- Sections -->
                <div class="sections-container">
                    @forelse($sections as $section)
                    <div class="section-card">
                        <div class="section-header">
                            <div>
                                <div class="section-title">{{ $section->title }}</div>
                                @if($section->description)
                                    <div class="section-description">{{ $section->description }}</div>
                                @endif
                            </div>
                            <div class="section-actions">
                                <span class="status-badge {{ $section->is_active ? 'status-active' : 'status-inactive' }}">
                                    {{ $section->is_active ? 'Aktif' : 'Nonaktif' }}
                                </span>
                                <a href="{{ route('admin.questions.create-question', $section->id) }}" class="btn btn-success btn-sm">
                                    ➕ Tambah Pertanyaan
                                </a>
                                <a href="#" onclick="toggleSection({{ $section->id }})" class="btn btn-warning btn-sm">
                                    {{ $section->is_active ? '🔒 Nonaktifkan' : '🔓 Aktifkan' }}
                                </a>
                                <a href="#" onclick="deleteSection({{ $section->id }}, '{{ $section->title }}')" class="btn btn-danger btn-sm">
                                    🗑️ Hapus
                                </a>
                            </div>
                        </div>

                        <div class="section-body">
                            @if($section->allQuestions->count() > 0)
                                <table class="questions-list">
                                    <thead>
                                        <tr>
                                            <th style="width: 50px;">No</th>
                                            <th>Pertanyaan</th>
                                            <th style="width: 150px;">Jenis</th>
                                            <th style="width: 100px;">Required</th>
                                            <th style="width: 80px;">Status</th>
                                            <th style="width: 200px;">Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($section->allQuestions as $question)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>
                                                <div style="font-weight: 500;">{{ $question->question_text }}</div>
                                                @if($question->options && count($question->options) > 0)
                                                    <small style="color: #7f8c8d;">
                                                        Opsi: {{ implode(', ', array_slice($question->options, 0, 3)) }}
                                                        @if(count($question->options) > 3)
                                                            ... (+{{ count($question->options) - 3 }} lainnya)
                                                        @endif
                                                    </small>
                                                @endif
                                            </td>
                                            <td>
                                                <span class="question-type-badge badge-{{ str_replace('_', '-', $question->question_type) }}">
                                                    {{ $question->getQuestionTypeLabel() }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $question->is_required ? 'status-active' : 'status-inactive' }}">
                                                    {{ $question->is_required ? 'Ya' : 'Tidak' }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="status-badge {{ $question->is_active ? 'status-active' : 'status-inactive' }}">
                                                    {{ $question->is_active ? 'Aktif' : 'Nonaktif' }}
                                                </span>
                                            </td>
                                            <td>
                                                <div style="display: flex; gap: 5px; flex-wrap: wrap;">
                                                    <a href="{{ route('admin.questions.edit-question', $question->id) }}" class="btn btn-primary btn-sm">
                                                        ✏️
                                                    </a>
                                                    <a href="#" onclick="toggleQuestion({{ $question->id }})" class="btn btn-warning btn-sm">
                                                        {{ $question->is_active ? '🔒' : '🔓' }}
                                                    </a>
                                                    <a href="#" onclick="deleteQuestion({{ $question->id }}, '{{ addslashes($question->question_text) }}')" class="btn btn-danger btn-sm">
                                                        🗑️
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            @else
                                <div class="empty-state">
                                    <div class="empty-icon">❓</div>
                                    <h4>Belum Ada Pertanyaan</h4>
                                    <p>Bagian ini belum memiliki pertanyaan. Klik tombol "Tambah Pertanyaan" untuk menambahkan pertanyaan pertama.</p>
                                    <br>
                                    <a href="{{ route('admin.questions.create-question', $section->id) }}" class="btn btn-primary">
                                        ➕ Tambah Pertanyaan Pertama
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="section-card">
                        <div class="empty-state">
                            <div class="empty-icon">📝</div>
                            <h3>Belum Ada Bagian Survei</h3>
                            <p>Mulai membuat survei dengan menambahkan bagian pertama. Setiap bagian dapat berisi beberapa pertanyaan yang akan ditampilkan pada halaman yang sama.</p>
                            <br>
                            <a href="{{ route('admin.questions.create-section') }}" class="btn btn-primary">
                                ➕ Tambahkan Bagian Pertama
                            </a>
                        </div>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </div>

    <!-- Forms for POST requests -->
    <form id="toggleSectionForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>

    <form id="deleteSectionForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <form id="toggleQuestionForm" method="POST" style="display: none;">
        @csrf
        @method('PUT')
    </form>

    <form id="deleteQuestionForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        function toggleSection(sectionId) {
            if (confirm('Yakin ingin mengubah status bagian ini?')) {
                const form = document.getElementById('toggleSectionForm');
                form.action = `/admin/questions/section/${sectionId}/toggle`;
                form.submit();
            }
        }

        function deleteSection(sectionId, sectionTitle) {
            if (confirm(`Yakin ingin menghapus bagian "${sectionTitle}"?\n\nSemua pertanyaan di bagian ini juga akan terhapus dan tidak dapat dikembalikan.`)) {
                const form = document.getElementById('deleteSectionForm');
                form.action = `/admin/questions/section/${sectionId}`;
                form.submit();
            }
        }

        function toggleQuestion(questionId) {
            if (confirm('Yakin ingin mengubah status pertanyaan ini?')) {
                const form = document.getElementById('toggleQuestionForm');
                form.action = `/admin/questions/question/${questionId}/toggle`;
                form.submit();
            }
        }

        function deleteQuestion(questionId, questionText) {
            const truncatedText = questionText.length > 50 ? questionText.substring(0, 50) + '...' : questionText;
            if (confirm(`Yakin ingin menghapus pertanyaan:\n"${truncatedText}"\n\nData ini tidak dapat dikembalikan.`)) {
                const form = document.getElementById('deleteQuestionForm');
                form.action = `/admin/questions/question/${questionId}`;
                form.submit();
            }
        }

        // Auto hide success message
        document.addEventListener('DOMContentLoaded', function() {
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