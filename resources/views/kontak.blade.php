{{-- Menggunakan kerangka dari layout 'guest' --}}
@extends('layouts.guest')

{{-- Menetapkan judul spesifik untuk halaman ini --}}
@section('title', 'Hubungi Kami - Oscar Multimedia')

{{-- Memulai bagian konten yang akan diisi --}}
@section('content')

{{-- CSS ini spesifik hanya untuk halaman kontak --}}
<style>
    .contact-container {
        max-width: 850px;
        margin: 0 auto;
    }

    .contact-card {
        background-color: #fff;
        border-radius: 14px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.04);
        border: 1px solid rgba(0,0,0,0.06);
        padding: 22px;
        transition: transform 0.25s ease, box-shadow 0.25s ease;
    }

    .contact-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px rgba(0,0,0,0.08);
    }

    .contact-title {
        font-weight: 700;
        color: #1a1a1a;
        margin-bottom: 0.6rem;
    }

    .contact-link {
        text-decoration: none;
        color: #2b59ff;
        font-weight: 500;
    }

    .contact-link:hover {
        text-decoration: underline;
    }
</style>

<div class="container py-3 py-md-4 contact-container">
    <h2 class="text-center fw-bold mb-4" style="color: #333;">Hubungi Kami</h2>
    
    <div class="row justify-content-center g-3 g-md-4">
        {{-- Alamat --}}
        <div class="col-12 col-md-10">
            <div class="contact-card">
                <h5 class="contact-title"><i class="bi bi-geo-alt-fill text-danger me-2"></i>Alamat</h5>
                <p class="mb-1 text-secondary">{{ $kontak->alamat ?? 'Alamat belum diatur' }}</p>
                @if(!empty($kontak?->maps_link))
                <p class="mb-0 mt-2">Maps: <a href="{{ $kontak->maps_link }}" class="contact-link" target="_blank" rel="noopener noreferrer">Buka Google Maps <i class="bi bi-box-arrow-up-right small"></i></a></p>
                @endif
            </div>
        </div>

        {{-- Email --}}
        <div class="col-12 col-md-10">
            <div class="contact-card">
                <h5 class="contact-title"><i class="bi bi-envelope-fill text-primary me-2"></i>Email</h5>
                <p class="mb-0 text-secondary">{{ $kontak->email ?? 'Email belum diatur' }}</p>
            </div>
        </div>

        {{-- Social Media --}}
        <div class="col-12 col-md-10">
            <div class="contact-card">
                <h5 class="contact-title"><i class="bi bi-phone-fill text-success me-2"></i>Social Media / WhatsApp</h5>
                <p class="mb-0">
                    @if(!empty($kontak?->whatsapp_link))
                        <a href="{{ $kontak->whatsapp_link }}" class="contact-link" target="_blank" rel="noopener noreferrer">
                            <i class="bi bi-whatsapp me-1 text-success"></i> Hubungi via WhatsApp
                        </a>
                    @else
                        <span class="text-muted">Nomor WhatsApp belum diatur</span>
                    @endif
                </p>
            </div>
        </div>
    </div>
</div>

@endsection