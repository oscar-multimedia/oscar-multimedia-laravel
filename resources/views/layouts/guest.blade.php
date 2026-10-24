<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Oscar Multimedia - Solusi percetakan digital printing, sablon, merchandise, desain grafis, dan servis komputer terpercaya.">

    {{-- Preconnect & DNS-Prefetch untuk CDN eksternal --}}
    <link rel="preconnect" href="https://res.cloudinary.com">
    <link rel="dns-prefetch" href="https://res.cloudinary.com">
    <link rel="preconnect" href="https://cdn.jsdelivr.net" crossorigin>
    <link rel="dns-prefetch" href="https://cdn.jsdelivr.net">

    {{-- Stack untuk Preload Gambar LCP dari Halaman Spesifik --}}
    @stack('preload')

    @if(!empty($profileData) && !empty($profileData->logo))
        <link rel="icon" href="{{ cloudinary_url($profileData->logo, 'f_auto,q_auto,w_64') }}">
    @else
        <link rel="icon" href="{{ asset('logo_oscar_old.ico') }}">
    @endif
    {{-- Judul halaman bisa dibuat dinamis --}}
    <title>@yield('title', 'Oscar Multimedia')</title>

    {{-- CSS Framework --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></noscript>

    <style>
        /* CSS Root & Responsive Layout Spacing */
        :root {
            --navbar-offset: 65px;
        }

        @media (max-width: 767.98px) {
            :root {
                --navbar-offset: 95px;
            }
        }

        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            background-color: #ffffff;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .main-content-wrapper {
            flex: 1 0 auto;
            padding-top: var(--navbar-offset);
            width: 100%;
        }

        .bg-custom-header-footer {
            background-color: #e6b34b;
            color: #212529;
        }

        .section-title {
            font-weight: bold;
            color: #333;
            margin-top: 3rem;
            margin-bottom: 2rem;
        }

        @media (max-width: 767.98px) {
            .section-title {
                margin-top: 2rem;
                margin-bottom: 1.5rem;
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    {{-- Bagian Header yang akan selalu tampil --}}
    @include('layouts.header')

    <main class="main-content-wrapper container-fluid px-3 px-md-4 mb-4">
        {{-- BAGIAN KONTEN HALAMAN --}}
        @yield('content')
    </main>

    {{-- Bagian Footer yang akan selalu tampil --}}
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" defer></script>
</body>
</html>