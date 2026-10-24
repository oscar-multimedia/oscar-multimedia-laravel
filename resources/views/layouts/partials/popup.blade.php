@if(isset($activePopup) && $activePopup)
    <div id="infoPopupOverlay" class="popup-overlay" role="dialog" aria-modal="true" aria-label="Informasi Penting">
        <div class="popup-content-image">
            <button id="closePopupBtn" class="popup-close-btn" type="button" aria-label="Tutup Informasi Penting">&times;</button>

            <img src="{{ cloudinary_url($activePopup->image_path, 'f_auto,q_auto,w_600,c_limit') }}" 
                 alt="Informasi Penting" 
                 class="popup-image" 
                 width="600" 
                 height="400" 
                 loading="eager" 
                 fetchpriority="high" 
                 decoding="async">
        </div>
    </div>
@endif

<style>
    .popup-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background-color: rgba(0, 0, 0, 0.75);
        display: flex;
        justify-content: center;
        align-items: center;
        z-index: 9999;
        padding: 20px;
        opacity: 0;
        pointer-events: none;
        transition: opacity 0.25s ease;
    }

    .popup-overlay.show {
        opacity: 1;
        pointer-events: auto;
    }

    .popup-content-image {
        position: relative;
        background: transparent;
        padding: 0;
        border-radius: 10px;
        max-width: 90vw;
        max-height: 85vh;
        width: min(600px, 90vw);
        aspect-ratio: 600 / 400;
        contain: layout paint;
    }

    .popup-image {
        display: block;
        width: 100%;
        height: 100%;
        aspect-ratio: 600 / 400;
        max-width: 100%;
        max-height: 85vh;
        object-fit: contain;
        margin: 0 auto;
        border-radius: 10px;
        box-shadow: 0 5px 25px rgba(0, 0, 0, 0.4);
    }

    .popup-close-btn {
        position: absolute;
        top: -18px;
        right: -18px;
        width: 40px;
        height: 40px;
        background-color: #fff;
        border: none;
        border-radius: 50%;
        font-size: 24px;
        font-weight: bold;
        color: #333;
        cursor: pointer;
        display: flex;
        justify-content: center;
        align-items: center;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.3);
        z-index: 10;
    }
</style>