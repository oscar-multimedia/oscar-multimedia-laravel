@if($carouselProducts->isNotEmpty())
    @php
        $firstProduct = $carouselProducts->first();
        $firstImageUrl = $firstProduct && $firstProduct->foto 
            ? cloudinary_url($firstProduct->foto, 'f_webp,q_auto,w_1000,c_limit') 
            : asset('images/default.png');
    @endphp

    @if(!isset($activePopup) || !$activePopup)
        @push('preload')
            <link rel="preload" as="image" href="{{ $firstImageUrl }}" fetchpriority="high">
        @endpush
    @endif

<section id="product-carousel-section" class="mb-4 mb-md-5">
    <div id="productCarousel" class="carousel slide rounded-4 overflow-hidden shadow-sm position-relative" data-bs-ride="carousel" data-bs-interval="4500">

        {{-- Indikator Modern Pill Bars --}}
        <div class="carousel-indicators mb-2 mb-md-3">
            @foreach ($carouselProducts as $product)
                <button type="button" data-bs-target="#productCarousel" 
                        data-bs-slide-to="{{ $loop->index }}" 
                        class="{{ $loop->first ? 'active' : '' }}" 
                        aria-current="{{ $loop->first ? 'true' : 'false' }}" 
                        aria-label="Slide {{ $loop->iteration }}"></button>
            @endforeach
        </div>

        {{-- Konten Slide --}}
        <div class="carousel-inner">
            @foreach ($carouselProducts as $product)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}">
                    @php
                        $backdropImageUrl = $product->foto 
                                            ? cloudinary_url($product->foto, 'f_webp,q_auto,w_900,h_375,c_fill') 
                                            : asset('images/default.png');
                        $mainImageUrl = $product->foto 
                                        ? cloudinary_url($product->foto, 'f_webp,q_auto,w_1000,c_limit') 
                                        : asset('images/default.png');
                        $kategoriNama = $product->kategori->nama_kategori ?? 'Oscar Multimedia';
                    @endphp

                    <div class="carousel-image-container position-relative overflow-hidden d-flex align-items-center justify-content-center">
                        {{-- 1. Ambient Blurred Backdrop: Mengisi seluruh lebar tanpa ada sisa kosong --}}
                        <img src="{{ $backdropImageUrl }}" 
                             alt="" 
                             aria-hidden="true" 
                             class="carousel-backdrop-img"
                             loading="{{ $loop->first ? 'eager' : 'lazy' }}">

                        {{-- 2. Ambient Gradient Overlay untuk kontras visual --}}
                        <div class="carousel-ambient-tint position-absolute top-0 start-0 w-100 h-100"></div>

                        {{-- 3. Hero Showcase Content (Split 2-Kolom Terpusat, Bebas Tanpa Kartu/Border Kaku) --}}
                        <div class="carousel-hero-content position-relative z-2 w-100 h-100 d-flex align-items-center justify-content-center">
                            <div class="container hero-container px-3 px-md-4 h-100">
                                <div class="row align-items-center justify-content-center h-100 g-3 g-lg-5">
                                    {{-- Kolom Kiri: Teks & Aksi (Besar, Hidup, & Berani) --}}
                                    <div class="col-12 col-lg-6 hero-text-col order-2 order-lg-1">
                                        <div class="hero-text-wrapper">
                                            <div class="hero-badge-wrap mb-2 mb-md-3">
                                                <a href="#{{ \Illuminate\Support\Str::slug($kategoriNama) }}" 
                                                   class="badge bg-gold text-dark text-decoration-none fw-bold px-3 py-2 rounded-pill d-inline-flex align-items-center shadow-sm">
                                                    <i class="bi bi-tag-fill me-1 text-dark"></i> {{ $kategoriNama }}
                                                </a>
                                            </div>
                                            <h2 class="carousel-product-title fw-bold mb-2 mb-md-3">
                                                <a href="{{ route('detail', $product->id) }}" class="text-decoration-none">
                                                    {{ $product->nama_produk ?? 'Produk Oscar Multimedia' }}
                                                </a>
                                            </h2>
                                            @php
                                                $rawDesc = trim(strip_tags((string)$product->deskripsi));
                                                $descLines = !empty($rawDesc) 
                                                    ? collect(preg_split('/\r\n|\r|\n/', $rawDesc))
                                                        ->map(fn($line) => trim($line))
                                                        ->filter(fn($line) => !empty($line))
                                                        ->values()
                                                    : collect();

                                                $isList = $descLines->count() > 1 || ($descLines->count() === 1 && preg_match('/^[-*•]/', $descLines[0]));
                                            @endphp

                                            @if($descLines->isNotEmpty())
                                                @if($isList)
                                                    @php
                                                        $displayItems = $descLines->take(3);
                                                        $moreCount = $descLines->count() - 3;
                                                    @endphp
                                                    <ul class="carousel-spec-list list-unstyled mb-3 mb-md-4 d-none d-md-flex flex-column gap-2">
                                                        @foreach($displayItems as $item)
                                                            <li class="carousel-spec-item d-flex align-items-center gap-2">
                                                                <i class="bi bi-check-circle-fill spec-icon flex-shrink-0"></i>
                                                                <span class="spec-text">{{ \Illuminate\Support\Str::limit(ltrim(trim($item), "-*• \t\n\r\0\x0B"), 75) }}</span>
                                                            </li>
                                                        @endforeach
                                                        @if($moreCount > 0)
                                                            <li class="carousel-spec-more pt-1">
                                                                <span class="badge bg-light text-secondary border fw-medium px-2 py-1 rounded-pill small">
                                                                    +{{ $moreCount }} spesifikasi lainnya
                                                                </span>
                                                            </li>
                                                        @endif
                                                    </ul>
                                                @else
                                                    <p class="carousel-product-desc mb-3 mb-md-4 d-none d-md-block">
                                                        {{ \Illuminate\Support\Str::limit($descLines[0], 115) }}
                                                    </p>
                                                @endif
                                            @endif
                                            <div class="hero-action-wrap">
                                                <a href="{{ route('detail', $product->id) }}" 
                                                   class="btn btn-carousel-cta d-inline-flex align-items-center gap-2 fw-bold px-4 py-2 px-md-4 py-md-2 rounded-pill shadow">
                                                    <span>Lihat Detail Produk</span>
                                                    <i class="bi bi-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Kolom Kanan: Foto Produk (Tampil Besar, Utuh, Melayang Bebas) --}}
                                    <div class="col-12 col-lg-6 hero-media-col order-1 order-lg-2">
                                        <div class="hero-media-wrapper d-flex align-items-center justify-content-center h-100">
                                            <a href="{{ route('detail', $product->id) }}" class="d-flex align-items-center justify-content-center text-decoration-none w-100 h-100">
                                                <img src="{{ $mainImageUrl }}" 
                                                     srcset="{{ cloudinary_url($product->foto, 'f_webp,q_auto,w_600,c_limit') }} 600w,
                                                             {{ cloudinary_url($product->foto, 'f_webp,q_auto,w_1000,c_limit') }} 1000w,
                                                             {{ cloudinary_url($product->foto, 'f_webp,q_auto,w_1400,c_limit') }} 1400w"
                                                     sizes="(max-width: 768px) 100vw, 1200px"
                                                     alt="{{ $product->nama_produk ?? 'Banner Oscar Multimedia' }}" 
                                                     class="carousel-img"
                                                     @if($loop->first) fetchpriority="high" @else loading="lazy" decoding="async" @endif>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Panah Kiri dan Kanan (Floating Glassmorphism Nav Buttons) --}}
        <button class="carousel-control-prev custom-carousel-nav" type="button" data-bs-target="#productCarousel" data-bs-slide="prev" aria-label="Slide Sebelumnya">
            <span class="nav-arrow-icon" aria-hidden="true">
                <i class="bi bi-chevron-left"></i>
            </span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next custom-carousel-nav" type="button" data-bs-target="#productCarousel" data-bs-slide="next" aria-label="Slide Selanjutnya">
            <span class="nav-arrow-icon" aria-hidden="true">
                <i class="bi bi-chevron-right"></i>
            </span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

{{-- CSS Styling Carousel (Glass Clear Transparent / Kaca Bening) --}}
<style>
    #productCarousel {
        background-color: #f1f5f9;
        border: 1px solid rgba(255, 255, 255, 0.9);
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.06);
    }

    .carousel-image-container {
        height: 500px;
        width: 100%;
        background-color: #f1f5f9;
        position: relative;
    }

    @media (min-width: 1200px) {
        .carousel-image-container {
            height: 520px;
        }
    }

    /* Ambient Backdrop: Foto produk asli tetap tampil hidup & kaya warna dengan kedalaman kaca */
    .carousel-backdrop-img {
        position: absolute;
        top: -15%;
        left: -15%;
        width: 130%;
        height: 130%;
        object-fit: cover;
        filter: blur(18px) saturate(1.25) brightness(1.04);
        opacity: 0.75;
        transform: scale(1.1);
        z-index: 1;
        pointer-events: none;
        user-select: none;
        transition: transform 0.6s ease, filter 0.6s ease;
    }

    /* Lapisan Efek Kaca Bening Transparan (Glass Clear Specular Sheen) */
    .carousel-ambient-tint {
        background: 
            radial-gradient(circle at 50% 35%, rgba(255, 255, 255, 0.38) 0%, rgba(255, 255, 255, 0.08) 60%),
            linear-gradient(135deg, rgba(255, 255, 255, 0.35) 0%, rgba(255, 255, 255, 0.06) 50%, rgba(255, 255, 255, 0.22) 100%);
        backdrop-filter: blur(4px);
        -webkit-backdrop-filter: blur(4px);
        z-index: 1;
        pointer-events: none;
    }

    /* Hero Content Area (Centered Content Stage) */
    .carousel-hero-content {
        padding: 1.5rem 2rem;
    }

    .hero-container {
        max-width: 1020px; /* Terpusat di tengah dengan sisa ruang kiri-kanan yang pas */
        margin-left: auto;
        margin-right: auto;
    }

    /* Kolom Teks Desktop */
    .hero-text-wrapper {
        text-align: left;
    }

    .carousel-product-title {
        font-size: 2.35rem;
        color: #0f172a;
        font-weight: 800;
        line-height: 1.2;
        letter-spacing: -0.5px;
    }

    .carousel-product-title a {
        color: #0f172a;
        transition: color 0.25s ease;
    }

    .carousel-product-title a:hover {
        color: #b08010 !important;
    }

    .carousel-product-desc {
        color: #334155;
        font-size: 1.02rem;
        line-height: 1.6;
        font-weight: 450;
        max-width: 520px;
    }

    .carousel-spec-list {
        max-width: 520px;
    }

    .carousel-spec-item {
        color: #334155;
        font-size: 0.98rem;
        line-height: 1.45;
    }

    .carousel-spec-item .spec-icon {
        color: #e8b535;
        font-size: 0.95rem;
    }

    .carousel-spec-item .spec-text {
        color: #334155;
        font-weight: 500;
    }

    .carousel-spec-more .badge {
        font-size: 0.78rem;
        background-color: rgba(255, 255, 255, 0.75) !important;
        backdrop-filter: blur(4px);
    }

    /* Kolom Foto Produk Desktop */
    .hero-media-wrapper {
        position: relative;
        height: 100%;
        max-height: 420px;
    }

    .hero-media-wrapper .carousel-img {
        max-width: 92%;
        max-height: 400px;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        filter: drop-shadow(0 20px 40px rgba(15, 23, 42, 0.18));
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1);
    }

    #productCarousel:hover .carousel-img {
        transform: scale(1.04) translateY(-4px);
    }

    #productCarousel:hover .carousel-backdrop-img {
        transform: scale(1.14);
    }

    .bg-gold {
        background-color: #e8b535 !important;
        font-size: 0.85rem;
        letter-spacing: 0.5px;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .bg-gold:hover {
        background-color: #d89f21 !important;
        transform: translateY(-1px);
    }

    /* Tombol CTA Detail */
    .btn-carousel-cta {
        background: linear-gradient(135deg, #e8b535 0%, #f5cb4e 100%);
        color: #1a1a1a !important;
        border: none;
        font-size: 0.95rem;
        box-shadow: 0 6px 18px rgba(232, 181, 53, 0.35);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-carousel-cta:hover {
        background: linear-gradient(135deg, #f5cb4e 0%, #e8b535 100%);
        transform: translateY(-2px);
        box-shadow: 0 10px 25px rgba(232, 181, 53, 0.5) !important;
        color: #000 !important;
    }

    .btn-carousel-cta i {
        transition: transform 0.2s ease;
    }

    .btn-carousel-cta:hover i {
        transform: translateX(4px);
    }

    /* Tombol Navigasi Panah Modern Floating Glassmorphism */
    .custom-carousel-nav {
        width: 48px;
        height: 48px;
        border-radius: 50% !important;
        background: rgba(255, 255, 255, 0.92) !important;
        backdrop-filter: blur(8px);
        -webkit-backdrop-filter: blur(8px);
        border: 1px solid rgba(0, 0, 0, 0.08) !important;
        color: #1a1a1a !important;
        top: 50%;
        transform: translateY(-50%);
        z-index: 20 !important;
        opacity: 0.92;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.1);
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        padding: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
    }

    .custom-carousel-nav.carousel-control-prev {
        left: 20px;
    }

    .custom-carousel-nav.carousel-control-next {
        right: 20px;
    }

    .custom-carousel-nav:hover,
    .custom-carousel-nav:focus {
        background: #e8b535 !important;
        color: #000000 !important;
        opacity: 1;
        transform: translateY(-50%) scale(1.1);
        box-shadow: 0 6px 20px rgba(232, 181, 53, 0.55);
    }

    .custom-carousel-nav .nav-arrow-icon {
        font-size: 1.35rem;
        line-height: 1;
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: bold;
    }

    /* Indikator Modern Pill Bars */
    .carousel-indicators {
        z-index: 10;
        bottom: 12px;
    }

    .carousel-indicators [data-bs-target] {
        width: 26px;
        height: 5px;
        border-radius: 4px;
        border: 0;
        background-color: rgba(0, 0, 0, 0.18);
        opacity: 0.6;
        margin: 0 4px;
        transition: all 0.3s ease;
    }

    .carousel-indicators .active {
        width: 48px;
        background-color: #e8b535;
        opacity: 1;
    }

    /* Penyesuaian Responsif Tablet */
    @media (max-width: 991.98px) and (min-width: 768px) {
        .carousel-image-container {
            height: 450px;
        }

        .carousel-hero-content {
            padding: 1.5rem 2.5rem !important;
        }

        .carousel-product-title {
            font-size: 1.85rem;
        }

        .carousel-product-desc {
            font-size: 0.95rem;
            max-width: 100%;
        }

        .carousel-spec-list {
            max-width: 100%;
        }

        .carousel-spec-item {
            font-size: 0.92rem;
        }

        .hero-media-wrapper .carousel-img {
            max-height: 320px;
        }
    }

    /* Penyesuaian Responsif Mobile (100% Mengikuti Layout Mobile yang Sudah Bagus) */
    @media (max-width: 767.98px) {
        .carousel-image-container {
            height: 360px;
        }

        .hero-container {
            max-width: 100% !important;
            padding: 0 !important;
        }

        .carousel-hero-content {
            padding: 1rem 1.25rem 1.25rem 1.25rem !important;
        }

        .hero-media-col {
            height: 200px;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-top: 0.5rem;
        }

        .hero-media-wrapper {
            height: 100%;
            width: 100%;
        }

        .hero-media-wrapper .carousel-img {
            max-width: 90%;
            max-height: 100%;
            object-fit: contain;
            filter: drop-shadow(0 10px 20px rgba(15, 23, 42, 0.14));
        }

        .hero-text-col {
            padding-top: 0.5rem;
        }

        .hero-text-wrapper {
            text-align: left;
            padding-right: 0;
        }

        .carousel-product-title {
            font-size: 1.15rem;
            line-height: 1.3;
            margin-bottom: 0.5rem !important;
            text-shadow: 0 1px 3px rgba(255, 255, 255, 0.85);
        }

        .bg-gold {
            font-size: 0.72rem;
            padding: 0.25rem 0.6rem !important;
        }

        .btn-carousel-cta {
            font-size: 0.8rem;
            padding: 0.35rem 0.85rem !important;
        }

        .custom-carousel-nav {
            width: 38px;
            height: 38px;
        }

        .custom-carousel-nav.carousel-control-prev {
            left: 10px;
        }

        .custom-carousel-nav.carousel-control-next {
            right: 10px;
        }

        .custom-carousel-nav .nav-arrow-icon {
            font-size: 1.1rem;
        }

        /* Reposisi Indikator Slide ke Pojok Kanan Atas (Gaya Modern Glass Pill Capsule - Bening) */
        .carousel-indicators {
            top: 14px !important;
            right: 14px !important;
            bottom: auto !important;
            left: auto !important;
            margin: 0 !important;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            padding: 5px 9px !important;
            border-radius: 20px;
            border: 1px solid rgba(0, 0, 0, 0.08);
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.06);
            z-index: 15;
            display: flex;
            align-items: center;
            gap: 4px;
        }

        .carousel-indicators [data-bs-target] {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            margin: 0;
            background-color: rgba(0, 0, 0, 0.22);
            border: 0;
            opacity: 0.7;
            transition: all 0.3s ease;
        }

        .carousel-indicators .active {
            width: 18px;
            border-radius: 10px;
            background-color: #e8b535;
            opacity: 1;
        }

        .carousel-caption-bottom {
            padding: 0.85rem 1rem 1rem 1rem !important;
        }
    }
</style>

{{-- Inisialisasi JavaScript Carousel & Handler Navigasi --}}
<script>
document.addEventListener('DOMContentLoaded', function() {
    const carouselEl = document.getElementById('productCarousel');
    if (!carouselEl) return;

    let carouselInstance = null;

    function initCarousel() {
        if (typeof bootstrap !== 'undefined' && bootstrap.Carousel) {
            carouselInstance = bootstrap.Carousel.getOrCreateInstance(carouselEl, {
                interval: 4500,
                ride: 'carousel',
                pause: 'hover',
                wrap: true,
                touch: true
            });
        }
    }

    initCarousel();

    // Pastikan handler tombol panah selalu merespons klik
    const prevBtn = carouselEl.querySelector('.carousel-control-prev');
    const nextBtn = carouselEl.querySelector('.carousel-control-next');

    if (prevBtn) {
        prevBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!carouselInstance) initCarousel();
            if (carouselInstance) carouselInstance.prev();
        });
    }

    if (nextBtn) {
        nextBtn.addEventListener('click', function(e) {
            e.preventDefault();
            if (!carouselInstance) initCarousel();
            if (carouselInstance) carouselInstance.next();
        });
    }

    // Touch/Swipe Gesture untuk kenyamanan swipe di mobile
    let touchStartX = null;
    let touchStartY = null;

    carouselEl.addEventListener('touchstart', function(e) {
        if (e.touches.length === 1) {
            touchStartX = e.touches[0].clientX;
            touchStartY = e.touches[0].clientY;
        }
    }, { passive: true });

    carouselEl.addEventListener('touchend', function(e) {
        if (touchStartX === null || e.changedTouches.length === 0) return;
        const touchEndX = e.changedTouches[0].clientX;
        const touchEndY = e.changedTouches[0].clientY;
        const diffX = touchStartX - touchEndX;
        const diffY = touchStartY - touchEndY;

        // Hanya trigger jika swipe horizontal lebih dominan daripada vertical scroll
        if (Math.abs(diffX) > 40 && Math.abs(diffX) > Math.abs(diffY)) {
            if (!carouselInstance) initCarousel();
            if (carouselInstance) {
                if (diffX > 0) {
                    carouselInstance.next();
                } else {
                    carouselInstance.prev();
                }
            }
        }
        touchStartX = null;
        touchStartY = null;
    }, { passive: true });
});
</script>

@else
    {{-- Fallback jika tidak ada produk sama sekali --}}
    <section id="highlight-product" class="highlight-section">
        <div class="placeholder-box large-placeholder d-flex align-items-center justify-content-center">
            <h2 class="h5 m-0">PRODUK BELUM TERSEDIA</h2>
        </div>
    </section>
@endif
