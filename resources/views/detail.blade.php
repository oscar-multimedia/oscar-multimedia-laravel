@extends('layouts.guest')

@section('title', 'Oscar Multimedia - Detail Produk')

@section('content')
<div class="d-flex justify-content-center align-items-center" style="min-height: calc(100vh - 60px); background-color: #f9f9f9;">
    <div class="card border-0 shadow-lg rounded-4 w-65 p-3">
        <div class="card-body p-5">
            <div class="row align-items-center g-4">
                <!-- Bagian Gambar -->
                <div class="col-md-6 text-center">
                    <div class="p-3 bg-light rounded-4 shadow-sm">
                        <img src="{{ cloudinary_url($produk->foto) }}" 
                             class="img-fluid rounded-3" 
                             alt="{{ $produk->nama_produk }}" 
                             style="max-height: 320px; object-fit: contain;">
                    </div>
                </div>

                <!-- Bagian Detail Produk -->
                <div class="col-md-6">
                    <span class="badge px-3 py-2 mb-3" style="background-color:#e8b535; font-size: 0.9rem;">
                        {{ $produk->kategori->nama_kategori }}
                    </span>
                    
                    <h1 class="h3 fw-bold mb-3">{{ $produk->nama_produk }}</h1>
                    
                    @if (($produk->kategori->nama_kategori ?? '') != "Desain Logo")
                        @if (($produk->harga) != 0)
                        <p class="fs-4 fw-semibold text-danger mb-3">
                            Rp {{ number_format($produk->harga, 0, ',', '.') }}
                        </p>
                        @endif
                    @endif
                    
                    <hr class="my-3">

                    @php
                        $deskripsiItems = preg_split('/\r\n|\r|\n/', $produk->deskripsi);
                    @endphp

                    <ul class="text-muted">
                        @foreach($deskripsiItems as $item)
                            @if(!empty(trim($item)))
                                <li>{{ ltrim($item, '-') }}</li>
                            @endif
                        @endforeach
                    </ul>
                    
                    {{-- <p class="lead text-muted">{{ $produk->deskripsi }}</p> --}}

                    <!-- Tombol Aksi -->
                    <div class="d-grid gap-3 d-md-flex justify-content-md-start mt-4">
                        <a href="https://wa.me/628112890087?text=Halo, saya ingin memesan produk {{ urlencode($produk->nama_produk) }}" 
                           target="_blank" 
                           class="btn px-4 py-2 fw-semibold shadow-sm"
                           style="background-color: #e8b535; color: #fff; border-radius: 12px; transition: 0.3s;">
                           <i class="bi bi-whatsapp me-2"></i> Order via WhatsApp
                        </a>
                        
                        <a href="{{ route('produk') }}" 
                           class="btn btn-outline-secondary px-4 py-2 fw-semibold shadow-sm"
                           style="border-radius: 12px; transition: 0.3s;">
                           <i class="bi bi-arrow-left-circle me-2"></i> Kembali ke Katalog
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Sedikit CSS tambahan untuk hover effect -->
<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.15);
    }
</style>

@endsection