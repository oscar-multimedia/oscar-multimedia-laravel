<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Oscar Multimedia | @yield('title', 'Home')</title>
    @php $profileData = \App\Models\Profile::first(); @endphp
    @if($profileData && $profileData->logo)
        <link rel="icon" href="{{ cloudinary_url($profileData->logo) }}">
    @else
        <link rel="icon" href="{{ asset('logo_oscar_old.ico') }}">
    @endif
    <meta name="viewport" content="width=device-width, initial-scale=1">

    {{-- Bootstrap CSS --}}
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/css/splide.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        body { 
            overflow-x: hidden; 
            background-color: #f8f9fa; 
        }
        
        .sidebar {
            min-height: 100vh;
            width: 240px;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 100;
            transition: all 0.3s ease;
            box-shadow: 0 0 15px rgba(0,0,0,0.1);
            background-color: #f8f9fa;
        }
        .sidebar.collapsed {
            width: 72px;
        }
        
        .main-content {
            margin-left: 240px;
            transition: margin-left 0.3s ease;
        }
        
        .main-content.full {
            margin-left: 72px;
        }
        
        .logo-img {
            width: 100%;
            max-width: 160px;
            height: auto;
            transition: max-width 0.3s ease;
        }
        
        .sidebar.collapsed .logo-img {
            max-width: 48px;
        }
        
        .sidebar-link-inner {
            display: flex;
            align-items: center;
            gap: 16px;
            justify-content: flex-start;
        }
        
        .sidebar.collapsed .sidebar-text {
            display: none;
        }
        
        .sidebar-toggle { 
            background: none; 
            border: none; 
            font-size: 1.2rem; 
            color: #000; 
        }
        
        .sidebar a.active {
            background-color: rgba(0, 0, 0, 0.08);
            font-weight: 500;
        }
        
        .topbar { 
            background-color: #fff; 
            padding: 10px 20px; 
            border-bottom: 1px solid #dee2e6; 
        }
        
        .logout-link:hover .sidebar-text, 
        .logout-link:hover i {
            color: #dc3545!important;
        }
        
        /* Overlay untuk mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: rgba(0, 0, 0, 0.5);
            z-index: 99;
        }
        
        /* Media query untuk mobile */
        @media (max-width: 992px) {
            .sidebar {
                left: -240px; /* Sembunyikan sidebar di luar layar */
                width: 240px;
            }
            
            .sidebar.collapsed {
                left: -240px;
                width: 240px;
            }
            
            .sidebar.show {
                left: 0; /* Tampilkan sidebar */
            }
            
            .main-content {
                margin-left: 0; /* Hapus margin di mobile */
            }
            
            .main-content.full {
                margin-left: 0;
            }
            
            .sidebar-overlay.show {
                display: block;
            }
        }
    </style>
</head>
<body>

    {{-- Sidebar --}}
    @include('layouts.partials.sidebar')

    {{-- Main --}}
    <div class="main-content" id="mainContent">
        {{-- Topbar --}}
        @include('layouts.partials.topbar')

        {{-- Page Content --}}
        <div class="container-fluid mt-4">
            <div class="card shadow-sm border-0 rounded-3">
                <div class="card-body p-4">
                    @yield('content')
                </div>
            </div>
        </div>
    </div>

    {{-- Bootstrap JS --}}
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@splidejs/splide@4.1.4/dist/js/splide.min.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebarOverlay = document.getElementById('sidebarOverlay');

            function isMobile() {
                return window.innerWidth <= 992;
            }

            function toggleSidebar() {
                if (isMobile()) {
                    // Logic untuk mobile
                    sidebar.classList.toggle('show');
                    sidebarOverlay.classList.toggle('show');
                } else {
                    // Logic untuk desktop
                    sidebar.classList.toggle('collapsed');
                    mainContent.classList.toggle('full');
                }
            }
            
            function closeSidebar() {
                if (isMobile()) {
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            }

            function isSidebarOpen() {
                return sidebar.classList.contains('show');
            }

            // Event listeners
            if (sidebarToggle) {
                sidebarToggle.addEventListener('click', function(e) {
                    e.stopPropagation(); // Prevent event bubbling
                    toggleSidebar();
                });
            }

            if (sidebarOverlay) {
                sidebarOverlay.addEventListener('click', closeSidebar);
            }

            // Tutup sidebar saat klik di main content (mobile only)
            if (mainContent) {
                mainContent.addEventListener('click', function() {
                    if (isMobile() && isSidebarOpen()) {
                        closeSidebar();
                    }
                });
            }

            // Tutup sidebar saat klik di mana saja di document (mobile only)
            document.addEventListener('click', function(e) {
                if (isMobile() && isSidebarOpen()) {
                    // Cek apakah yang diklik bukan bagian dari sidebar atau tombol toggle
                    if (!sidebar.contains(e.target) && !sidebarToggle.contains(e.target)) {
                        closeSidebar();
                    }
                }
            });

            // Prevent sidebar dari menutup saat klik di dalam sidebar
            sidebar.addEventListener('click', function(e) {
                e.stopPropagation();
            });

            function handleResize() {
                if (isMobile()) {
                    // Mode mobile: sembunyikan sidebar dan hapus class collapsed
                    sidebar.classList.remove('collapsed', 'show');
                    mainContent.classList.remove('full');
                    sidebarOverlay.classList.remove('show');
                } else {
                    // Mode desktop: tampilkan sidebar normal
                    sidebar.classList.remove('show');
                    sidebarOverlay.classList.remove('show');
                }
            }

            // Jalankan saat load dan resize
            handleResize();
            window.addEventListener('resize', handleResize);

            // Tutup sidebar saat klik link di mobile
            const sidebarLinks = sidebar.querySelectorAll('.sidebar-link');
            sidebarLinks.forEach(link => {
                link.addEventListener('click', () => {
                    if (isMobile()) {
                        closeSidebar();
                    }
                });
            });

            // Tutup sidebar dengan tombol ESC
            document.addEventListener('keydown', function(e) {
                if (e.key === 'Escape' && isMobile() && isSidebarOpen()) {
                    closeSidebar();
                }
            });
        });

        @if (session('success'))
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: '{{ session('success') }}',
                showConfirmButton: false,
                timer: 2500
            });
        @endif

        @if (session('error'))
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: '{{ session('error') }}',
                showConfirmButton: false,
                timer: 2500
            });
        @endif
    </script>
</body>
</html>