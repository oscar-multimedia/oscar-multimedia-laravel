<section id="{{ Str::slug($desainNama, '-') }}" class="container-fluid py-5">
    <h2 class="text-center section-title mb-5">DESAIN LOGO</h2>

    <div id="product-list-container" class="row gx-4 px-3 px-md-5 justify-content-center pb-5">
        @forelse ($desainProducts as $index => $produk)
            <div class="col-md-3 col-6 product-item my-3 @if($index >= 4) d-none product-toggleable @endif">
                <div class="card h-100 shadow-sm position-relative overflow-hidden hover-card">

                    {{-- Gambar Produk (SUDAH DIPERBAIKI) --}}
                    <img src="{{ cloudinary_url($produk->foto) }}" 
                         class="card-img-top product-image"  {{-- Hapus style inline, tambahkan class baru --}}
                         alt="{{ $produk->nama_produk }}">

                    {{-- Nama Produk --}}
                    <div class="card-body d-flex flex-column text-center">
                        <h5 class="card-title">{{ $produk->nama_produk }}</h5>
                    </div>

                    {{-- Overlay Hover --}}
                    <div class="hover-overlay d-flex align-items-center justify-content-center">
                        <a href="{{ route('produk', ['kategori' => $desainId]) }}"
                           class="btn rounded-pill px-4" 
                           style="background-color: #e8b535; color: #fff;">
                            Lihat Semua Produk
                        </a>
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
            <button id="toggle-products-btn" class="btn btn-link text-secondary">
                <i id="toggle-icon" class="bi bi-arrow-down-circle-fill fs-1"></i>
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

        if (toggleButton) {
            toggleButton.addEventListener('click', function () {
                const toggleableProducts = document.querySelectorAll('.product-toggleable');
                const isExpanded = toggleIcon.classList.contains('bi-arrow-up-circle-fill');

                toggleIcon.classList.toggle('bi-arrow-down-circle-fill', isExpanded);
                toggleIcon.classList.toggle('bi-arrow-up-circle-fill', !isExpanded);

                toggleableProducts.forEach(function (product) {
                    product.classList.toggle('d-none');
                });
            });
        }
    });
</script>
