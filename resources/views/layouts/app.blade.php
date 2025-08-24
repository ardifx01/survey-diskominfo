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
        }

        .container {
            width: 100%;
            margin: 0;
            background: white;
            min-height: 100vh;
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
            gap: 10px;
        }

        .logo-placeholder {
            width: 60px;
            height: 60px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 24px;
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
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="header-content">
                <div class="logos">
                    <div class="logo-item">
                        <div class="logo-placeholder">LOGO</div>
                        <div>
                            <div style="font-size: 12px; opacity: 0.9;">JAWA TIMUR</div>
                            <div style="font-weight: 600;">GERBANG BARU</div>
                            <div style="font-size: 12px; opacity: 0.9;">NUSANTARA</div>
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
                <h2>Survei Kepuasan Masyarakat Pada</h2>
                <h3>Dinas Komunikasi dan Informatika</h3>
                <h4>KABUPATEN LAMONGAN</h4>
            </div>
        </div>

        <div class="main-content">
            @yield('content')
        </div>
    </div>

    @stack('scripts')
</body>
</html>