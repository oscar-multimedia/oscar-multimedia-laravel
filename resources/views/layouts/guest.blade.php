<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Oscar Multimedia - Solusi percetakan digital printing, sablon, merchandise, desain grafis, dan servis komputer terpercaya.">

    {{-- Preconnect & DNS-Prefetch untuk CDN eksternal (Cloudinary) --}}
    <link rel="preconnect" href="https://res.cloudinary.com">
    <link rel="dns-prefetch" href="https://res.cloudinary.com">

    {{-- Stack untuk Preload Gambar LCP dari Halaman Spesifik --}}
    @stack('preload')

    @if(!empty($profileData) && !empty($profileData->logo))
        <link rel="icon" href="{{ cloudinary_url($profileData->logo, 'f_auto,q_auto,w_64') }}">
    @else
        <link rel="icon" href="{{ asset('logo_oscar_old.ico') }}">
    @endif
    {{-- Judul halaman bisa dibuat dinamis --}}
    <title>@yield('title', 'Oscar Multimedia')</title>

    {{-- CSS Framework: Bootstrap 5 (Lokal / Self-hosted, Synchronous to eliminate CLS) --}}
    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">

    {{-- Bootstrap Icons (Lokal / Self-hosted w/ font-display: swap) --}}
    <link rel="preload" href="{{ asset('fonts/bootstrap-icons.woff2') }}" as="font" type="font/woff2" crossorigin>
    <link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}" media="print" onload="this.media='all'">
    <noscript><link rel="stylesheet" href="{{ asset('css/bootstrap-icons.min.css') }}"></noscript>

    <style>
        /* Header navigation fixed position guarantee to eliminate CLS */
        .navbar-custom {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1040;
        }

        /* CSS Root & Responsive Layout Spacing */
        :root {
            --navbar-offset: 65px;
        }

        @media (max-width: 767.98px) {
            :root {
                --navbar-offset: 48px;
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

    <script src="{{ asset('js/bootstrap.bundle.min.js') }}" defer></script>
    @stack('scripts')
</body>
</html>