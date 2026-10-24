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

<section id="product-carousel-section">
    <div id="productCarousel" class="carousel slide" data-bs-ride="carousel">

        {{-- Indikator (titik-titik di bawah) --}}
        <div class="carousel-indicators">
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
                        $kategoriNama = $product->kategori->nama_kategori ?? 'Tanpa Kategori';
                    @endphp

                    <div class="carousel-image-container position-relative overflow-hidden d-flex align-items-center justify-content-center">
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

                        <div class="carousel-caption-overlay d-flex align-items-center justify-content-center">
                            <div class="text-center text-white">
                                <h2 class="display-4 fw-bold text-uppercase">
                                    <a href="#{{ \Illuminate\Support\Str::slug($kategoriNama) }}" 
                                       class="text-white text-decoration-none">
                                        {{ $kategoriNama }}
                                    </a>
                                </h2>
                                <p class="lead fs-3">{{ $product->nama_produk ?? 'Produk Tanpa Nama' }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Tombol Panah Kiri dan Kanan --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#productCarousel" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#productCarousel" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>
</section>

{{-- CSS untuk styling carousel --}}
<style>
    .carousel-image-container {
        height: 450px;
        width: 100%;
        background-color: #fff;
        position: relative;
    }
    .carousel-img {
        width: 100%;
        height: 100%;
        object-fit: contain;
        display: block;
    }
    .carousel-caption-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        background: linear-gradient(
            rgba(0,0,0,0.3), 
            rgba(0,0,0,0.3)
        );
        z-index: 2;
    }
    @media (max-width: 767.98px) {
        .carousel-image-container {
            height: 280px;
        }
        .carousel-caption-overlay .display-4 {
            font-size: 1.8rem;
        }
        .carousel-caption-overlay .lead {
            font-size: 1rem !important;
        }
    }
</style>

@else
    {{-- Fallback jika tidak ada produk sama sekali --}}
    <section id="highlight-product" class="highlight-section">
        <div class="placeholder-box large-placeholder d-flex align-items-center justify-content-center">
            <h2 class="h5 m-0">PRODUK BELUM TERSEDIA</h2>
        </div>
    </section>
@endif
