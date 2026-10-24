<nav class="navbar navbar-expand-lg bg-white border rounded-3 shadow-sm py-2 py-md-3 main-navbar">
    <div class="container-fluid d-flex align-items-center px-3 px-md-4">
        {{-- Logo (Sejajar tengah vertikal) --}}
        <a class="navbar-brand d-flex align-items-center py-0 me-2 me-lg-3" href="{{ url('/') }}">
            @php $profileData = \App\Models\Profile::first(); @endphp
            @if($profileData && $profileData->logo)
                <img src="{{ cloudinary_url($profileData->logo) }}" alt="Oscar Multimedia" class="brand-logo img-fluid">
            @else
                <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="brand-logo img-fluid">
            @endif
        </a>

        {{-- Tombol Toggler untuk Mobile --}}
        <button class="navbar-toggler border-0 shadow-none p-1 ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#storefrontNavbar" aria-controls="storefrontNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Konten Navbar (Sejajar tengah vertikal dengan logo & kategori) --}}
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="storefrontNavbar">
            {{-- Form Search: Memanjang proporsional mengisi ruang tengah & sejajar presisi --}}
            <div class="search-wrapper flex-grow-1 px-lg-4 my-2 my-lg-0">
                <form class="d-flex w-100 m-0" action="{{ route('produk') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0 ps-3 pe-2 py-2" id="search-icon">
                            <i class="bi bi-search text-muted"></i>
                        </span>
                        <input class="form-control border-start-0 ps-2 py-2" type="search" name="search" placeholder="Mau cari produk apa hari ini?" aria-label="Search" value="{{ request('search') }}" required>
                        <button class="btn btn-warning fw-semibold px-4" type="submit" style="background-color: #e8b535; border-color: #e8b535;">
                            Cari
                        </button>
                    </div>
                </form>
            </div>

            {{-- Kategori Dropdown di Kanan (Sejajar tengah vertikal) --}}
            <ul class="navbar-nav ms-auto align-items-center mb-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold text-dark py-2 d-flex align-items-center" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid me-2 text-secondary"></i> Kategori Produk
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0 mt-2">
                        @if(isset($kategoris) && count($kategoris) > 0)
                            @foreach($kategoris as $kat)
                            <li><a class="dropdown-item py-2" href="{{ route('produk', ['kategori' => $kat->id]) }}">{{ $kat->nama_kategori }}</a></li>
                            @endforeach
                        @else
                            <li><span class="dropdown-item text-muted">Belum ada kategori</span></li>
                        @endif
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>

<style>
.main-navbar {
    margin-top: 0.5rem;
    margin-bottom: 1.5rem;
}

.brand-logo {
    height: 48px;
    object-fit: contain;
}

@media (min-width: 768px) {
    .main-navbar {
        margin-top: 0.75rem;
        margin-bottom: 2rem;
    }

    .brand-logo {
        height: 56px;
    }
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
}

.search-wrapper .form-control:focus {
    box-shadow: none;
    border-color: #dee2e6;
}
</style>