@if($carouselProducts->isNotEmpty())
    @php
        $firstProduct = $carouselProducts->first();
        $firstImageUrl = $firstProduct && $firstProduct->foto 
            ? cloudinary_url($firstProduct->foto, 'f_webp,q_auto,w_900,h_375,c_fill') 
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
                        $imageUrl = $product->foto 
                                    ? cloudinary_url($product->foto, 'f_webp,q_auto,w_900,h_375,c_fill') 
                                    : asset('images/default.png');
                        $kategoriNama = $product->kategori->nama_kategori ?? 'Oscar Multimedia';
                    @endphp

                    <div class="carousel-image-container position-relative overflow-hidden d-flex align-items-center justify-content-center">
                        {{-- 1. Ambient Blurred Backdrop: Mengisi seluruh lebar tanpa ada sisa kosong --}}
                        <img src="{{ $imageUrl }}" 
                             alt="" 
                             aria-hidden="true" 
                             class="carousel-backdrop-img"
                             loading="{{ $loop->first ? 'eager' : 'lazy' }}">

                        {{-- 2. Ambient Gradient Overlay untuk kontras visual --}}
                        <div class="carousel-ambient-tint position-absolute top-0 start-0 w-100 h-100"></div>

                        {{-- 3. Foto Produk Utama: Tampil tajam, utuh & elegan di tengah dengan drop shadow --}}
                        <div class="carousel-main-img-wrapper position-relative z-2 d-flex align-items-center justify-content-center w-100 h-100 p-3 p-md-4">
                            <img src="{{ $imageUrl }}" 
                                 srcset="{{ cloudinary_url($product->foto, 'f_webp,q_auto,w_500,h_210,c_fill') }} 500w,
                                         {{ cloudinary_url($product->foto, 'f_webp,q_auto,w_900,h_375,c_fill') }} 900w,
                                         {{ cloudinary_url($product->foto, 'f_webp,q_auto,w_1200,h_500,c_fill') }} 1200w"
                                 sizes="(max-width: 768px) 100vw, 1200px"
                                 alt="{{ $product->nama_produk ?? 'Banner Oscar Multimedia' }}" 
                                 class="carousel-img"
                                 width="900" 
                                 height="375"
                                 @if($loop->first) fetchpriority="high" @else loading="lazy" decoding="async" @endif>
                        </div>

                        {{-- 4. Caption Overlay di Bawah (Pointer-events controlled agar tidak memblokir tombol panah) --}}
                        <div class="carousel-caption-bottom position-absolute bottom-0 start-0 end-0 p-3 p-md-4 z-3">
                            <div class="container-fluid px-2 px-md-3">
                                <div class="d-flex flex-column flex-sm-row justify-content-between align-items-start align-items-sm-end gap-2">
                                    <div class="caption-content">
                                        <a href="#{{ \Illuminate\Support\Str::slug($kategoriNama) }}" 
                                           class="badge bg-gold text-dark text-decoration-none fw-bold px-3 py-2 rounded-pill mb-2 d-inline-flex align-items-center shadow-sm">
                                            <i class="bi bi-tag-fill me-1"></i> {{ $kategoriNama }}
                                        </a>
                                        <h2 class="carousel-product-title fw-bold mb-1">
                                            <a href="{{ route('detail', $product->id) }}" class="text-decoration-none">
                                                {{ $product->nama_produk ?? 'Produk Oscar Multimedia' }}
                                            </a>
                                        </h2>
                                    </div>
                                    <div class="caption-action mt-2 mt-sm-0 flex-shrink-0">
                                        <a href="{{ route('detail', $product->id) }}" 
                                           class="btn btn-carousel-cta d-inline-flex align-items-center gap-2 fw-semibold px-3 py-2 px-md-4 py-md-2 rounded-pill shadow">
                                            <span>Lihat Detail</span>
                                            <i class="bi bi-arrow-right"></i>
                                        </a>
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

    /* Foto Produk Utama */
    .carousel-main-img-wrapper {
        z-index: 2;
        pointer-events: none;
        padding-bottom: 5.5rem !important; /* Ruang agar gambar leluasa di atas caption bawah */
    }

    .carousel-img {
        max-width: 92%;
        max-height: 95%;
        width: auto;
        height: auto;
        object-fit: contain;
        display: block;
        filter: drop-shadow(0 16px 32px rgba(15, 23, 42, 0.2));
        transition: transform 0.4s ease;
    }

    #productCarousel:hover .carousel-img {
        transform: scale(1.03);
    }

    #productCarousel:hover .carousel-backdrop-img {
        transform: scale(1.14);
    }

    /* Caption Overlay di Bawah (Frosted Glass Panel Bening) */
    .carousel-caption-bottom {
        background: linear-gradient(to top, rgba(255, 255, 255, 0.92) 0%, rgba(255, 255, 255, 0.62) 65%, rgba(255, 255, 255, 0) 100%);
        backdrop-filter: blur(10px);
        -webkit-backdrop-filter: blur(10px);
        z-index: 5;
        pointer-events: none; /* Kunci agar tidak memblokir tombol panah */
    }

    .carousel-caption-bottom .caption-content,
    .carousel-caption-bottom .caption-action {
        pointer-events: auto; /* Tombol dan link tetap interaktif */
    }

    .bg-gold {
        background-color: #e8b535 !important;
        font-size: 0.8rem;
        letter-spacing: 0.5px;
        transition: transform 0.2s ease, background-color 0.2s ease;
    }

    .bg-gold:hover {
        background-color: #d89f21 !important;
        transform: translateY(-1px);
    }

    .carousel-product-title {
        font-size: 1.65rem;
        color: #0f172a;
        max-width: 700px;
        line-height: 1.25;
        text-shadow: 0 1px 4px rgba(255, 255, 255, 0.85);
    }

    .carousel-product-title a {
        color: #0f172a;
        transition: color 0.2s ease;
    }

    .carousel-product-title a:hover {
        color: #b08010 !important;
    }

    /* Tombol CTA Detail */
    .btn-carousel-cta {
        background: linear-gradient(135deg, #e8b535 0%, #f5cb4e 100%);
        color: #1a1a1a !important;
        border: none;
        font-size: 0.92rem;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .btn-carousel-cta:hover {
        background: linear-gradient(135deg, #f5cb4e 0%, #e8b535 100%);
        transform: translateY(-2px);
        box-shadow: 0 6px 18px rgba(232, 181, 53, 0.45) !important;
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

    /* Penyesuaian Responsif Mobile */
    @media (max-width: 767.98px) {
        .carousel-image-container {
            height: 360px;
        }

        .carousel-main-img-wrapper {
            padding-bottom: 4.5rem !important;
        }

        .carousel-product-title {
            font-size: 1.15rem;
            line-height: 1.3;
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
