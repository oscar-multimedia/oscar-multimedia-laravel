<?php

namespace App\Http\Controllers;

use App\Models\Produk;
use App\Models\Kategori;
use App\Models\Popup;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class HomeController extends Controller
{
    public function index()
    {
        $activePopup = Popup::where('is_active', true)->first();
        
        // Cari kategori berdasarkan nama secara fleksibel dengan fallback
        $kategoriDesain   = Kategori::where('nama_kategori', 'like', '%Desain%')->first() ?? Kategori::find(1);
        $kategoriPrinting = Kategori::where('nama_kategori', 'like', '%Printing%')->first() ?? Kategori::find(2);
        $kategoriComputer = Kategori::where('nama_kategori', 'like', '%Computer%')
                                    ->orWhere('nama_kategori', 'like', '%Komputer%')
                                    ->first() ?? Kategori::find(3);

        $desainId    = $kategoriDesain?->id;
        $printingId  = $kategoriPrinting?->id;
        $computerId  = $kategoriComputer?->id;
        
        $desainNama    = $kategoriDesain?->nama_kategori ?? 'Desain';
        $printingNama  = $kategoriPrinting?->nama_kategori ?? 'Digital Printing';
        $computerNama  = $kategoriComputer?->nama_kategori ?? 'Computer';

        // Section Digital Printing (eager loading & bounded query)
        $digitalPrintingProducts = $printingId 
            ? Produk::with('kategori')->where('kategori_id', $printingId)->latest()->take(24)->get() 
            : collect();

        // Highlighted Products (1 query, reuse first() for highlightProduct)
        $highlightedProducts = Produk::with('kategori')->latest()->take(4)->get();
        $highlightProduct    = $highlightedProducts->first();

        // Carousel Banner Products (Eager loading to prevent N+1)
        $categories = Kategori::all();
        $carouselProducts = new Collection();

        // Ambil produk terbaru yang memiliki foto untuk ditampilkan di banner
        $recentProducts = Produk::with('kategori')
            ->whereNotNull('foto')
            ->latest()
            ->take(6)
            ->get();

        if ($recentProducts->isNotEmpty()) {
            $carouselProducts = $recentProducts;
        } else {
            $carouselProducts = $highlightedProducts;
        }

        // Section Desain
        $desainProducts = $desainId 
            ? Produk::with('kategori')->where('kategori_id', $desainId)->latest()->take(16)->get() 
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
