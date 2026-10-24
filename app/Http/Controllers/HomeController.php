<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index()
    {
        // 1. Popup Aktif dari Cache
        $activePopup = Cache::remember('site_active_popup', 3600, function () {
            return Popup::where('is_active', true)->first();
        });
        
        // 2. Kategori dari Cache (menghindari 4 query database)
        $categories = Cache::remember('site_kategoris', 3600, function () {
            return Kategori::all();
        });

        // Pencarian in-memory tanpa query tambahan ke database
        $kategoriDesain   = $categories->first(fn($k) => stripos($k->nama_kategori, 'Desain') !== false) ?? $categories->firstWhere('id', 1);
        $kategoriPrinting = $categories->first(fn($k) => stripos($k->nama_kategori, 'Printing') !== false) ?? $categories->firstWhere('id', 2);
        $kategoriComputer = $categories->first(fn($k) => stripos($k->nama_kategori, 'Computer') !== false || stripos($k->nama_kategori, 'Komputer') !== false) ?? $categories->firstWhere('id', 3);

        $desainId    = $kategoriDesain?->id;
        $printingId  = $kategoriPrinting?->id;
        $computerId  = $kategoriComputer?->id;
        
        $desainNama    = $kategoriDesain?->nama_kategori ?? 'Desain';
        $printingNama  = $kategoriPrinting?->nama_kategori ?? 'Digital Printing';
        $computerNama  = $kategoriComputer?->nama_kategori ?? 'Computer';

        // 3. Section Digital Printing dengan caching
        $digitalPrintingProducts = $printingId 
            ? Cache::remember('home_printing_' . $printingId, 1800, fn() => 
                Produk::with('kategori')->where('kategori_id', $printingId)->latest()->take(24)->get()
              ) 
            : collect();

        // 4. Highlighted Products dengan caching
        $highlightedProducts = Cache::remember('home_highlighted', 1800, fn() => 
            Produk::with('kategori')->latest()->take(4)->get()
        );
        $highlightProduct    = $highlightedProducts->first();

        // 5. Carousel Banner Products dengan caching
        $recentProducts = Cache::remember('home_recent_photos', 1800, fn() => 
            Produk::with('kategori')->whereNotNull('foto')->latest()->take(6)->get()
        );

        $carouselProducts = $recentProducts->isNotEmpty() ? $recentProducts : $highlightedProducts;

        // 6. Section Desain dengan caching
        $desainProducts = $desainId 
            ? Cache::remember('home_desain_' . $desainId, 1800, fn() => 
                Produk::with('kategori')->where('kategori_id', $desainId)->latest()->take(16)->get()
              ) 
            : collect();

        return view('home', [
            'activePopup'             => $activePopup,
            'carouselProducts'        => $carouselProducts,
            'desainProducts'          => $desainProducts,
            'digitalPrintingProducts' => $digitalPrintingProducts,
            'highlightedProducts'     => $highlightedProducts,
            'highlightProduct'        => $highlightProduct,
            'desainId'                => $desainId,
            'printingId'              => $printingId,
            'computerId'              => $computerId,
            'desainNama'              => $desainNama,
            'printingNama'            => $printingNama,
            'computerNama'            => $computerNama,
            'kategoris'               => $categories
        ]);
    }
}
