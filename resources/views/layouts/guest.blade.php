<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @php $profileData = \App\Models\Profile::first(); @endphp
    @if($profileData && $profileData->logo)
        <link rel="icon" href="{{ cloudinary_url($profileData->logo) }}">
    @else
        <link rel="icon" href="{{ asset('logo_oscar_old.ico') }}">
    @endif
    {{-- Judul halaman bisa dibuat dinamis --}}
    <title>@yield('title', 'Oscar Multimedia')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>