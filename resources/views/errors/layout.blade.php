<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>@yield('title') | TanjungKatalog</title>
    <link rel="icon" href="{{ asset('favicon.ico') }}">
    <style>
        *, *::before, *::after { box-sizing: border-box; }
        body {
            margin: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            font-family: ui-sans-serif, system-ui, -apple-system, "Segoe UI", Roboto, sans-serif;
            color: #374151;
            background: linear-gradient(135deg, #F8FCFD 0%, #F5F2EB 55%, #CFE5E2 100%);
        }
        .card {
            width: 100%;
            max-width: 480px;
            padding: 40px 32px;
            text-align: center;
            background: #fff;
            border: 1px solid #CFE5E2;
            border-radius: 24px;
            box-shadow: 0 12px 40px rgba(50, 106, 171, 0.12);
        }
        .logo { width: 200px; max-width: 70%; height: auto; }
        .code {
            margin: 28px 0 0;
            font-size: 64px;
            font-weight: 800;
            line-height: 1;
            letter-spacing: -0.03em;
            color: #326AAB;
        }
        h1 { margin: 12px 0 0; font-size: 22px; color: #174875; }
        p { margin: 12px 0 0; font-size: 15px; line-height: 1.6; color: #6B7280; }
        .actions { margin-top: 28px; display: flex; flex-wrap: wrap; gap: 12px; justify-content: center; }
        a.btn {
            display: inline-block;
            padding: 12px 22px;
            border-radius: 999px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            color: #fff;
            background: #326AAB;
        }
        a.btn:hover { background: #28598f; }
        a.btn.secondary { color: #326AAB; background: #fff; border: 1px solid #326AAB; }
    </style>
</head>
<body>
    <main class="card">
        <img class="logo" src="{{ asset('images/tanjungkatalog-logo.png') }}" alt="TanjungKatalog">

        <p class="code">@yield('code')</p>

        <h1>@yield('heading')</h1>

        <p>@yield('message')</p>

        <div class="actions">
            <a class="btn" href="{{ url('/') }}">Ke Beranda</a>
            @hasSection('show_catalog_link')
                <a class="btn secondary" href="{{ url('/produk') }}">Lihat Katalog</a>
            @endif
        </div>
    </main>
</body>
</html>
