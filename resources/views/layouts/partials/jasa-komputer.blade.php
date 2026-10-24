<style>
    .jasa-komputer-wrapper {
        position: relative;
        overflow: hidden;
        margin: 0 auto;
        border-radius: 12px;
        width: 100%;
    }

    .jasa-komputer-image {
        width: 100%;
        height: auto;
        aspect-ratio: 1050 / 350;
        display: block;
        object-fit: cover;
        transition: transform 0.4s ease;
    }

    .jasa-komputer-wrapper:hover .jasa-komputer-image {
        transform: scale(1.04);
    }

    .jasa-komputer-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0, 0, 0, 0.45);
        opacity: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        transition: opacity 0.4s ease;
    }

    .jasa-komputer-wrapper:hover .jasa-komputer-overlay {
        opacity: 1;
    }
</style>
<section id="{{ Str::slug($computerNama, '-') }}" class="pt-5" style="margin-bottom: 5px;">
    <h2 class="text-center section-title mb-4">SERVICE & ACCESSORIS COMPUTER</h2>

    <div class="jasa-komputer-wrapper">
        <img src="{{ cloudinary_url('banner/jasa-komputer.webp', 'f_auto,q_auto,w_1050') }}"
             alt="Service & Accessoris Komputer - Oscar Multimedia"
             class="jasa-komputer-image w-100 img-fluid"
             width="1050"
             height="350"
             loading="lazy"
             decoding="async">

            <div class="jasa-komputer-overlay">
                <a href="{{ route('produk', ['kategori' => $computerId]) }}"
                   class="btn px-4 py-2 rounded-pill fw-semibold"
                   style= "background-color: #e8b535; color: #fff;"
                   aria-label="Lihat semua produk Service & Accessoris Komputer">
                    Lihat Semua Produk
                </a>
            </div>
        </div>
</section>
