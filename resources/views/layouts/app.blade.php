{{-- resources/views/layouts/app.blade.php --}}
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Survei Kepuasan Layanan Diskominfo Lamongan')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
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
            gap: 20px;
            flex-wrap: nowrap;
            overflow-x: auto;
            padding: 5px 0;
        }

        .logo-item {
            display: flex;
            align-items: center;
            gap: 15px;
            flex-shrink: 0;
        }

        /* Dynamic logo sizing based on count */
        .logo-image {
            border-radius: 8px;
            overflow: hidden;
            background: rgba(255, 255, 255, 0.1);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        /* Default size for 1-2 logos */
        .logos[data-count="1"] .logo-image,
        .logos[data-count="2"] .logo-image {
            width: 60px;
            height: 60px;
        }

        /* Medium size for 3-4 logos */
        .logos[data-count="3"] .logo-image,
        .logos[data-count="4"] .logo-image {
            width: 50px;
            height: 50px;
        }

        /* Small size for 5-6 logos */
        .logos[data-count="5"] .logo-image,
        .logos[data-count="6"] .logo-image {
            width: 45px;
            height: 45px;
        }

        /* Extra small size for 7+ logos */
        .logos[data-count="7"] .logo-image,
        .logos[data-count="8"] .logo-image,
        .logos[data-count="9"] .logo-image,
        .logos[data-count="10"] .logo-image {
            width: 40px;
            height: 40px;
        }

        /* Very small for 10+ logos */
        .logos[data-count^="1"] .logo-image {
            width: 35px;
            height: 35px;
        }

        .logo-image img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            border-radius: 4px;
        }

        .logo-text {
            color: white;
            text-align: center;
            margin-left: 20px;
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
            color: #ecf0f1;
        }

        .footer-section p,
        .footer-section a {
            color: #bdc3c7;
            text-decoration: none;
            line-height: 1.6;
            font-size: 14px;
        }

        .footer-section a:hover {
            color: #5a9b9e;
            transition: color 0.3s ease;
        }

        .footer-section ul {
            list-style: none;
        }

        .footer-section ul li {
            margin-bottom: 8px;
        }

        .footer-bottom {
            border-top: 1px solid #34495e;
            padding-top: 20px;
            text-align: center;
        }

        .footer-bottom p {
            color: #95a5a6;
            font-size: 12px;
        }

        /* Responsive Design */
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
                gap: 15px;
                justify-content: center;
                /* Keep horizontal layout on mobile */
                flex-direction: row;
                flex-wrap: nowrap;
            }

            /* Adjust logo sizes for mobile */
            .logos[data-count="1"] .logo-image,
            .logos[data-count="2"] .logo-image {
                width: 50px;
                height: 50px;
            }

            .logos[data-count="3"] .logo-image,
            .logos[data-count="4"] .logo-image {
                width: 40px;
                height: 40px;
            }

            .logos[data-count="5"] .logo-image,
            .logos[data-count="6"] .logo-image,
            .logos[data-count="7"] .logo-image,
            .logos[data-count="8"] .logo-image,
            .logos[data-count="9"] .logo-image,
            .logos[data-count="10"] .logo-image {
                width: 35px;
                height: 35px;
            }

            .logos[data-count^="1"] .logo-image {
                width: 30px;
                height: 30px;
            }

            .program-badges {
                flex-wrap: wrap;
                justify-content: center;
            }

            .title-section h1 {
                font-size: 24px;
            }

            .title-section h2 {
                font-size: 20px;
            }

            .title-section h3 {
                font-size: 16px;
            }

            .title-section h4 {
                font-size: 16px;
            }

            .main-content {
                padding: 30px 20px;
            }

            .footer-content {
                padding: 0 20px;
            }

            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                @php
                    // Get all active logos from database
                    $activeLogos = \App\Models\Asset::getAllActiveLogos();
                @endphp
                
                <div class="logos" data-count="{{ $activeLogos->count() }}">
                    @if($activeLogos->count() > 0)
                        @foreach($activeLogos as $logo)
                        <div class="logo-item">
                            <div class="logo-image">
                                <img src="{{ $logo->file_url }}" alt="{{ $logo->original_name }}">
                            </div>
                        </div>
                        @endforeach
                    @else
                    {{-- Default logo if no asset found --}}
                    <div class="logo-item">
                        <div class="logo-image">
                            <i class="fas fa-building" style="font-size: 30px; color: rgba(255,255,255,0.5);"></i>
                        </div>
                    </div>
                    @endif
                </div>

                {{-- <div class="program-badges">
                    <div class="badge">SMART CITY</div>
                    <div class="badge">DIGITAL LAMONGAN</div>
                </div>

                <div class="logo-text">
                    <div class="main-text">DINAS KOMUNIKASI</div>
                    <div class="main-text">DAN INFORMATIKA</div>
                    <div class="sub-text">KABUPATEN LAMONGAN</div>
                </div> --}}
            </div>

            <div class="title-section">
                <h1>SURVEI KEPUASAN MASYARAKAT</h1>
                <h2>Dinas Komunikasi dan Informatika</h2>
                <h3>Kabupaten Lamongan</h3>
                <h4>TAHUN {{ date('Y') }}</h4>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>

        <footer class="footer">
            <div class="footer-content">
                <div class="footer-grid">
                    <div class="footer-section">
                        <h4>Dinas Komunikasi dan Informatika</h4>
                        <p>Kabupaten Lamongan</p>
                        <p>Jl. Basuki Rahmat No. 1, Lamongan</p>
                        <p>Jawa Timur 62211</p>
                        <p>WhatsApp : +628113021708</p>
                        <p>Email: diskominfo@lamongankab.go.id</p>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Layanan</h4>
                        <ul>
                            <li><a href="#">Website Resmi</a></li>
                            <li><a href="#">Portal Data</a></li>
                            <li><a href="#">Aplikasi Mobile</a></li>
                            <li><a href="#">Helpdesk</a></li>
                        </ul>
                    </div>
                    
                    <div class="footer-section">
                        <h4>Informasi</h4>
                        <ul>
                            <li><a href="#">Tentang Kami</a></li>
                            <li><a href="#">Kontak</a></li>
                            <li><a href="#">FAQ</a></li>
                            <li><a href="#">Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                </div>
                
                <div class="footer-bottom">
                    <p>&copy; {{ date('Y') }} Dinas Komunikasi dan Informatika Kabupaten Lamongan. Semua hak dilindungi.</p>
                </div>
            </div>
        </footer>
    </div>
    @stack('scripts')
</body>
</html>