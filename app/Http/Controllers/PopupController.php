<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Popup; // Pastikan model Popup sudah dibuat
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PopupController extends Controller
{
    /**
     * Menampilkan halaman manajemen pop-up.
     */
    public function index()
    {
        $popups = Popup::latest()->get();
        $activePopup = Popup::where('is_active', true)->first();
        
        return view('admin.popup.index', compact('popups', 'activePopup'));
    }

    /**
     * Menyimpan gambar pop-up baru.
     */
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ], [
            'image.required' => 'Anda harus memilih sebuah gambar.',
            'image.image' => 'File yang diunggah harus berupa gambar.',
            'image.mimes' => 'Format gambar harus jpeg, png, jpg, gif, atau webp.',
            'image.max' => 'Ukuran gambar maksimal adalah 2MB.',
        ]);

        if ($request->hasFile('image')) {
            // Simpan gambar ke Cloudinary
            $path = $request->file('image')->store('popups', 'cloudinary');

            // Buat record baru di database
            Popup::create(['image_path' => $path]);

            return redirect()->route('admin.popup.index')->with('success', 'Gambar pop-up berhasil diunggah.');
        }

        return redirect()->route('admin.popup.index')->with('error', 'Gagal mengunggah gambar.');
    }

    /**
     * Mengatur sebuah pop-up menjadi aktif.
     */
    public function setActive(Popup $popup)
    {
        // Gunakan transaction untuk memastikan konsistensi data
        DB::transaction(function () use ($popup) {
            // 1. Nonaktifkan semua pop-up yang lain
            Popup::where('is_active', true)->update(['is_active' => false]);

            // 2. Aktifkan pop-up yang dipilih
            $popup->update(['is_active' => true]);
        });

        return redirect()->route('admin.popup.index')->with('success', 'Pop-up berhasil diaktifkan.');
    }

    /**
     * Menghapus gambar pop-up.
     */
    public function destroy(Popup $popup)
    {
        // Hapus file dari storage Cloudinary
        Storage::disk('cloudinary')->delete($popup->image_path);

        // Hapus record dari database
        $popup->delete();

        return redirect()->route('admin.popup.index')->with('success', 'Gambar pop-up berhasil dihapus.');
    }
}