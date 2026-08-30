{{-- Memberi tahu Laravel untuk menggunakan layout 'guest' --}}
@extends('layouts.guest')

{{-- (Opsional) Mengisi judul halaman spesifik --}}
@section('title', 'Oscar Multimedia - Produk')

{{-- Mengisi bagian 'content' --}}
@section('content')
<style>
    /* Atur jarak atas untuk konten yang berada di bawah topbar fixed */
    .content-top-padding {
        margin-top: 90px;
    }
    @media (min-width: 768px) {
        .content-top-padding {
            margin-top: 50px;
        }
    }

    @media (min-width: 768px) and (max-width: 991.98px) {
        .navbar-custom > .container-fluid {
            justify-content: center !important;
        }
        .navbar-custom .d-flex.align-items-center.gap-4 {
            margin-top: 0 !important;
        }
    }

    .card .overlay {
        position: absolute;
        inset: 0;
        background: rgba(0, 0, 0, 0.4);
        opacity: 0;
        transition: opacity 0.3s ease;
    }
    .card:hover .overlay {
        opacity: 1;
    }
</style>

<div class="container content-top-padding">
    <div class="text-center mb-5">
        <h1>Katalog Produk Kami</h1>
        <p class="lead text-muted">Temukan produk terbaik yang sesuai dengan kebutuhan Anda.</p>
    </div>
    <div class="row">
        {{-- Sidebar Filter --}}
        <div class="col-lg-3">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-white">
                    <h5 class="mb-0">Filter</h5>
                </div>
                <div class="card-body">
                    <form method="GET" action="{{ route('produk') }}">
                        <div class="mb-3">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari produk..." 
                                   value="{{ request('search') }}">
                        </div>
                        
                        <h6>Kategori</h6>
                        @foreach($kategoris as $kat)
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="kategori" 
                                       value="{{ $kat->id }}" id="kategori-{{ $kat->id }}"
                                       {{ request('kategori') == $kat->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="kategori-{{ $kat->id }}">
                                    {{ $kat->nama_kategori }}
                                </label>
                            </div>
                        @endforeach

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn mt-2" 
                                    style="background-color: #e8b535; color: #fff;">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('produk') }}" class="btn btn-outline-secondary">Reset</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Produk Grid --}}
        <div class="col-lg-9">
            <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
                @forelse($produks as $produk)
                    <div class="col">
                        <div class="card h-100 border-0 shadow-sm overflow-hidden">
                            {{-- Gambar dengan overlay hover --}}
                            <div class="position-relative">
                                <img src="{{ $produk->foto ? cloudinary_url($produk->foto) : asset('images/default.png') }}" 
                                     class="card-img-top" 
                                     alt="{{ $produk->nama_produk }}" 
                                     style="height: 220px; object-fit: cover;">
                                
                                {{-- Overlay tombol detail --}}
                                <div class="overlay d-flex justify-content-center align-items-center">
                                    <a href="{{ route('detail', $produk->id) }}" 
                                       class="btn btn-warning rounded-pill text-white fw-bold px-4">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            {{-- Info Produk --}}
                            <div class="card-body text-center">
                                <h5 class="card-title fw-bold">{{ $produk->nama_produk }}</h5>
                                <p class="text-muted small mb-1">{{ $produk->kategori->nama_kategori ?? '-' }}</p>
                                @if (($produk->kategori->nama_kategori ?? '') != "Desain Logo")
                                    @if (($produk->harga) != 0)
                                    <p class="fw-bold fs-5 text-danger mb-0">
                                        Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                    </p>
                                    @endif
                                @endif
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="col-12">
                        <div class="alert alert-warning text-center">
                            Produk yang Anda cari tidak ditemukan.
                        </div>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
