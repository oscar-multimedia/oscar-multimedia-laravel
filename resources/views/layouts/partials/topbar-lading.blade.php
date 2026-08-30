<nav class="navbar navbar-expand-lg bg-white border-bottom py-3 main-navbar">
    <div class="container-fluid px-4">
        {{-- Logo --}}
        <a class="navbar-brand" href="{{ url('/') }}">
            @php $profileData = \App\Models\Profile::first(); @endphp
            @if($profileData && $profileData->logo)
                <img src="{{ cloudinary_url($profileData->logo) }}" alt="Oscar Multimedia" style="height: 70px; object-fit: contain;">
            @else
                <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" style="height: 70px;">
            @endif
        </a>

        {{-- Tombol Toggler untuk Mobile --}}
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#storefrontNavbar" aria-controls="storefrontNavbar" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        {{-- Konten Navbar --}}
        <div class="collapse navbar-collapse" id="storefrontNavbar">
            {{-- Search Bar di Tengah --}}
            <div class="mx-auto" style="width: 100%; max-width: 1100px;">
                <form class="d-flex" action="{{ route('produk') }}" method="GET" role="search">
                    <div class="input-group">
                        <span class="input-group-text bg-light border-end-0" id="search-icon"><i class="bi bi-search"></i></span>
                        
                        {{-- UBAH NAMA INPUT MENJADI "search" --}}
                        <input class="form-control border-start-0" type="search" name="search" placeholder="Mau cari apa?" aria-label="Search" required>
                    </div>
                </form>
            </div>

            {{-- Kategori Dropdown di Kanan --}}
            <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle fw-semibold" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Kategori Produk
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        @foreach($kategoris as $kat)
                        <li><a class="dropdown-item" href="#{{ Str::slug($kat->nama_kategori, '-') }}">{{ $kat->nama_kategori }}</a></li>
                        @endforeach
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</nav>
<style>
.main-navbar {
    /* Margin untuk tampilan mobile (lebar layar < 768px) */
    margin-top: 60px; 
}

/* Media query untuk tampilan tablet dan desktop (lebar layar >= 768px) */
@media (min-width: 768px) {
    .main-navbar {
        /* Margin untuk tampilan desktop */
        margin-top: 40px;
    }
}

@media (min-width: 768px) and (max-width: 991.98px) {

    /* 1. Ubah alignment container utama menjadi ke tengah */
    .navbar-custom > .container-fluid {
        justify-content: center !important; /* Paksa item di dalamnya ke tengah */
    }

    /* 2. Hapus margin atas pada grup menu yang tidak lagi diperlukan */
    .navbar-custom .d-flex.align-items-center.gap-4 {
        margin-top: 0 !important;
    }
}
</style>