{{-- Memberi tahu Laravel untuk menggunakan layout 'guest' --}}
@extends('layouts.guest')

{{-- (Opsional) Mengisi judul halaman spesifik --}}
@section('title', 'Oscar Multimedia')

{{-- Mengisi bagian 'content' yang sudah kita siapkan di layout --}}
@section('content')
    @include('layouts.partials.popup')

    @include('layouts.partials.topbar-lading')

    @include('layouts.partials.highlight-product')

    @include('layouts.partials.digital-printing')

    @include('layouts.partials.desain-grafis')

    @include('layouts.partials.jasa-komputer')

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const popupOverlay = document.getElementById('infoPopupOverlay');
        const closePopupBtn = document.getElementById('closePopupBtn');

        if (popupOverlay) {
            popupOverlay.classList.add('show');
        }

        // Fungsi untuk menutup pop-up
        function closePopup() {
            if (popupOverlay) {
                popupOverlay.classList.remove('show');
            }
        }

        // Tambahkan event listener untuk tombol close
        if (closePopupBtn) {
            closePopupBtn.addEventListener('click', closePopup);
        }

        // Tutup pop-up saat mengklik area overlay
        if (popupOverlay) {
            popupOverlay.addEventListener('click', function(event) {
                if (event.target === popupOverlay) {
                    closePopup();
                }
            });

            // Tutup pop-up saat tombol Escape ditekan
            document.addEventListener('keydown', function(event) {
                if (event.key === 'Escape' && popupOverlay.classList.contains('show')) {
                    closePopup();
                }
            });
        }
    });
</script>
@endpush    