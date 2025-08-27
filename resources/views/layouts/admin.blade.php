{{-- resources/views/layouts/admin.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Panel - Survei Kepuasan Diskominfo Lamongan')</title>
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

        /* Success & Error Messages */
        .success-message {
            background: #d4edda;
            border: 1px solid #c3e6cb;
            color: #155724;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #f8d7da;
            border: 1px solid #f5c6cb;
            color: #721c24;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        /* Breadcrumb */
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

        /* Mobile Responsive */
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

            /* Mobile menu toggle */
            .mobile-menu-toggle {
                display: block;
                position: fixed;
                top: 20px;
                left: 20px;
                z-index: 1000;
                background: #2c3e50;
                color: white;
                border: none;
                padding: 10px;
                border-radius: 4px;
                cursor: pointer;
            }
        }

        .mobile-menu-toggle {
            display: none;
        }

        /* Mobile Overlay */
        .mobile-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.5);
            z-index: 999;
        }

        @media (max-width: 768px) {
            .mobile-overlay.active {
                display: block;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="admin-layout">
        <!-- Mobile Menu Toggle -->
        <button class="mobile-menu-toggle" onclick="toggleMobileMenu()">
            <span class="menu-icon">☰</span>
        </button>

        <!-- Mobile Overlay -->
        <div class="mobile-overlay" onclick="closeMobileMenu()"></div>

        <!-- Sidebar -->
        <div class="sidebar" id="sidebar">
            <div class="sidebar-header">
                <div class="sidebar-title">Admin Panel</div>
                <div class="sidebar-subtitle">Survei Kepuasan Diskominfo</div>
            </div>

            <div class="sidebar-menu">
                <a href="{{ route('admin.dashboard') }}" class="menu-item @yield('active-dashboard')">
                    <span class="menu-icon">📊</span>
                    Dashboard
                </a>
                <a href="{{ route('admin.questions.index') }}" class="menu-item @yield('active-questions')">
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
                <div>
                    <h1 class="page-title">@yield('page-title', 'Dashboard Administrator')</h1>
                    <p class="page-subtitle">@yield('page-subtitle', 'Kelola survei kepuasan masyarakat')</p>
                </div>
                @yield('header-actions')
            </div>

            <div class="content-body">
                @yield('breadcrumb')

                @if (session('success'))
                    <div class="success-message">
                        {{ session('success') }}
                    </div>
                @endif

                @if (session('error'))
                    <div class="error-message">
                        {{ session('error') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="error-message">
                        <ul style="margin: 0; padding-left: 20px;">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <script>
        function toggleMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.toggle('open');
            overlay.classList.toggle('active');
        }

        function closeMobileMenu() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.querySelector('.mobile-overlay');
            
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
        }

        // Auto hide success/error messages
        document.addEventListener('DOMContentLoaded', function() {
            const successMessage = document.querySelector('.success-message');
            const errorMessage = document.querySelector('.error-message');
            
            if (successMessage) {
                setTimeout(() => {
                    successMessage.style.display = 'none';
                }, 5000);
            }
            
            if (errorMessage) {
                setTimeout(() => {
                    errorMessage.style.display = 'none';
                }, 5000);
            }
        });
    </script>
    @stack('scripts')
</body>
</html>