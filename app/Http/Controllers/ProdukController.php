<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        $produks = Produk::with('kategori')->latest()->paginate(10);
        $kategoris = Kategori::all();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|integer|exists:kategoris,id',
            'harga' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'foto.max' => 'Ukuran foto maksimal adalah 5MB.',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
        ]);

        $data['harga'] = !empty($data['harga']) ? (int)$data['harga'] : 0;

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'cloudinary');
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, Produk $produk)
    {
        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|integer|exists:kategoris,id',
            'harga' => 'nullable|numeric|min:0',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:5120',
        ], [
            'foto.max' => 'Ukuran foto maksimal adalah 5MB.',
            'foto.mimes' => 'Format foto harus jpeg, png, jpg, atau webp.',
        ]);

        $data['harga'] = !empty($data['harga']) ? (int)$data['harga'] : 0;

        if ($request->hasFile('foto')) {
            if ($produk->foto) {
                Storage::disk('cloudinary')->delete($produk->foto);
            }
            $data['foto'] = $request->file('foto')->store('produk', 'cloudinary');
        }

        $produk->update($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui');
    }

    public function destroy(Produk $produk)
    {
        if ($produk->foto) {
            Storage::disk('cloudinary')->delete($produk->foto);
        }
        $produk->delete();
        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus');
    }

    public function katalog(Request $request)
    {
        $kategoris = Kategori::all();

        $query = Produk::with('kategori');

        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $searchTerm = trim($request->search);
            $query->where('nama_produk', 'like', '%' . addcslashes($searchTerm, '%_') . '%');
        }

        // Terapkan pagination 12 produk per halaman dengan query string terjaga
        $produks = $query->latest()->paginate(12)->withQueryString();

        return view('produk', compact('produks', 'kategoris'));
    }

    public function show(Produk $produk)
    {
        $produk->loadMissing('kategori');
        return view('detail', compact('produk'));
    }
}