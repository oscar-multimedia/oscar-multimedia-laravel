<style>
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        width: 100%;
        max-width: 100%;
    }

    .marquee-text {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 16s linear infinite;
        font-size: 0.95rem;
        font-weight: 600;
    }

    @keyframes marquee {
        0% {
            transform: translateX(0%);
        }
        100% {
            transform: translateX(-100%);
        }
    }

    .navbar-custom {
        position: fixed;
        top: 0;
        left: 0;
        right: 0;
        padding-top: 0.5rem;
        padding-bottom: 0.5rem;
        z-index: 1040;
    }

    .nav-link-custom {
        font-size: 0.95rem;
        font-weight: 500;
        padding: 0.3rem 0.8rem;
        border-radius: 20px;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        display: inline-flex;
        align-items: center;
        text-decoration: none;
        color: #212529 !important;
    }

    .nav-link-custom:hover {
        background-color: rgba(0, 0, 0, 0.08);
        color: #000000 !important;
        transform: translateY(-1px);
    }

    /* Active pill indicator: clear / semi-translucent tint matching the hover style */
    .nav-link-custom.active {
        background-color: rgba(0, 0, 0, 0.14);
        color: #000000 !important;
        font-weight: 700;
    }

    .nav-link-custom.active:hover {
        background-color: rgba(0, 0, 0, 0.18);
        color: #000000 !important;
        transform: translateY(-1px);
    }

    .nav-icon {
        width: 1.15em;
        height: 1.15em;
        vertical-align: -0.15em;
    }

    @media (min-width: 768px) {
        .navbar-custom {
            padding-top: 0.75rem;
            padding-bottom: 0.75rem;
        }

        .marquee-container {
            width: auto;
            flex: 1;
            margin-right: 2rem;
        }

        .marquee-text {
            font-size: 1.1rem;
        }

        .nav-link-custom {
            font-size: 1rem;
            padding: 0.35rem 0.95rem;
        }
    }
</style>

<nav class="navbar fixed-top shadow-sm navbar-custom" style="background-color: #E8B535;" id="topHeaderNavbar">
    <div class="container-fluid d-flex flex-column flex-md-row justify-content-between align-items-center px-3 px-md-4">
        
        <!-- Marquee Teks Selamat Datang -->
        <div class="marquee-container text-dark fw-semibold mb-2 mb-md-0">
            <div class="marquee-text">
                Selamat Datang di <strong>Oscar Multimedia</strong> Ungaran, mau cetak apa saja bisa
            </div>
        </div>

        <!-- Menu Link dengan Clear Active Pill Indicator -->
        <div class="d-flex align-items-center justify-content-center gap-2 gap-md-3 flex-wrap">
            <!-- Link Home -->
            <a class="text-dark d-inline-flex align-items-center text-decoration-none nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" title="Beranda">
                <svg class="nav-icon" stroke="currentColor" fill="currentColor" stroke-width="0"
                    viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path>
                </svg>
            </a>
            <a class="text-dark text-decoration-none nav-link-custom {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profile</a>
            <a class="text-dark text-decoration-none nav-link-custom {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Alamat & Kontak</a>
        </div>
    </div>
</nav>