@extends('layouts.guest')

@section('title', $produk->nama_produk . ' - Oscar Multimedia')

@php
    $detailImageUrl = $produk->foto 
        ? cloudinary_url($produk->foto, 'f_webp,q_auto:eco,w_600,c_limit') 
        : asset('images/default.png');

    $kontakSite = \App\Models\Kontak::first();
    $waUrl = 'https://wa.me/628112890087';
    if ($kontakSite && !empty($kontakSite->whatsapp_link)) {
        $waUrl = $kontakSite->whatsapp_link;
    }
    $orderText = 'Halo Oscar Multimedia, saya tertarik dan ingin memesan produk: *' . $produk->nama_produk . '* (' . ($produk->kategori?->nama_kategori ?? 'Umum') . '). Boleh minta info detail dan prosedurnya?';
    $separator = str_contains($waUrl, '?') ? '&' : '?';
    $finalWaLink = $waUrl . $separator . 'text=' . urlencode($orderText);

    $deskripsiItems = preg_split('/\r\n|\r|\n/', (string)$produk->deskripsi);
@endphp

@push('preload')
    @if($produk->foto)
        <link rel="preload" as="image" href="{{ $detailImageUrl }}" fetchpriority="high">
    @endif
@endpush

@section('content')
<style>
    /* === Breadcrumb Navigation === */
    .breadcrumb-wrapper {
        margin-top: 0.5rem;
        margin-bottom: 1.5rem;
    }
    .custom-breadcrumb {
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 50px;
        padding: 0.5rem 1.25rem;
        display: inline-flex;
        align-items: center;
        flex-wrap: wrap;
        gap: 0.35rem;
        font-size: 0.88rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }
    .custom-breadcrumb a {
        color: #64748b;
        text-decoration: none;
        transition: color 0.15s ease;
    }
    .custom-breadcrumb a:hover {
        color: #c4951d;
    }
    .custom-breadcrumb .divider {
        color: #cbd5e1;
        font-size: 0.8rem;
    }
    .custom-breadcrumb .active-item {
        color: #1e293b;
        font-weight: 600;
        max-width: 240px;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    /* === Hero Product Detail Card === */
    .product-detail-card {
        background-color: #ffffff;
        border: 1px solid rgba(0, 0, 0, 0.06);
        border-radius: 20px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        overflow: hidden;
    }

    /* === Image Showcase === */
    .product-image-showcase {
        background: linear-gradient(180deg, #fbfcfe 0%, #f1f5f9 100%);
        border: 1px solid #e2e8f0;
        border-radius: 18px;
        padding: 1.75rem;
        min-height: 320px;
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }
    .product-hero-img {
        max-height: 380px;
        width: 100%;
        object-fit: contain;
        filter: drop-shadow(0 10px 22px rgba(0, 0, 0, 0.07));
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }
    .product-image-showcase:hover .product-hero-img {
        transform: scale(1.03);
    }

    /* === Category Badge === */
    .badge-category {
        background-color: #fff8e6;
        color: #b8860b;
        border: 1px solid #f3d88a;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.45rem 1.15rem;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        letter-spacing: 0.02em;
        box-shadow: 0 1px 4px rgba(232, 181, 53, 0.08);
    }
    .badge-category i {
        font-size: 0.95rem;
    }

    /* === Typography === */
    .product-title {
        font-size: 1.75rem;
        font-weight: 800;
        color: #0f172a;
        letter-spacing: -0.02em;
        line-height: 1.25;
    }
    @media (min-width: 768px) {
        .product-title {
            font-size: 2.15rem;
        }
    }

    .product-price {
        color: #dc2626;
        font-size: 1.95rem;
        font-weight: 800;
        letter-spacing: -0.01em;
        line-height: 1;
    }

    .product-price-custom {
        color: #059669;
        font-size: 1.2rem;
        font-weight: 700;
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
    }

    /* === Specifications List === */
    .spec-list {
        list-style: none;
        padding-left: 0;
        margin-bottom: 0;
    }
    .spec-item {
        display: flex;
        align-items: flex-start;
        gap: 0.75rem;
        padding: 0.4rem 0;
        color: #334155;
        font-size: 0.95rem;
        line-height: 1.5;
    }
    .spec-item i {
        color: #e8b535;
        font-size: 1.1rem;
        margin-top: 1px;
        flex-shrink: 0;
    }

    /* === Trust Features Strip === */
    .trust-strip {
        background-color: #f8fafc;
        border: 1px solid #eef2f6;
        border-radius: 14px;
        padding: 0.9rem 1.2rem;
    }
    .trust-item {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .trust-item i {
        color: #e8b535;
        font-size: 1.35rem;
        flex-shrink: 0;
    }
    .trust-text-title {
        font-size: 0.82rem;
        font-weight: 700;
        color: #1e293b;
        line-height: 1.2;
    }
    .trust-text-subtitle {
        font-size: 0.74rem;
        color: #64748b;
        line-height: 1.2;
    }

    /* === Action Buttons === */
    .btn-order-whatsapp {
        background: linear-gradient(135deg, #25D366 0%, #1ea952 100%);
        color: #ffffff !important;
        border: none;
        font-weight: 700;
        font-size: 1rem;
        padding: 0.8rem 1.6rem;
        border-radius: 12px;
        box-shadow: 0 4px 14px rgba(37, 211, 102, 0.32);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
    }
    .btn-order-whatsapp:hover {
        background: linear-gradient(135deg, #2be871 0%, #179346 100%);
        transform: translateY(-2px);
        box-shadow: 0 8px 24px rgba(37, 211, 102, 0.45);
        color: #ffffff !important;
    }
    .btn-order-whatsapp:active {
        transform: translateY(0);
    }

    .btn-back-catalog {
        background-color: #ffffff;
        color: #475569 !important;
        border: 1px solid #cbd5e1;
        font-weight: 600;
        font-size: 0.95rem;
        padding: 0.8rem 1.35rem;
        border-radius: 12px;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 0.65rem;
    }
    .btn-back-catalog i {
        transition: transform 0.2s ease;
    }
    .btn-back-catalog:hover {
        background-color: #f8fafc;
        border-color: #94a3b8;
        color: #0f172a !important;
        transform: translateY(-2px);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
    }
    .btn-back-catalog:hover i {
        transform: translateX(-3px);
    }
    .btn-back-catalog:active {
        transform: translateY(0);
    }

    /* === View Category Button with Hover === */
    .btn-view-category {
        background-color: #fff8e6;
        color: #b8860b !important;
        border: 1px solid #f3d88a;
        font-size: 0.85rem;
        font-weight: 600;
        border-radius: 50px;
        padding: 0.45rem 1.25rem;
        display: inline-flex;
        align-items: center;
        gap: 0.55rem;
        text-decoration: none;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        box-shadow: 0 2px 6px rgba(232, 181, 53, 0.1);
    }
    .btn-view-category i {
        transition: transform 0.2s ease;
    }
    .btn-view-category:hover {
        background: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        border-color: #e8b535;
        color: #1a1a1a !important;
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(232, 181, 53, 0.35);
    }
    .btn-view-category:hover i {
        transform: translateX(3px);
    }
    .btn-view-category:active {
        transform: translateY(0);
    }

    /* === Related Products Section (Consistent with produk.blade.php) === */
    .product-card {
        border-radius: 14px;
        transition: transform 0.3s cubic-bezier(0.16, 1, 0.3, 1), box-shadow 0.3s cubic-bezier(0.16, 1, 0.3, 1);
        border: 1px solid rgba(0, 0, 0, 0.06);
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
        height: 200px;
        object-fit: cover;
        transition: transform 0.4s ease;
    }
    .product-card:hover .product-card-img {
        transform: scale(1.06);
    }
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
    .btn-card-detail {
        background: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        color: #1a1a1a !important;
        border: none;
        font-weight: 700;
        font-size: 0.9rem;
        padding: 0.5rem 1.4rem;
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
</style>

<div class="container py-2 py-md-3">
    {{-- Breadcrumb Navigation --}}
    <div class="breadcrumb-wrapper">
        <nav aria-label="breadcrumb">
            <div class="custom-breadcrumb">
                <a href="{{ route('home') }}">
                    <i class="bi bi-house-door-fill me-1 text-warning"></i>Beranda
                </a>
                <span class="divider"><i class="bi bi-chevron-right"></i></span>
                <a href="{{ route('produk') }}">Katalog Produk</a>
                @if($produk->kategori)
                    <span class="divider"><i class="bi bi-chevron-right"></i></span>
                    <a href="{{ route('produk', ['kategori' => $produk->kategori_id]) }}">
                        {{ $produk->kategori->nama_kategori }}
                    </a>
                @endif
                <span class="divider"><i class="bi bi-chevron-right"></i></span>
                <span class="active-item" title="{{ $produk->nama_produk }}">{{ $produk->nama_produk }}</span>
            </div>
        </nav>
    </div>

    {{-- Main Product Card --}}
    <div class="product-detail-card p-3 p-md-4 p-lg-5">
        <div class="row align-items-center g-4 g-lg-5">
            {{-- Bagian Gambar Showcase --}}
            <div class="col-12 col-lg-5">
                <div class="product-image-showcase">
                    <img src="{{ $detailImageUrl }}" 
                         srcset="{{ cloudinary_url($produk->foto, 'f_webp,q_auto:eco,w_380,c_limit') }} 380w,
                                 {{ cloudinary_url($produk->foto, 'f_webp,q_auto:eco,w_600,c_limit') }} 600w,
                                 {{ cloudinary_url($produk->foto, 'f_webp,q_auto:eco,w_850,c_limit') }} 850w"
                         sizes="(max-width: 576px) 380px, (max-width: 991px) 600px, 850px"
                         class="product-hero-img" 
                         alt="{{ $produk->nama_produk }}" 
                         width="600"
                         height="400"
                         loading="eager"
                         fetchpriority="high"
                         decoding="async">
                </div>
            </div>

            {{-- Bagian Informasi & Detail Produk --}}
            <div class="col-12 col-lg-7">
                {{-- Kategori Badge --}}
                <div class="mb-2">
                    <span class="badge-category">
                        <i class="bi bi-tag-fill"></i>
                        <span>{{ $produk->kategori?->nama_kategori ?? 'Umum' }}</span>
                    </span>
                </div>

                {{-- Judul Produk --}}
                <h1 class="product-title mb-3">{{ $produk->nama_produk }}</h1>

                {{-- Harga Produk --}}
                <div class="mb-4">
                    @if (($produk->kategori?->nama_kategori ?? '') != "Desain Logo" && !empty($produk->harga) && $produk->harga > 0)
                        <div class="d-flex align-items-baseline gap-2">
                            <span class="product-price">Rp {{ number_format($produk->harga, 0, ',', '.') }}</span>
                            <span class="text-muted small">/ pcs / item</span>
                        </div>
                    @else
                        <div class="d-flex align-items-center">
                            <span class="product-price-custom">
                                <i class="bi bi-chat-quote-fill"></i>
                                <span>Hubungi Kami untuk Estimasi Biaya</span>
                            </span>
                        </div>
                    @endif
                </div>

                {{-- Feature / Trust Strip --}}
                <div class="trust-strip mb-4">
                    <div class="row g-3">
                        <div class="col-12 col-sm-4">
                            <div class="trust-item">
                                <i class="bi bi-patch-check-fill"></i>
                                <div>
                                    <div class="trust-text-title">Kualitas Terjamin</div>
                                    <div class="trust-text-subtitle">Bahan & cetak presisi</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="trust-item">
                                <i class="bi bi-lightning-charge-fill"></i>
                                <div>
                                    <div class="trust-text-title">Pengerjaan Cepat</div>
                                    <div class="trust-text-subtitle">Sesuai tenggat waktu</div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-sm-4">
                            <div class="trust-item">
                                <i class="bi bi-headset"></i>
                                <div>
                                    <div class="trust-text-title">Konsultasi Gratis</div>
                                    <div class="trust-text-subtitle">Bantu rekomendasi cetak</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Deskripsi & Spesifikasi --}}
                <div class="mb-4">
                    <h6 class="fw-bold text-dark mb-2.5 d-flex align-items-center gap-2">
                        <i class="bi bi-card-text text-warning fs-5"></i>
                        <span>Deskripsi & Spesifikasi Produk</span>
                    </h6>
                    <ul class="spec-list">
                        @forelse($deskripsiItems as $item)
                            @if(!empty(trim($item)))
                                <li class="spec-item">
                                    <i class="bi bi-check2-circle"></i>
                                    <span>{{ ltrim(trim($item), '-*• ') }}</span>
                                </li>
                            @endif
                        @empty
                            <li class="text-muted fst-italic">Silakan hubungi customer service kami via WhatsApp untuk spesifikasi detail dan varian cetak lainnya.</li>
                        @endforelse
                    </ul>
                </div>

                <hr class="my-4" style="border-color: #f1f5f9;">

                {{-- Tombol Aksi --}}
                <div class="d-flex flex-column flex-sm-row gap-3">
                    <a href="{{ $finalWaLink }}" 
                       target="_blank" 
                       rel="noopener noreferrer"
                       class="btn btn-order-whatsapp flex-grow-1"
                       aria-label="Order produk {{ $produk->nama_produk }} via WhatsApp">
                       <i class="bi bi-whatsapp fs-5"></i>
                       <span>Pesan via WhatsApp</span>
                    </a>
                    
                    <a href="{{ route('produk') }}" 
                       class="btn btn-back-catalog"
                       aria-label="Kembali ke halaman katalog produk">
                       <i class="bi bi-arrow-left fs-5"></i>
                       <span>Katalog Produk</span>
                    </a>
                </div>
            </div>
        </div>
    </div>

    {{-- Section Produk Terkait --}}
    @if(isset($relatedProducts) && $relatedProducts->count() > 0)
        <div class="mt-5 pt-3">
            <div class="d-flex justify-content-between align-items-end mb-4">
                <div>
                    <h3 class="fw-bold mb-1" style="color: #0f172a;">Produk Terkait Lainnya</h3>
                    <p class="text-muted small mb-0">Pilihan produk berkualitas lainnya yang mungkin sesuai dengan kebutuhan Anda</p>
                </div>
                <a href="{{ route('produk', ['kategori' => $produk->kategori_id]) }}" 
                   class="btn btn-view-category d-none d-sm-inline-flex"
                   aria-label="Lihat produk lainnya di kategori {{ $produk->kategori?->nama_kategori ?? 'ini' }}">
                    <span>Lihat Kategori</span>
                    <i class="bi bi-arrow-right"></i>
                </a>
            </div>

            <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 g-4">
                @foreach($relatedProducts as $item)
                    <div class="col">
                        <div class="card product-card h-100 bg-white shadow-sm overflow-hidden">
                            <div class="product-img-wrapper">
                                <img src="{{ $item->foto ? cloudinary_url($item->foto, 'f_webp,q_auto:eco,w_400,h_260,c_fill') : asset('images/default.png') }}" 
                                     class="card-img-top product-card-img" 
                                     alt="{{ $item->nama_produk }}"
                                     width="400"
                                     height="260"
                                     loading="lazy"
                                     decoding="async">
                                
                                <div class="overlay d-flex justify-content-center align-items-center">
                                    <a href="{{ route('detail', $item->id) }}" class="btn-card-detail">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-3 d-flex flex-column text-center">
                                <span class="badge align-self-center mb-2 px-2.5 py-1" style="background-color: #fff8e6; color: #b8860b; border: 1px solid #f3d88a; font-size: 0.72rem; border-radius: 50px;">
                                    {{ $item->kategori->nama_kategori ?? 'Umum' }}
                                </span>
                                <h5 class="card-title fw-bold text-dark mb-1 h6 text-truncate" title="{{ $item->nama_produk }}">
                                    {{ $item->nama_produk }}
                                </h5>

                                <div class="mt-auto pt-2">
                                    @if(($item->kategori->nama_kategori ?? '') != 'Desain Logo' && $item->harga > 0)
                                        <p class="fw-bold text-danger mb-0" style="font-size: 1rem;">
                                            Rp {{ number_format($item->harga, 0, ',', '.') }}
                                        </p>
                                    @else
                                        <p class="text-success fw-semibold small mb-0">Hubungi Kami</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection