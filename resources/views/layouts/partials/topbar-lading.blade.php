<nav class="navbar navbar-expand-lg bg-white border rounded-3 shadow-sm py-2 py-md-3 main-navbar">
    <div class="container-fluid px-3 px-md-4">
        {{-- Logo --}}
        <a class="navbar-brand py-0 me-3" href="{{ url('/') }}">
            @php $profileData = \App\Models\Profile::first(); @endphp
            @if($profileData && $profileData->logo)
                <img src="{{ cloudinary_url($profileData->logo) }}" alt="Oscar Multimedia" class="brand-logo img-fluid">
            @else
                <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="brand-logo img-fluid">
            @endif
        </a>

        {{-- Tombol Toggler untuk Mobile --}}
        <button class="navbar-toggler border-0 shadow-none p-1" type="button" data-bs-toggle="collapse" data-bs-target="#storefrontNavbar" aria-controls="storefrontNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Konten Navbar --}}
        <div class="collapse navbar-collapse mt-3 mt-lg-0" id="storefrontNavbar">
            {{-- Search Bar di Tengah --}}
            <div class="mx-auto w-100 my-2 my-lg-0" style="max-width: 800px;">
                <form class="d-flex" action="{{ route('produk') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" id="search-icon"><i class="bi bi-search text-muted"></i></span>
                        <input class="form-control border-start-0 ps-0" type="search" name="search" placeholder="Mau cari produk apa hari ini?" aria-label="Search" value="{{ request('search') }}" required>
                        <button class="btn btn-warning fw-semibold px-3" type="submit" style="background-color: #e8b535; border-color: #e8b535;">Cari</button>
                    </div>
                </form>
            </div>

            {{-- Kategori Dropdown di Kanan --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold text-dark" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-grid me-1"></i> Kategori Produk
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end shadow-sm border-0">
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
        height: 60px;
    }
}
</style>