@if($carouselProducts->isNotEmpty())
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
                                    ? cloudinary_url($product->foto) 
                                    : asset('images/default.png'); // fallback jika foto null
                        $kategoriNama = $product->kategori->nama_kategori ?? 'Tanpa Kategori';
                    @endphp

                    <div class="carousel-image-container" 
                         style="background-image: url('{{ $imageUrl }}'); max-height: 600px; overflow: hidden;">
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
        background-size: contain;
        background-repeat: no-repeat;
        background-position: center;
        background-color: #fff; /* supaya rapi kalau gambar kecil */
    }
    .carousel-caption-overlay {
        position: absolute;
        top: 0; left: 0; right: 0; bottom: 0;
        /* background-color: rgba(0, 0, 0, 0.5); */
        background: linear-gradient(
        rgba(0,0,0,0.25), 
        rgba(0,0,0,0.25)
    );
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
