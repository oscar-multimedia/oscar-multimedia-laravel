@if(isset($activePopup) && $activePopup)
    <div id="infoPopupOverlay" class="popup-overlay">
        <div class="popup-content-image">
            <button id="closePopupBtn" class="popup-close-btn">&times;</button>

            <img src="{{ cloudinary_url($activePopup->image_path) }}" alt="Informasi Penting" class="popup-image">
        </div>
    </div>
@endif

<style>
    .popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.75);
    display: none; /* Disembunyikan secara default */
    justify-content: center;
    align-items: center;
    z-index: 9999;
    padding: 20px;
}

.popup-content-image {
    position: relative;
    background: transparent;
    padding: 0;
    border-radius: 10px; /* Opsional, jika gambar punya border */
}

.popup-image {
    display: block;
    max-width: 90vw; /* Lebar maksimal 90% dari lebar layar */
    max-height: 85vh; /* Tinggi maksimal 85% dari tinggi layar */
    width: auto;
    height: auto;
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