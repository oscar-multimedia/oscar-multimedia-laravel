<nav class="navbar navbar-expand-lg bg-white border rounded-3 shadow-sm py-2 py-md-3 main-navbar">
    <div class="container-fluid px-3 px-md-4">
        
        {{-- ==================== LAYOUT DESKTOP (Layar >= 992px): 1 Baris Sejajar Penuh ==================== --}}
        <div class="d-none d-lg-flex align-items-center justify-content-between w-100">
            {{-- 1. Logo di Kiri --}}
            <a class="navbar-brand d-flex align-items-center py-0 me-3 brand-logo-link flex-shrink-0" href="{{ url('/') }}">
                @if(!empty($profileData) && !empty($profileData->logo))
                    <img src="{{ cloudinary_url($profileData->logo, 'f_auto,q_auto,h_96,c_limit') }}" alt="Oscar Multimedia" class="brand-logo img-fluid" width="180" height="48">
                @else
                    <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="brand-logo img-fluid" width="180" height="48">
                @endif
            </a>

            {{-- 2. Form Search di Tengah (Memanjang Proporsional) --}}
            <div class="search-wrapper flex-grow-1 px-4 my-0">
                <form class="d-flex w-100 m-0" action="{{ route('produk') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 ps-3 pe-2 py-2" id="search-icon-desktop">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input class="form-control border-start-0 ps-2 py-2" type="search" name="search" placeholder="Mau cari produk apa hari ini?" aria-label="Search" value="{{ request('search') }}" required>
                        <button class="btn btn-search fw-semibold px-4" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- 3. Kategori Dropdown di Kanan --}}
            <div class="flex-shrink-0">
                <div class="dropdown">
                    <a class="nav-link dropdown-toggle btn-kategori fw-semibold text-dark py-2 px-3 d-flex align-items-center rounded-3" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid me-2 text-secondary"></i> Kategori Produk
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2 p-1">
                        @if(isset($kategoris) && count($kategoris) > 0)
                            @foreach($kategoris as $kat)
                            <li><a class="dropdown-item py-2 px-3" href="{{ route('produk', ['kategori' => $kat->id]) }}">{{ $kat->nama_kategori }}</a></li>
                            @endforeach
                        @else
                            <li><span class="dropdown-item text-muted">Belum ada kategori</span></li>
                        @endif
                    </ul>
                </div>
            </div>
        </div>

        {{-- ==================== LAYOUT MOBILE (Layar < 992px): 2 Baris Terstruktur ==================== --}}
        <div class="d-flex d-lg-none flex-column w-100 gap-3">
            {{-- Baris 1: Logo di Kiri, Tombol Menu di Kanan --}}
            <div class="d-flex align-items-center justify-content-between w-100">
                <a class="navbar-brand d-flex align-items-center py-0 brand-logo-link" href="{{ url('/') }}">
                    @if(!empty($profileData) && !empty($profileData->logo))
                        <img src="{{ cloudinary_url($profileData->logo, 'f_auto,q_auto,h_96,c_limit') }}" alt="Oscar Multimedia" class="brand-logo img-fluid" width="140" height="38">
                    @else
                        <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="brand-logo img-fluid" width="140" height="38">
                    @endif
                </a>

                {{-- Tombol Menu (Buka Offcanvas Drawer Berisi Navigasi & Kategori Lengkap) --}}
                <button class="btn btn-menu-mobile d-flex align-items-center justify-content-center rounded-circle border-0 shadow-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#mobileNavDrawer" aria-controls="mobileNavDrawer" aria-label="Buka Menu">
                    <i class="bi bi-list fs-5 text-dark"></i>
                </button>
            </div>

            {{-- Baris 2: Search Form Berdiri Sendiri 100% Full Width --}}
            <div class="search-wrapper w-100">
                <form class="d-flex w-100 m-0" action="{{ route('produk') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 ps-3 pe-2 py-2" id="search-icon-mobile">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input class="form-control border-start-0 ps-2 py-2" type="search" name="search" placeholder="Mau cari produk apa hari ini?" aria-label="Search" value="{{ request('search') }}" required>
                        <button class="btn btn-search fw-semibold px-3" type="submit">
                            Cari
                        </button>
                    </div>
                </form>
            </div>
        </div>

    </div>
</nav>

<style>
.main-navbar {
    margin-top: 0.5rem;
    margin-bottom: 1.5rem;
}

.brand-logo-link {
    transition: opacity 0.2s ease, transform 0.2s ease;
}

.brand-logo-link:hover {
    opacity: 0.9;
    transform: scale(1.02);
}

.brand-logo {
    height: 40px;
    object-fit: contain;
}

@media (min-width: 768px) {
    .main-navbar {
        margin-top: 0.75rem;
        margin-bottom: 2rem;
    }

    .brand-logo {
        height: 52px;
    }
}

/* Mobile Actions Styling */
.btn-menu-mobile {
    width: 36px;
    height: 36px;
    background-color: #E8B535;
    transition: transform 0.2s ease, background-color 0.2s ease;
    cursor: pointer;
}
.btn-menu-mobile:hover, .btn-menu-mobile:active {
    background-color: #d89f21;
    transform: scale(1.05);
}

/* Pastikan semua elemen sejajar vertikal di tengah */
.main-navbar .navbar-brand,
.main-navbar .search-wrapper,
.main-navbar .navbar-nav {
    display: flex;
    align-items: center;
}

.search-wrapper .input-group {
    border-radius: 8px;
    overflow: hidden;
    transition: box-shadow 0.25s ease, border-color 0.25s ease;
}

.search-wrapper .input-group:focus-within {
    box-shadow: 0 0 0 3px rgba(232, 181, 53, 0.25);
}

.search-wrapper .form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}

/* Button Cari Hover Effect */
.btn-search {
    background-color: #e8b535;
    border: 1px solid #e8b535;
    color: #1a1a1a;
    transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    position: relative;
    cursor: pointer;
}

.btn-search:hover {
    background-color: #d89f21;
    border-color: #d89f21;
    color: #000;
    box-shadow: 0 4px 14px rgba(232, 181, 53, 0.4);
    transform: translateY(-1px);
}

.btn-search:active {
    transform: translateY(0);
    box-shadow: 0 2px 6px rgba(232, 181, 53, 0.3);
}

/* Button Kategori Dropdown Hover Effect */
.btn-kategori {
    transition: all 0.2s ease;
    border: 1px solid transparent;
}

.btn-kategori:hover,
.btn-kategori:focus,
.nav-item.dropdown.show .btn-kategori {
    background-color: #f8f9fa;
    color: #c99318 !important;
    border-color: #e9ecef;
    transform: translateY(-1px);
}

/* Dropdown Menu Item Hover */
.dropdown-menu .dropdown-item {
    transition: all 0.15s ease;
    border-radius: 6px;
    margin: 2px 0;
}

.dropdown-menu .dropdown-item:hover {
    background-color: #fff9e6;
    color: #9c710d;
    transform: translateX(4px);
}
</style>