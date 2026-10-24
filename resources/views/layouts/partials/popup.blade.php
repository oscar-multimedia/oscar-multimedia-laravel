@if(isset($activePopup) && $activePopup)
    @php
        $popupImageUrl = cloudinary_url($activePopup->image_path, 'f_webp,q_auto:eco,w_440,c_limit');
    @endphp

    @push('preload')
        <link rel="preload" as="image" href="{{ $popupImageUrl }}" fetchpriority="high">
    @endpush

    <div id="infoPopupOverlay" class="popup-overlay" role="dialog" aria-modal="true" aria-label="Informasi Penting">
        <div class="popup-content-image">
            <button id="closePopupBtn" class="popup-close-btn" type="button" aria-label="Tutup Informasi Penting">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                    <path d="M2.146 2.854a.5.5 0 1 1 .708-.708L8 7.293l5.146-5.147a.5.5 0 0 1 .708.708L8.707 8l5.147 5.146a.5.5 0 0 1-.708.708L8 8.707l-5.146 5.147a.5.5 0 0 1-.708-.708L7.293 8z"/>
                </svg>
            </button>

            <img src="{{ $popupImageUrl }}" 
                 alt="Informasi Penting" 
                 class="popup-image" 
                 width="440" 
                 height="440" 
                 loading="eager" 
                 fetchpriority="high" 
                 decoding="async">
        </div>
    </div>
@endif

<style>
    .popup-overlay {
        position: fixed;
        inset: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(15, 23, 42, 0.72);
        backdrop-filter: blur(6px);
        -webkit-backdrop-filter: blur(6px);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        padding: 16px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .popup-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .popup-content-image {
        position: relative;
        background: #ffffff;
        border-radius: 16px;
        box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.5), 0 0 0 1px rgba(255, 255, 255, 0.15);
        overflow: hidden;
        width: min(480px, 90vw);
        max-width: 90vw;
        max-height: 85vh;
        aspect-ratio: 1 / 1;
        display: flex;
        align-items: center;
        justify-content: center;
        transform: scale(0.92) translateY(12px);
        transition: transform 0.28s cubic-bezier(0.16, 1, 0.3, 1);
    }

    .popup-overlay.show .popup-content-image {
        transform: scale(1) translateY(0);
    }

    .popup-image {
        display: block;
        width: 100%;
        height: 100%;
        aspect-ratio: 1 / 1;
        max-width: min(480px, 90vw);
        max-height: 85vh;
        object-fit: contain;
    }

    .popup-close-btn {
        position: absolute;
        top: 14px;
        right: 14px;
        width: 38px;
        height: 38px;
        background: #e8b535;
        color: #ffffff;
        border: 2px solid #c4951d;
        border-radius: 50%;
        font-size: 15px;
        font-weight: bold;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
        z-index: 20;
        box-shadow: 0 4px 14px rgba(0, 0, 0, 0.22), 0 2px 8px rgba(232, 181, 53, 0.4);
    }

    .popup-close-btn:hover {
        background: #d4a32b;
        color: #ffffff;
        border-color: #a87610;
        transform: scale(1.12) rotate(90deg);
        box-shadow: 0 6px 22px rgba(212, 163, 43, 0.6);
    }

    .popup-close-btn:active {
        transform: scale(0.95) rotate(90deg);
    }
</style>