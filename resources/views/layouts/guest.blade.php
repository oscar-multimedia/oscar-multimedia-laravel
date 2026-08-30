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
    {{-- Judul halaman bisa dibuat dinamis juga --}}
    <title>@yield('title', 'Oscar Multimedia')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet">

    <style>
        /* Kustomisasi Warna dan Style */
        html, body {
            height: 100%;
            margin: 0;
        }
        
        body {
            background-color: #ffffff; /* Warna latar belakang utama */
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }
        .bg-custom-header-footer {
            background-color: #e6b34b; /* Warna kuning/emas untuk header dan footer */
            color: #212529; /* Warna teks gelap agar kontras */
        }
        .placeholder-box {
            background-color: #d9d9d9; /* Warna abu-abu untuk placeholder */
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            color: #555;
            min-height: 150px; /* Tinggi minimum untuk semua box */
            width: 100%;
            border-radius: 0.25rem; /* Sedikit lengkungan di sudut */
        }
        .section-title {
            font-weight: bold;
            color: #333;
            margin-top: 4rem;
            margin-bottom: 2rem;
        }
        /* Menyesuaikan tinggi placeholder sesuai desain */
        .tall-placeholder { height: 420px; }
        .small-placeholder { height: 200px; }
        .large-placeholder { height: 350px; }
    </style>
</head>
<body>
    {{-- Bagian Header yang akan selalu tampil --}}
    @include('layouts.header')

    <main class="container-fluid px-4 my-5">

        {{-- INI ADALAH BAGIAN KONTEN YANG AKAN DIISI OLEH HALAMAN LAIN --}}
        @yield('content')

    </main>

    {{-- Bagian Footer yang akan selalu tampil --}}
    @include('layouts.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>