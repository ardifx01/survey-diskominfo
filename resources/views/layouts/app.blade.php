{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Survei Kepuasan Layanan Diskominfo Lamongan')</title>
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
            display: flex;
            flex-direction: column;
        }

        .container {
            width: 100%;
            margin: 0;
            background: white;
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .header {
            background-color: #5a9b9e;
            color: white;
            padding: 30px 40px;
            position: relative;
        }

        .header-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .logos {
            display: flex;
            align-items: center;
            gap: 30px;
        }

        .logo-item {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .logo-image {
            width: 60px;
            height: 60px;
            border-radius: 8px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-text {
            color: white;
            text-align: center;
        }

        .logo-text .main-text {
            font-size: 14px;
            font-weight: 700;
            margin-bottom: 2px;
        }

        .logo-text .sub-text {
            font-size: 11px;
            opacity: 0.9;
            line-height: 1.2;
        }

        .program-badges {
            display: flex;
            gap: 15px;
            align-items: center;
        }

        .badge {
            background: rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 500;
            border: 1px solid rgba(255, 255, 255, 0.3);
        }

        .title-section {
            text-align: center;
        }

        .title-section h1 {
            font-size: 32px;
            font-weight: bold;
            margin-bottom: 8px;
            letter-spacing: 1px;
        }

        .title-section h2 {
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .title-section h3 {
            font-size: 18px;
            font-weight: 500;
            opacity: 0.95;
            margin-bottom: 5px;
        }

        .title-section h4 {
            font-size: 20px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
        }

        .main-content {
            padding: 50px 40px;
            flex: 1;
        }

        /* Footer Styles */
        .footer {
            background: linear-gradient(135deg, #2c3e50 0%, #34495e 100%);
            color: white;
            padding: 40px 0 20px 0;
            margin-top: auto;
        }

        .footer-content {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 40px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr;
            gap: 40px;
            margin-bottom: 30px;
        }

        .footer-section h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 15px;
            color: #5a9b9e;
        }

        .footer-section p,
        .footer-section li {
            font-size: 14px;
            line-height: 1.6;
            opacity: 0.9;
            margin-bottom: 8px;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            padding: 5px 0;
        }

        .footer-section ul li:before {
            content: "▶";
            color: #5a9b9e;
            font-size: 10px;
            margin-right: 8px;
        }

        .footer-contact {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 10px;
        }

        .footer-contact .icon {
            width: 20px;
            height: 20px;
            background: #5a9b9e;
            border-radius: 3px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            font-size: 13px;
            opacity: 0.8;
            margin-bottom: 5px;
        }

        .footer-links {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 15px;
        }

        .footer-links a {
            color: #5a9b9e;
            text-decoration: none;
            font-size: 13px;
            font-weight: 500;
        }

        .footer-links a:hover {
            opacity: 0.8;
        }

        @media (max-width: 768px) {
            .header {
                padding: 20px;
            }
            
            .header-content {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }
            
            .logos {
                flex-direction: column;
                gap: 15px;
            }

            .logo-item {
                flex-direction: column;
                gap: 10px;
                text-align: center;
            }

            .logo-image {
                width: 50px;
                height: 50px;
            }
            
            .program-badges {
                justify-content: center;
                flex-wrap: wrap;
            }
            
            .main-content {
                padding: 30px 20px;
            }

            .title-section h1 {
                font-size: 24px;
            }

            .title-section h2 {
                font-size: 20px;
            }

            .title-section h4 {
                font-size: 16px;
            }

            .footer-content {
                padding: 0 20px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 25px;
                text-align: center;
            }

            .footer-links {
                flex-wrap: wrap;
                gap: 15px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logos">
                    <!-- Logo Jawa Timur -->
                    <div class="logo-item">
                        <div class="logo-image">
                            <img src="{{ asset('images/logos/logo-diskominfo.png') }}" alt="Logo Jawa Timur">
                        </div>
                        <div class="logo-text">
                            <div class="main-text">PROVINSI JAWA TIMUR</div>
                            <div class="sub-text">GERBANG KERTOSUSILO</div>
                        </div>
                    </div>

                    <!-- Logo Lamongan -->
                    <div class="logo-item">
                        <div class="logo-image">
                            <img src="{{ asset('images/logos/logo-lamongan.png') }}" alt="Logo Kabupaten Lamongan">
                        </div>
                        <div class="logo-text">
                            <div class="main-text">KABUPATEN LAMONGAN</div>
                            <div class="sub-text">LAMONGAN BERKARAKTER</div>
                        </div>
                    </div>

                    <!-- Logo Diskominfo -->
                    <div class="logo-item">
                        <div class="logo-image">
                            <img src="{{ asset('images/logos/logo-diskominfo.png') }}" alt="Logo Diskominfo">
                        </div>
                        <div class="logo-text">
                            <div class="main-text">DISKOMINFO</div>
                            <div class="sub-text">LAMONGAN</div>
                        </div>
                    </div>
                </div>
                
                <div class="program-badges">
                    <div class="badge">BerAKHLAK</div>
                    <div class="badge"># bangga melayani bangsa</div>
                </div>
            </div>
            
            <div class="title-section">
                <h1>Selamat Datang</h1>
                <h2>Survei Kepuasan Masyarakat</h2>
                <h3>Pada</h3>
                <h3>Dinas Komunikasi dan Informatika</h3>
                <h4>KABUPATEN LAMONGAN</h4>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>

        <div class="footer">
            <div class="footer-content">
                <div class="footer-grid">
                    <!-- Tentang -->
                    <div class="footer-section">
                        <h4>Dinas Komunikasi dan Informatika</h4>
                        <p>Kabupaten Lamongan</p>
                        <p>Melayani masyarakat dengan dedikasi tinggi dalam bidang komunikasi dan informatika untuk mewujudkan Lamongan yang lebih maju dan berkarakter.</p>
                        
                        <div class="footer-contact">
                            <div class="icon">📍</div>
                            <span>Jl. Veteran No.1, Lamongan, Jawa Timur</span>
                        </div>
                        
                        <div class="footer-contact">
                            <div class="icon">📞</div>
                            <span>(0322) 311234</span>
                        </div>
                        
                        <div class="footer-contact">
                            <div class="icon">📧</div>
                            <span>diskominfo@lamongankab.go.id</span>
                        </div>
                    </div>

                    <!-- Layanan -->
                    <div class="footer-section">
                        <h4>Layanan Kami</h4>
                        <ul>
                            <li>Sistem Informasi</li>
                            <li>Komunikasi Publik</li>
                            <li>Statistik Daerah</li>
                            <li>Website Resmi</li>
                            <li>Media Center</li>
                            <li>Helpdesk IT</li>
                        </ul>
                    </div>

                    <!-- Program -->
                    <div class="footer-section">
                        <h4>Program Unggulan</h4>
                        <ul>
                            <li>Smart City Lamongan</li>
                            <li>Digital Government</li>
                            <li>Literasi Digital</li>
                            <li>One Data</li>
                            <li>Cyber Security</li>
                            <li>E-Government</li>
                        </ul>
                    </div>
                </div>

                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Lamongan</p>
                    <p>Survei Kepuasan Masyarakat - Sistem Informasi Pelayanan Publik</p>
                    
                    <div class="footer-links">
                        <a href="#privacy">Kebijakan Privasi</a>
                        <a href="#terms">Syarat & Ketentuan</a>
                        <a href="#sitemap">Peta Situs</a>
                        <a href="{{ route('admin.login') }}">Admin</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @stack('scripts')
</body>
</html>