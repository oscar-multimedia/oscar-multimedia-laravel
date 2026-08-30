<section id="{{ Str::slug($printingNama, '-') }}" class="py-5">
    <div class="container">
        <h2 class="text-center section-title mb-5">DIGITAL PRINTING</h2>
    </div>

    <div id="digitalPrintingCarousel" class="carousel slide" data-bs-interval="4000">
        <div class="carousel-inner">
            @foreach($digitalPrintingProducts->chunk(8) as $chunkIndex => $chunk)
                <div class="carousel-item {{ $chunkIndex == 0 ? 'active' : '' }}">
                    <div class="container-fluid px-lg-5 px-3">
                        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-4">
                            @foreach($chunk as $product)
                                <div class="col">
                                    <div class="product-grid-card position-relative overflow-hidden" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                                        <div class="image-wrapper">
                                            <img src="{{ cloudinary_url($product->foto) }}" 
                                                 alt="{{ $product->nama_produk }}" 
                                                 class="product-image">
                                        </div>
                                        <div class="overlay position-absolute top-0 start-0 w-100 h-100 d-flex flex-column justify-content-center align-items-center p-3">
                                            <h5 class="product-title text-white fw-bold text-center mb-3">{{ $product->nama_produk }}</h5>
                                            <a href="{{ route('produk', ['kategori' => $printingId]) }}" 
                                               class="btn btn-detail rounded-pill px-4 py-2">
                                                <i class="fas fa-eye me-2"></i>Lihat Semua Produk
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <!-- Custom Navigation Controls -->
        @if($digitalPrintingProducts->chunk(8)->count() > 1)
            <button id="tombolprev" class="carousel-control-prev custom-carousel-control" style= "color: #0000" type="button" data-bs-target="#digitalPrintingCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button id="tombolnext" class="carousel-control-next custom-carousel-control" style= "color: #0000" type="button" data-bs-target="#digitalPrintingCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>

            <!-- Custom Indicators -->
            <!-- <div id="tombolgeser" class="carousel-indicators custom-indicators" style="color: #0000;">
                @foreach($digitalPrintingProducts->chunk(8) as $chunkIndex => $chunk)
                    <button type="button" 
                            data-bs-target="#digitalPrintingCarousel" 
                            data-bs-slide-to="{{ $chunkIndex }}" 
                            class="{{ $chunkIndex == 0 ? 'active' : '' }}"
                            aria-label="Slide {{ $chunkIndex + 1 }}">
                    </button>
                @endforeach
            </div>
        @endif -->
    </div>
</section>

<style>
    .product-grid-card {
        height: 280px;
        overflow: hidden;
        position: relative;
        transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
        box-shadow: 0 0.25rem 0.75rem rgba(0,0,0,0.1);
        cursor: pointer;
    }
    .image-wrapper {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }
    .product-image {
        width: 100%;
        height: 100%;
        object-fit: cover;
        transition: all 0.4s ease;
    }
    .product-grid-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 2rem rgba(0,0,0,0.2);
    }
    .product-grid-card:hover .product-image {
        transform: scale(1.1);
    }
    .overlay {
        background: linear-gradient(135deg, rgba(0,0,0,0.7) 0%, rgba(0,0,0,0.5) 100%);
        transition: all 0.3s ease;
        opacity: 0;
        backdrop-filter: blur(2px);
    }
    .product-grid-card:hover .overlay {
        opacity: 1;
    }
    .product-title {
        font-size: 1rem;
        line-height: 1.3;
        text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        max-width: 100%;
        overflow: hidden;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
    }
    .btn-detail {
        background: linear-gradient(135deg, #e8b535 0%, #f4c842 100%);
        color: #fff;
        border: none;
        font-weight: 600;
        font-size: 0.9rem;
        transition: all 0.3s ease;
        box-shadow: 0 4px 15px rgba(232, 181, 53, 0.3);
    }
    .btn-detail:hover {
        background: linear-gradient(135deg, #f4c842 0%, #e8b535 100%);
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(232, 181, 53, 0.4);
    }
    .carousel-item:not(.active) {
        display: none;
    }
    .carousel-item.active .product-grid-card {
        animation: fadeInUp 0.6s ease forwards;
        opacity: 0;
        transform: translateY(30px);
    }
    .carousel-item.active .product-grid-card:nth-child(1) { animation-delay: 0.1s; }
    .carousel-item.active .product-grid-card:nth-child(2) { animation-delay: 0.2s; }
    .carousel-item.active .product-grid-card:nth-child(3) { animation-delay: 0.3s; }
    .carousel-item.active .product-grid-card:nth-child(4) { animation-delay: 0.4s; }
    .carousel-item.active .product-grid-card:nth-child(5) { animation-delay: 0.5s; }
    .carousel-item.active .product-grid-card:nth-child(6) { animation-delay: 0.6s; }
    .carousel-item.active .product-grid-card:nth-child(7) { animation-delay: 0.7s; }
    .carousel-item.active .product-grid-card:nth-child(8) { animation-delay: 0.8s; }

    @keyframes fadeInUp {
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    .carousel:hover {
        animation-play-state: paused;
    }

    /* === [START] KODE BARU UNTUK TOMBOL CAROUSEL === */

    /* Gaya dasar untuk kedua tombol */
    .custom-carousel-control {
        /* background-color: rgba(0, 0, 0, 0.5); Warna latar belakang hitam transparan */
        width: 50px;
        height: 50px;
        border-radius: 50%; /* Membuat tombol menjadi bulat */
        top: 50%;
        transform: translateY(-50%); /* Memastikan posisi vertikal di tengah */
        opacity: 0.7;
        transition: opacity 0.2s ease, background-color 0.2s ease;
    }

    /* Efek saat kursor di atas tombol */
    /* .custom-carousel-control:hover {
        background-color: rgba(0, 0, 0, 0.8); /* Warna lebih pekat saat hover */
        /* opacity: 1;
     } */

    /* Mengatur posisi tombol PREV ke KIRI LUAR */
    .custom-carousel-control.carousel-control-prev {
        left: -25px; /* Pindahkan ke kiri (sesuaikan nilainya jika perlu) */
    }

    /* Mengatur posisi tombol NEXT ke KANAN LUAR */
    .custom-carousel-control.carousel-control-next {
        right: -25px; /* Pindahkan ke kanan (sesuaikan nilainya jika perlu) */
    }

    /* Mengubah warna ikon panah menjadi PUTIH */
    .carousel-control-prev-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23666666'%3e%3cpath d='M11.354 1.646a.5.5 0 0 1 0 .708L5.707 8l5.647 5.646a.5.5 0 0 1-.708.708l-6-6a.5.5 0 0 1 0-.708l6-6a.5.5 0 0 1 .708 0z'/%3e%3c/svg%3e");
    }

    .carousel-control-next-icon {
      background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16' fill='%23666666'%3e%3cpath d='M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z'/%3e%3c/svg%3e");
    }


    @media (max-width: 768px) {
        .product-grid-card {
            height: 150px;
        }

        /* Menyesuaikan posisi tombol di layar lebih kecil */
        .custom-carousel-control.carousel-control-prev {
            left: -10px;
        }
        .custom-carousel-control.carousel-control-next {
            right: -10px;
        }
        
        .product-title {
            font-size: 0.9rem;
        }
        .btn-detail {
            font-size: 0.8rem;
            padding: 0.5rem 1rem;
        }
        .section-title {
            font-size: 2rem;
        }
    }

    @media (max-width: 576px) {
        .carousel-control-prev,
        .carousel-control-next {
            display: none; /* Sembunyikan tombol di layar sangat kecil */
        }
        .custom-indicators {
            bottom: -2rem;
        }
    }
    
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const carousel = document.getElementById('digitalPrintingCarousel');
    
    if (carousel) {
        // Initialize Bootstrap carousel with custom options
        // const bsCarousel = new bootstrap.Carousel(carousel, {
        //     interval: 5000,
        //     ride: 'carousel',
        //     pause: 'hover',
        //     wrap: true,
        //     keyboard: true,
        //     touch: true
        // });

        // Add slide event listeners for better UX
        carousel.addEventListener('slide.bs.carousel', function (e) {
            console.log('Sliding to slide:', e.to);
        });

        carousel.addEventListener('slid.bs.carousel', function (e) {
            console.log('Slid to slide:', e.to);
            
            // Trigger animation for new active slide
            const activeSlide = carousel.querySelector('.carousel-item.active');
            if (activeSlide) {
                const cards = activeSlide.querySelectorAll('.product-grid-card');
                cards.forEach((card, index) => {
                    card.style.animationDelay = (index * 0.1) + 's';
                });
            }
        });

        // Pause carousel when user interacts with products
        const productCards = carousel.querySelectorAll('.product-grid-card');
        productCards.forEach(card => {
            card.addEventListener('mouseenter', () => {
                bsCarousel.pause();
            });
            
            card.addEventListener('mouseleave', () => {
                bsCarousel.cycle();
            });
        });

        // Touch/Swipe support for mobile
        let startX = null;
        let currentX = null;
        
        carousel.addEventListener('touchstart', function(e) {
            startX = e.touches[0].clientX;
        });
        
        carousel.addEventListener('touchmove', function(e) {
            if (!startX) return;
            currentX = e.touches[0].clientX;
        });
        
        carousel.addEventListener('touchend', function(e) {
            if (!startX || !currentX) return;
            
            const diffX = startX - currentX;
            
            if (Math.abs(diffX) > 50) { // Minimum swipe distance
                if (diffX > 0) {
                    bsCarousel.next(); // Swipe left - next slide
                } else {
                    bsCarousel.prev(); // Swipe right - previous slide
                }
            }
            
            startX = null;
            currentX = null;
        });

        // Intersection Observer for performance
        if ('IntersectionObserver' in window) {
            const observer = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        bsCarousel.cycle(); // Start cycling when visible
                    } else {
                        bsCarousel.pause(); // Pause when not visible
                    }
                });
            }, { threshold: 0.5 });

            observer.observe(carousel);
        }
    }
});
</script>