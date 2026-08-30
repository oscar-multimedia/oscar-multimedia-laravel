<?php

namespace App\Http\Controllers;

use App\Models\Profile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function form()
    {
        $profile = Profile::first(); // hanya satu record
        return view('admin.profile.index', compact('profile'));
    }
    
    public function show()
    {
        $profile = Profile::first(); // ambil 1 record
        return view('profile', compact('profile'));
    }

    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'konten' => 'required',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg,ico|max:2048'
        ]);

        $data = [
            'judul' => $request->judul,
            'konten' => $request->konten,
        ];

        $profile = Profile::first();

        if ($request->hasFile('logo')) {
            // Hapus logo lama dari Cloudinary jika ada
            if ($profile && $profile->logo) {
                Storage::disk('cloudinary')->delete($profile->logo);
            }
            
            // Upload logo baru ke Cloudinary
            $logoPath = $request->file('logo')->store('logo', 'cloudinary');
            $data['logo'] = $logoPath;
        }

        Profile::updateOrCreate(['id' => 1], $data);

        return redirect()->route('admin.profile.index')->with('success', 'Profil berhasil diperbarui!');
    }
}
