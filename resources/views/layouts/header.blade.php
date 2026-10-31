<style>
    .marquee-container {
        overflow: hidden;
        white-space: nowrap;
        flex: 1 1 auto;
        min-width: 0;
    }

    .marquee-text {
        display: inline-block;
        padding-left: 100%;
        animation: marquee 16s linear infinite;
        font-size: 0.84rem;
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
        padding-top: 0.3rem;
        padding-bottom: 0.3rem;
        z-index: 1040;
        min-height: 34px;
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

    /* Active pill indicator */
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
            min-height: 65px;
        }

        .marquee-container {
            width: auto;
            flex: 1;
            margin-right: 2rem;
        }

        .marquee-text {
            font-size: 1.05rem;
        }

        .nav-link-custom {
            font-size: 1rem;
            padding: 0.35rem 0.95rem;
        }
    }

    /* ==================== Modern Offcanvas Drawer Styling ==================== */
    #mobileNavDrawer {
        width: 86vw;
        max-width: 340px;
        border-top-left-radius: 20px;
        border-bottom-left-radius: 20px;
        border: none;
        box-shadow: -8px 0 35px rgba(0, 0, 0, 0.18);
        overflow: hidden;
    }

    .drawer-header-modern {
        background: #ffffff;
        border-bottom: 1px solid #f1f5f9;
        padding: 1rem 1.25rem;
    }

    .brand-drawer-logo {
        max-height: 38px;
        width: auto;
        object-fit: contain;
    }

    .btn-close-circle {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background-color: #f3f4f6;
        border: none;
        color: #4b5563;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.95rem;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 0;
        cursor: pointer;
    }

    .btn-close-circle:hover, .btn-close-circle:active {
        background-color: #e5e7eb;
        color: #111827;
        transform: rotate(90deg);
    }

    .drawer-store-chip {
        background: #f8fafc;
        border-bottom: 1px solid #f1f5f9;
        padding: 0.6rem 1.25rem;
        font-size: 0.76rem;
    }

    .drawer-section-title {
        font-size: 0.72rem;
        letter-spacing: 0.08em;
        font-weight: 700;
        color: #94a3b8;
        text-transform: uppercase;
        margin-bottom: 0.6rem;
        padding-left: 0.35rem;
    }

    /* Modern Navigation Cards */
    .drawer-nav-card {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.65rem 0.85rem;
        border-radius: 12px;
        text-decoration: none;
        color: #1e293b;
        margin-bottom: 0.35rem;
        transition: all 0.2s cubic-bezier(0.16, 1, 0.3, 1);
        background-color: transparent;
        border: 1px solid transparent;
    }

    .drawer-nav-card:hover {
        background-color: #f8fafc;
        color: #0f172a;
        transform: translateX(3px);
    }

    .drawer-nav-card.active {
        background: linear-gradient(135deg, rgba(232, 181, 53, 0.16) 0%, rgba(232, 181, 53, 0.04) 100%);
        border-color: rgba(232, 181, 53, 0.4);
        color: #854d0e;
        font-weight: 600;
    }

    .nav-squircle {
        width: 36px;
        height: 36px;
        border-radius: 10px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.05rem;
        flex-shrink: 0;
        background-color: #fffdf5;
        color: #b08010;
        border: 1px solid #fef08a;
        transition: all 0.2s ease;
    }

    .drawer-nav-card:hover .nav-squircle,
    .drawer-nav-card.active .nav-squircle {
        background-color: #e8b535;
        color: #1a1a1a;
        border-color: #e8b535;
        transform: scale(1.06);
    }

    .nav-card-title {
        font-size: 0.92rem;
        font-weight: 500;
        color: #1e293b;
        line-height: 1.25;
    }

    .drawer-nav-card.active .nav-card-title {
        color: #854d0e;
        font-weight: 600;
    }

    .nav-card-desc {
        font-size: 0.72rem;
        color: #94a3b8;
        line-height: 1.2;
    }

    .drawer-nav-card.active .nav-card-desc {
        color: #a16207;
    }

    .badge-active-dot {
        width: 7px;
        height: 7px;
        border-radius: 50%;
        background-color: #e8b535;
        box-shadow: 0 0 0 3px rgba(232, 181, 53, 0.3);
    }

    /* Category List Items */
    .drawer-category-item {
        display: flex;
        align-items: center;
        justify-content: space-between;
        padding: 0.6rem 0.85rem;
        border-radius: 10px;
        text-decoration: none;
        color: #334155;
        margin-bottom: 0.3rem;
        transition: all 0.2s ease;
        font-size: 0.88rem;
        background: #ffffff;
        border: 1px solid #f1f5f9;
    }

    .drawer-category-item:hover {
        background-color: #f8fafc;
        border-color: #e2e8f0;
        color: #0f172a;
        transform: translateX(3px);
    }

    .drawer-category-item.active {
        background: #fefce8;
        border-color: #fef08a;
        color: #854d0e;
        font-weight: 600;
    }

    .category-icon-bullet {
        width: 28px;
        height: 28px;
        border-radius: 8px;
        background: #fffdf5;
        color: #b08010;
        border: 1px solid #fef08a;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 0.82rem;
        flex-shrink: 0;
        transition: all 0.2s ease;
    }

    .drawer-category-item:hover .category-icon-bullet,
    .drawer-category-item.active .category-icon-bullet {
        background: #e8b535;
        color: #1a1a1a;
        border-color: #e8b535;
    }

    /* Drawer Footer Action */
    .drawer-footer-modern {
        background: #ffffff;
        border-top: 1px solid #f1f5f9;
        padding: 1.1rem 1.25rem;
    }

    .btn-drawer-cta {
        background: linear-gradient(135deg, #e8b535 0%, #f5cb4e 100%);
        color: #1a1a1a !important;
        border: none;
        font-size: 0.92rem;
        font-weight: 700;
        box-shadow: 0 4px 14px rgba(232, 181, 53, 0.35);
        transition: all 0.25s ease;
    }

    .btn-drawer-cta:hover {
        background: linear-gradient(135deg, #f5cb4e 0%, #d89f21 100%);
        box-shadow: 0 6px 18px rgba(232, 181, 53, 0.5);
        transform: translateY(-2px);
    }

    .drawer-scroll-area::-webkit-scrollbar {
        width: 4px;
    }
    .drawer-scroll-area::-webkit-scrollbar-thumb {
        background-color: #e2e8f0;
        border-radius: 4px;
    }
</style>

<nav class="navbar fixed-top shadow-sm navbar-custom" style="background-color: #E8B535;" id="topHeaderNavbar">
    <div class="container-fluid d-flex flex-nowrap justify-content-between align-items-center px-2 px-md-4">
        
        <!-- Marquee Teks Selamat Datang (Murni 1 Baris di Mobile) -->
        <div class="marquee-container text-dark fw-semibold">
            <div class="marquee-text">
                Selamat Datang di <strong>Oscar Multimedia</strong> Ungaran, mau cetak apa saja bisa
            </div>
        </div>

        <!-- Menu Link Desktop (Hanya Tampil di Layar Tablet & Desktop >= 768px) -->
        <div class="d-none d-md-flex align-items-center justify-content-end gap-2 gap-md-3 flex-shrink-0">
            <!-- Link Home -->
            <a class="text-dark d-inline-flex align-items-center text-decoration-none nav-link-custom {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}" title="Beranda">
                <svg class="nav-icon" stroke="currentColor" fill="currentColor" stroke-width="0"
                    viewBox="0 0 576 512" xmlns="http://www.w3.org/2000/svg">
                    <path d="M280.37 148.26L96 300.11V464a16 16 0 0 0 16 16l112.06-.29a16 16 0 0 0 15.92-16V368a16 16 0 0 1 16-16h64a16 16 0 0 1 16 16v95.64a16 16 0 0 0 16 16.05L464 480a16 16 0 0 0 16-16V300L295.67 148.26a12.19 12.19 0 0 0-15.3 0zM571.6 251.47L488 182.56V44.05a12 12 0 0 0-12-12h-56a12 12 0 0 0-12 12v72.61L318.47 43a48 48 0 0 0-61 0L4.34 251.47a12 12 0 0 0-1.6 16.9l25.5 31A12 12 0 0 0 45.15 301l235.22-193.74a12.19 12.19 0 0 1 15.3 0L530.9 301a12 12 0 0 0 16.9-1.6l25.5-31a12 12 0 0 0-1.7-16.93z"></path>
                </svg>
            </a>
            <a class="text-dark text-decoration-none nav-link-custom {{ request()->routeIs('produk') ? 'active' : '' }}" href="{{ route('produk') }}">Katalog Produk</a>
            <a class="text-dark text-decoration-none nav-link-custom {{ request()->routeIs('profile') ? 'active' : '' }}" href="{{ route('profile') }}">Profile</a>
            <a class="text-dark text-decoration-none nav-link-custom {{ request()->routeIs('kontak') ? 'active' : '' }}" href="{{ route('kontak') }}">Alamat & Kontak</a>
        </div>

        {{-- Trigger Menu Mobile (Pojok Kanan Header, Sejajar dengan Running Text) --}}
        @if(!request()->routeIs('home'))
        <div class="d-flex d-md-none align-items-center ms-2 flex-shrink-0">
            <button class="btn btn-sm text-dark p-1 border-0 d-flex align-items-center justify-content-center" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-controls="mobileNavDrawer" aria-label="Buka Menu" style="line-height: 1;">
                <i class="bi bi-list fs-4"></i>
            </button>
        </div>
        @endif

    </div>
</nav>

{{-- Offcanvas Drawer Navigasi Mobile (Tema Minimalis Kuning Emas & Putih) --}}
<div class="offcanvas offcanvas-end" tabindex="-1" id="mobileNavDrawer" aria-labelledby="mobileNavDrawerLabel">
    {{-- 1. Header Minimalis: Hanya Logo + Tombol Tutup Bulat Halus --}}
    <div class="offcanvas-header drawer-header-modern d-flex align-items-center justify-content-between">
        <a href="{{ url('/') }}" class="d-inline-flex align-items-center text-decoration-none">
            @if(!empty($profileData) && !empty($profileData->logo))
                <img src="{{ cloudinary_url($profileData->logo, 'f_auto,q_auto,h_80,c_limit') }}" alt="Oscar Multimedia" class="brand-drawer-logo">
            @else
                <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="brand-drawer-logo">
            @endif
        </a>
        <button type="button" class="btn-close-circle shadow-none" data-bs-dismiss="offcanvas" aria-label="Tutup Menu">
            <i class="bi bi-x-lg"></i>
        </button>
    </div>

    {{-- 2. Store Info Chip: Ungaran + Status Buka (Tema Kuning & Putih) --}}
    <div class="drawer-store-chip d-flex align-items-center justify-content-between">
        <span class="text-muted d-flex align-items-center gap-1">
            <i class="bi bi-geo-alt-fill text-warning"></i> Ungaran, Kab. Semarang
        </span>
        <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.68rem;">
            <i class="bi bi-circle-fill text-warning me-1" style="font-size: 0.45rem;"></i> Buka
        </span>
    </div>

    {{-- 3. Body: Navigasi Kartu & Kategori Berikon (Tema Kuning & Putih Konsisten) --}}
    <div class="offcanvas-body p-0 d-flex flex-column justify-content-between drawer-scroll-area">
        <div class="p-3">
            {{-- Bagian Navigasi Utama --}}
            <div class="drawer-section-title">NAVIGASI UTAMA</div>
            <div class="drawer-nav-list mb-3">
                {{-- Beranda --}}
                <a href="{{ route('home') }}" class="drawer-nav-card {{ request()->routeIs('home') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <span class="nav-squircle">
                            <i class="bi bi-house-door-fill"></i>
                        </span>
                        <div>
                            <div class="nav-card-title">Beranda</div>
                            <div class="nav-card-desc">Halaman utama percetakan</div>
                        </div>
                    </div>
                    @if(request()->routeIs('home'))
                        <span class="badge-active-dot"></span>
                    @else
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; opacity: 0.4;"></i>
                    @endif
                </a>

                {{-- Katalog Semua Produk --}}
                <a href="{{ route('produk') }}" class="drawer-nav-card {{ request()->routeIs('produk') && !request('kategori') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <span class="nav-squircle">
                            <i class="bi bi-grid-fill"></i>
                        </span>
                        <div>
                            <div class="nav-card-title">Katalog Produk</div>
                            <div class="nav-card-desc">Semua produk & jasa cetak</div>
                        </div>
                    </div>
                    @if(request()->routeIs('produk') && !request('kategori'))
                        <span class="badge-active-dot"></span>
                    @else
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; opacity: 0.4;"></i>
                    @endif
                </a>

                {{-- Profile Oscar Multimedia --}}
                <a href="{{ route('profile') }}" class="drawer-nav-card {{ request()->routeIs('profile') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <span class="nav-squircle">
                            <i class="bi bi-building-fill"></i>
                        </span>
                        <div>
                            <div class="nav-card-title">Profil Percetakan</div>
                            <div class="nav-card-desc">Tentang kami & legalitas</div>
                        </div>
                    </div>
                    @if(request()->routeIs('profile'))
                        <span class="badge-active-dot"></span>
                    @else
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; opacity: 0.4;"></i>
                    @endif
                </a>

                {{-- Alamat & Kontak --}}
                <a href="{{ route('kontak') }}" class="drawer-nav-card {{ request()->routeIs('kontak') ? 'active' : '' }}">
                    <div class="d-flex align-items-center gap-3">
                        <span class="nav-squircle">
                            <i class="bi bi-geo-alt-fill"></i>
                        </span>
                        <div>
                            <div class="nav-card-title">Alamat & Kontak</div>
                            <div class="nav-card-desc">Lokasi toko & CS WhatsApp</div>
                        </div>
                    </div>
                    @if(request()->routeIs('kontak'))
                        <span class="badge-active-dot"></span>
                    @else
                        <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; opacity: 0.4;"></i>
                    @endif
                </a>
            </div>

            {{-- Bagian Kategori Produk Berikon --}}
            @if(isset($kategoris) && count($kategoris) > 0)
                <div class="mt-4">
                    <div class="d-flex align-items-center justify-content-between mb-2 px-1">
                        <span class="drawer-section-title mb-0">KATEGORI PRODUK</span>
                        <span class="badge bg-warning-subtle text-dark rounded-pill border border-warning-subtle px-2 py-1" style="font-size: 0.68rem;">{{ count($kategoris) }} Pilihan</span>
                    </div>
                    <div class="drawer-category-list">
                        @foreach($kategoris as $kat)
                            @php
                                $catLower = strtolower($kat->nama_kategori);
                                $catIcon = 'bi-tag-fill';
                                if (str_contains($catLower, 'desain') || str_contains($catLower, 'logo') || str_contains($catLower, 'banner')) {
                                    $catIcon = 'bi-palette-fill';
                                } elseif (str_contains($catLower, 'print') || str_contains($catLower, 'cetak') || str_contains($catLower, 'digital')) {
                                    $catIcon = 'bi-printer-fill';
                                } elseif (str_contains($catLower, 'komputer') || str_contains($catLower, 'computer') || str_contains($catLower, 'aksesoris')) {
                                    $catIcon = 'bi-laptop-fill';
                                } elseif (str_contains($catLower, 'souvenir') || str_contains($catLower, 'merchandise') || str_contains($catLower, 'pin')) {
                                    $catIcon = 'bi-gift-fill';
                                }
                                $isCatActive = request('kategori') == $kat->id;
                            @endphp
                            <a href="{{ route('produk', ['kategori' => $kat->id]) }}" 
                               class="drawer-category-item {{ $isCatActive ? 'active' : '' }}">
                                <div class="d-flex align-items-center gap-2">
                                    <span class="category-icon-bullet">
                                        <i class="bi {{ $catIcon }}"></i>
                                    </span>
                                    <span class="category-name fw-medium">{{ $kat->nama_kategori }}</span>
                                </div>
                                <i class="bi bi-chevron-right text-muted" style="font-size: 0.75rem; opacity: 0.5;"></i>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>

        {{-- 4. Footer Drawer: Fast Track Konsultasi WhatsApp & Jam Kerja (Tema Kuning Emas & Putih) --}}
        <div class="drawer-footer-modern">
            <div class="d-flex align-items-center justify-content-between mb-2">
                <span class="small fw-bold text-dark">Konsultasi Percetakan</span>
                <span class="badge bg-warning-subtle text-dark border border-warning-subtle rounded-pill px-2 py-1" style="font-size: 0.68rem;">
                    Respon Cepat
                </span>
            </div>
            @php
                $drawerWaLink = !empty($kontakSite?->whatsapp_link) ? $kontakSite->whatsapp_link : route('kontak');
            @endphp
            <a href="{{ $drawerWaLink }}" target="_blank" rel="noopener noreferrer" class="btn btn-drawer-cta w-100 d-flex align-items-center justify-content-center gap-2 fw-semibold py-2 rounded-pill shadow-sm">
                <i class="bi bi-whatsapp fs-5"></i> Chat via WhatsApp
            </a>
        </div>
    </div>
</div>