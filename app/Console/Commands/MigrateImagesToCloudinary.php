<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Produk;
use App\Models\Popup;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\File;

class MigrateImagesToCloudinary extends Command
{
    protected $signature = 'app:migrate-images';
    protected $description = 'Mengunggah gambar lokal lama ke Cloudinary';

    public function handle()
    {
        $this->info('Memulai migrasi gambar Produk ke Cloudinary (SSL Bypassed)...');
        
        $cloudinary = new \Cloudinary\Cloudinary([
            'cloud' => [
                'cloud_name' => env('EXTERNAL_S3_CLOUDINARY_NAME'),
                'api_key' => env('EXTERNAL_S3_CLOUDINARY_API_KEY'),
                'api_secret' => env('EXTERNAL_S3_CLOUDINARY_API_SECRET'),
            ],
            'api' => [
                'verify' => false,
            ]
        ]);

        $produks = Produk::whereNotNull('foto')->get();
        foreach ($produks as $produk) {
            $localPath = storage_path('app/public/' . $produk->foto);
            if (!file_exists($localPath)) {
                $localPath = storage_path('app/public/backup/app/public/' . $produk->foto);
            }

            if (file_exists($localPath)) {
                $this->info("Mengunggah {$produk->foto}...");
                $result = $cloudinary->uploadApi()->upload($localPath, ['folder' => 'produk']);
                $newPath = $result['public_id']; // Cloudinary Laravel Storage uses public_id as path
                $produk->update(['foto' => $newPath]);
                $this->info("Berhasil! Path baru: {$newPath}");
            } else {
                $this->warn("File tidak ditemukan di lokal: {$produk->foto}");
            }
        }

        $this->info('Memulai migrasi gambar Pop-up ke Cloudinary...');
        
        $popups = Popup::whereNotNull('image_path')->get();
        foreach ($popups as $popup) {
            $localPath = storage_path('app/public/' . $popup->image_path);
            if (!file_exists($localPath)) {
                $localPath = storage_path('app/public/backup/app/public/' . $popup->image_path);
            }

            if (file_exists($localPath)) {
                $this->info("Mengunggah {$popup->image_path}...");
                $result = $cloudinary->uploadApi()->upload($localPath, ['folder' => 'popups']);
                $newPath = $result['public_id'];
                $popup->update(['image_path' => $newPath]);
                $this->info("Berhasil! Path baru: {$newPath}");
            } else {
                $this->warn("File tidak ditemukan di lokal: {$popup->image_path}");
            }
        }

        $this->info('Memulai migrasi Logo Profil ke Cloudinary...');
        
        $profiles = \App\Models\Profile::whereNotNull('logo')->get();
        foreach ($profiles as $profile) {
            $localPath = storage_path('app/public/' . $profile->logo);
            if (!file_exists($localPath)) {
                $localPath = storage_path('app/public/backup/app/public/' . $profile->logo);
            }

            if (file_exists($localPath)) {
                $this->info("Mengunggah {$profile->logo}...");
                $result = $cloudinary->uploadApi()->upload($localPath, ['folder' => 'logo']);
                $newPath = $result['public_id'];
                $profile->update(['logo' => $newPath]);
                $this->info("Berhasil! Path baru: {$newPath}");
            } else {
                $this->warn("File tidak ditemukan di lokal: {$profile->logo}");
            }
        }

        $this->info('Selesai!');
    }
}
