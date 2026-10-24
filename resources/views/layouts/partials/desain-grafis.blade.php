<section id="{{ Str::slug($desainNama, '-') }}" class="container-fluid py-5">
    <h2 class="text-center section-title mb-5">DESAIN LOGO</h2>

    <div id="product-list-container" class="row gx-4 px-3 px-md-5 justify-content-center pb-5">
        @forelse ($desainProducts as $index => $produk)
            <div class="col-md-3 col-6 product-item my-3 @if($index >= 4) d-none product-toggleable @endif">
                <div class="card h-100 shadow-sm position-relative overflow-hidden hover-card">

                    <img src="{{ cloudinary_url($produk->foto, 'f_webp,q_auto,w_250,h_250,c_fill') }}" 
                         srcset="{{ cloudinary_url($produk->foto, 'f_webp,q_auto,w_160,h_160,c_fill') }} 160w,
                                 {{ cloudinary_url($produk->foto, 'f_webp,q_auto,w_250,h_250,c_fill') }} 250w"
                         sizes="(max-width: 576px) 160px, 250px"
                         class="card-img-top product-image"
                         alt="{{ $produk->nama_produk }}"
                         width="250"
                         height="250"
                         loading="lazy"
                         decoding="async">

                    {{-- Nama Produk --}}
                    <div class="card-body d-flex flex-column text-center">
                        <h3 class="card-title h5 mb-0">{{ $produk->nama_produk }}</h3>
                    </div>

                    {{-- Overlay Hover --}}
                    <div class="hover-overlay d-flex align-items-center justify-content-center p-2">
                        <x-product-overlay-button 
                            :href="route('produk', ['kategori' => $desainId])"
                            label="Lihat Semua Produk"
                            mobileLabel="Lihat Semua"
                            icon="bi bi-eye"
                            ariaLabel="Lihat produk desain: {{ $produk->nama_produk }}" />
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-info text-center">
                    Belum ada produk Desain Grafis yang tersedia.
                </div>
            </div>
        @endforelse
    </div>

    {{-- Tombol toggle jika produk > 4 --}}
    @if(count($desainProducts) > 4)
        <div class="text-center mt-5">
            <button id="toggle-products-btn" class="btn btn-link text-secondary" type="button" aria-expanded="false" aria-label="Tampilkan lebih banyak produk desain logo">
                <i id="toggle-icon" class="bi bi-arrow-down-circle-fill fs-1" aria-hidden="true"></i>
                <span id="toggle-btn-text" class="visually-hidden">Tampilkan lebih banyak produk desain logo</span>
            </button>
        </div>
    @endif
</section>

{{-- CSS --}}
<style>
    .product-image {
        aspect-ratio: 1 / 1; /* Membuat rasio lebar:tinggi menjadi 1:1 */
        object-fit: cover;   /* Memastikan gambar mengisi area tanpa distorsi */
        width: 100%;
    }

    .product-item {
        transition: opacity 0.5s ease-in-out, transform 0.5s ease-in-out;
    }

    .hover-card {
        position: relative;
        overflow: hidden;
    }

    .hover-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.5);
        opacity: 0;
        transition: opacity 0.4s ease;
        z-index: 2;
    }

    .hover-card:hover .hover-overlay {
        opacity: 1;
    }

    .hover-overlay a.btn {
        font-weight: 600;
        font-size: 1rem;
    }
        /* === ATURAN KHUSUS UNTUK MOBILE (Layar <= 576px) === */
    @media (max-width: 575.98px) {
        .hover-overlay a.btn {
            /* Kustomisasi ukuran untuk mobile di sini */
            font-size: 0.6rem; /* Ukuran font lebih kecil */
            /* padding: 0.5rem 0.5rem; */
        }
    }
    .section-title {
        font-weight: bold;
        color: #333;
    }
</style>

{{-- JS Toggle Produk --}}
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const toggleButton = document.getElementById('toggle-products-btn');
        const toggleIcon = document.getElementById('toggle-icon');
        const toggleText = document.getElementById('toggle-btn-text');

        if (toggleButton && toggleIcon) {
            toggleButton.addEventListener('click', function () {
                const toggleableProducts = document.querySelectorAll('.product-toggleable');
                const isExpanded = toggleIcon.classList.contains('bi-arrow-up-circle-fill');

                toggleIcon.classList.toggle('bi-arrow-down-circle-fill', isExpanded);
                toggleIcon.classList.toggle('bi-arrow-up-circle-fill', !isExpanded);

                const newAriaLabel = isExpanded ? 'Tampilkan lebih banyak produk desain logo' : 'Sembunyikan produk desain logo';
                toggleButton.setAttribute('aria-expanded', !isExpanded);
                toggleButton.setAttribute('aria-label', newAriaLabel);
                if (toggleText) {
                    toggleText.textContent = newAriaLabel;
                }

                toggleableProducts.forEach(function (product) {
                    product.classList.toggle('d-none');
                });
            });
        }
    });
</script>
