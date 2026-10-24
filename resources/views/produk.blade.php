{{-- Memberi tahu Laravel untuk menggunakan layout 'guest' --}}
@extends('layouts.guest')

{{-- (Opsional) Mengisi judul halaman spesifik --}}
@section('title', 'Oscar Multimedia - Produk')

{{-- Mengisi bagian 'content' --}}
@section('content')
<style>
    .content-top-padding {
        margin-top: 1rem;
    }

    /* === Product Card Hover & Micro-Animations === */
    .product-card {
        border-radius: 12px;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .product-card:hover {
        transform: translateY(-6px);
        box-shadow: 0 12px 28px rgba(0, 0, 0, 0.12) !important;
    }

    .product-img-wrapper {
        position: relative;
        overflow: hidden;
    }

    .product-card-img {
        height: 220px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .product-card:hover .product-card-img {
        transform: scale(1.06);
    }

    /* === Overlay === */
    .product-card .overlay {
        position: absolute;
        inset: 0;
        background: linear-gradient(135deg, rgba(0, 0, 0, 0.6) 0%, rgba(0, 0, 0, 0.35) 100%);
        backdrop-filter: blur(2px);
        opacity: 0;
        transition: opacity 0.3s ease;
        z-index: 2;
    }

    .product-card:hover .overlay {
        opacity: 1;
    }

    /* === Detail Button in Overlay === */
    .btn-card-detail {
        background: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        color: #1a1a1a !important;
        border: none;
        font-weight: 700;
        font-size: 0.95rem;
        padding: 0.55rem 1.5rem;
        border-radius: 50px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.25);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        transform: translateY(10px) scale(0.95);
        text-decoration: none;
        display: inline-block;
    }

    .product-card:hover .btn-card-detail {
        transform: translateY(0) scale(1);
    }

    .btn-card-detail:hover {
        background: linear-gradient(135deg, #f4c842 0%, #e8b535 100%);
        color: #000 !important;
        transform: translateY(-3px) scale(1.05) !important;
        box-shadow: 0 8px 22px rgba(232, 181, 53, 0.5);
    }

    .btn-card-detail:active {
        transform: translateY(0) scale(0.98) !important;
    }

    /* === Sidebar Filter Styling === */
    .filter-card {
        border-radius: 12px;
        border: 1px solid #f0f0f0;
    }

    .filter-card .form-check-label {
        cursor: pointer;
        transition: color 0.15s ease;
    }

    .filter-card .form-check-input {
        cursor: pointer;
    }

    .filter-card .form-check-input:checked {
        background-color: #e8b535;
        border-color: #e8b535;
    }

    .filter-card .form-check:hover .form-check-label {
        color: #c99318;
    }

    .btn-filter-apply {
        background-color: #e8b535;
        background-image: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        color: #1a1a1a;
        border: none;
        font-weight: 600;
        border-radius: 8px;
        padding: 0.6rem 1.25rem;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 3px 10px rgba(232, 181, 53, 0.25);
        cursor: pointer;
    }

    .btn-filter-apply:hover {
        background-image: linear-gradient(135deg, #f4c842 0%, #d89f21 100%);
        color: #000;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(232, 181, 53, 0.45);
    }

    .btn-filter-apply:active {
        transform: translateY(0);
        box-shadow: 0 2px 6px rgba(232, 181, 53, 0.2);
    }

    .btn-filter-reset {
        background-color: #f8f9fa;
        color: #495057;
        border: 1px solid #ced4da;
        font-weight: 500;
        border-radius: 8px;
        padding: 0.55rem 1.25rem;
        transition: all 0.25s ease;
        text-align: center;
        text-decoration: none;
        display: block;
    }

    .btn-filter-reset:hover {
        background-color: #e9ecef;
        color: #212529;
        border-color: #adb5bd;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08);
    }

    .btn-filter-reset:active {
        transform: translateY(0);
    }

    /* === Pagination === */
    .pagination .page-item.active .page-link {
        background-color: #e8b535;
        border-color: #e8b535;
        color: #fff;
        box-shadow: 0 4px 10px rgba(232, 181, 53, 0.3);
    }

    .pagination .page-link {
        color: #333;
        border-radius: 6px;
        margin: 0 2px;
        transition: all 0.2s ease;
    }

    .pagination .page-link:hover {
        background-color: #fff8e6;
        border-color: #e8b535;
        color: #c99318;
        transform: translateY(-1px);
    }
</style>

<div class="container content-top-padding">
    <div class="text-center mb-4 mb-md-5">
        <h1 class="fw-bold">Katalog Produk Kami</h1>
        <p class="lead text-muted">Temukan produk terbaik yang sesuai dengan kebutuhan Anda.</p>
    </div>
    <div class="row">
        {{-- Sidebar Filter --}}
        <div class="col-lg-3">
            <div class="card filter-card shadow-sm mb-4 overflow-hidden">
                <div class="card-header bg-white border-bottom py-3">
                    <h5 class="mb-0 fw-bold d-flex align-items-center">
                        <i class="bi bi-funnel me-2 text-warning"></i> Filter
                    </h5>
                </div>
                <div class="card-body p-3">
                    <form method="GET" action="{{ route('produk') }}">
                        <div class="mb-3">
                            <input type="text" name="search" class="form-control" 
                                   placeholder="Cari produk..." 
                                   value="{{ request('search') }}">
                        </div>
                        
                        <h6 class="fw-semibold mb-2">Kategori</h6>
                        @foreach($kategoris as $kat)
                            <div class="form-check py-1">
                                <input class="form-check-input" type="radio" name="kategori" 
                                       value="{{ $kat->id }}" id="kategori-{{ $kat->id }}"
                                       {{ request('kategori') == $kat->id ? 'checked' : '' }}>
                                <label class="form-check-label" for="kategori-{{ $kat->id }}">
                                    {{ $kat->nama_kategori }}
                                </label>
                            </div>
                        @endforeach

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-filter-apply mt-1">
                                Terapkan Filter
                            </button>
                            <a href="{{ route('produk') }}" class="btn btn-filter-reset">Reset</a>
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
                        <div class="card product-card h-100 border-0 shadow-sm overflow-hidden">
                            {{-- Gambar dengan overlay hover --}}
                            <div class="product-img-wrapper position-relative">
                                <img src="{{ $produk->foto ? cloudinary_url($produk->foto, 'f_auto,q_auto,w_600,c_limit') : asset('images/default.png') }}" 
                                     class="card-img-top product-card-img" 
                                     alt="{{ $produk->nama_produk }}"
                                     loading="lazy"
                                     decoding="async">
                                
                                {{-- Overlay tombol detail --}}
                                <div class="overlay d-flex justify-content-center align-items-center">
                                    <a href="{{ route('detail', $produk->id) }}" 
                                       class="btn-card-detail">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            {{-- Info Produk --}}
                            <div class="card-body text-center d-flex flex-column justify-content-between p-3">
                                <div>
                                    <h5 class="card-title fw-bold mb-1">{{ $produk->nama_produk }}</h5>
                                    <p class="text-muted small mb-2">{{ $produk->kategori->nama_kategori ?? '-' }}</p>
                                </div>
                                @if (($produk->kategori->nama_kategori ?? '') != "Desain Logo")
                                    @if (($produk->harga) != 0)
                                    <p class="fw-bold fs-5 text-danger mb-0 mt-auto">
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

            {{-- Pagination Links --}}
            @if(method_exists($produks, 'hasPages') && $produks->hasPages())
                <div class="d-flex justify-content-center mt-5">
                    {{ $produks->links() }}
                </div>
            @endif
        </div>
    </div>
</div>
@endsection
