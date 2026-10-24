@extends('layouts.guest')

@section('title', 'Oscar Multimedia - ' . $produk->nama_produk)

@section('content')
<div class="container py-3 py-md-4">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-10 col-xl-9">
            <div class="card border-0 shadow-sm rounded-4 p-2 p-md-3 bg-white">
                <div class="card-body p-3 p-md-4 p-lg-5">
                    <div class="row align-items-center g-4">
                        <!-- Bagian Gambar -->
                        <div class="col-md-6 text-center">
                            <div class="p-3 bg-light rounded-4 shadow-sm d-flex align-items-center justify-content-center" style="min-height: 260px;">
                                <img src="{{ $produk->foto ? cloudinary_url($produk->foto, 'f_auto,q_auto,w_800,c_limit') : asset('images/default.png') }}" 
                                     class="img-fluid rounded-3" 
                                     alt="{{ $produk->nama_produk }}" 
                                     loading="lazy"
                                     decoding="async"
                                     style="max-height: 320px; width: 100%; object-fit: contain;">
                            </div>
                        </div>

                        <!-- Bagian Detail Produk -->
                        <div class="col-md-6">
                            <span class="badge px-3 py-2 mb-3" style="background-color:#e8b535; font-size: 0.9rem;">
                                {{ $produk->kategori?->nama_kategori ?? 'Umum' }}
                            </span>
                            
                            <h1 class="h3 fw-bold mb-3">{{ $produk->nama_produk }}</h1>
                            
                            @if (($produk->kategori?->nama_kategori ?? '') != "Desain Logo")
                                @if (!empty($produk->harga) && $produk->harga > 0)
                                <p class="fs-4 fw-semibold text-danger mb-3">
                                    Rp {{ number_format($produk->harga, 0, ',', '.') }}
                                </p>
                                @endif
                            @endif
                            
                            <hr class="my-3">

                            @php
                                $deskripsiItems = preg_split('/\r\n|\r|\n/', (string)$produk->deskripsi);
                            @endphp

                            <ul class="text-muted ps-3 mb-4">
                                @forelse($deskripsiItems as $item)
                                    @if(!empty(trim($item)))
                                        <li class="mb-1">{{ ltrim(trim($item), '-') }}</li>
                                    @endif
                                @empty
                                    <li class="text-muted fst-italic">Tidak ada deskripsi tambahan.</li>
                                @endforelse
                            </ul>

                            @php
                                $kontakSite = \App\Models\Kontak::first();
                                $waUrl = 'https://wa.me/628112890087';
                                if ($kontakSite && !empty($kontakSite->whatsapp_link)) {
                                    $waUrl = $kontakSite->whatsapp_link;
                                }
                                $orderText = 'Halo, saya ingin memesan produk ' . $produk->nama_produk;
                                $separator = str_contains($waUrl, '?') ? '&' : '?';
                                $finalWaLink = $waUrl . $separator . 'text=' . urlencode($orderText);
                            @endphp

                            <!-- Tombol Aksi -->
                            <div class="d-grid gap-2 d-sm-flex justify-content-sm-start mt-4">
                                <a href="{{ $finalWaLink }}" 
                                   target="_blank" 
                                   rel="noopener noreferrer"
                                   class="btn px-4 py-2 fw-semibold shadow-sm text-white"
                                   style="background-color: #e8b535; border-radius: 12px; transition: 0.3s;">
                                   <i class="bi bi-whatsapp me-2"></i> Order via WhatsApp
                                </a>
                                
                                <a href="{{ route('produk') }}" 
                                   class="btn btn-outline-secondary px-4 py-2 fw-semibold shadow-sm"
                                   style="border-radius: 12px; transition: 0.3s;">
                                   <i class="bi bi-arrow-left-circle me-2"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.12);
    }
</style>
@endsection