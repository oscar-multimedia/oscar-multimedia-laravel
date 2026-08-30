<?php

namespace App\Http\Controllers;

use App\Models\Kategori; // DITAMBAHKAN: Import model Kategori
use Illuminate\Http\Request;
use App\Models\Produk;
use Illuminate\Support\Facades\Storage;

class ProdukController extends Controller
{
    public function index()
    {
        // DITAMBAHKAN: with('kategori') untuk Eager Loading (lebih efisien)
        $produks = Produk::with('kategori')->latest()->paginate(10);
        // DITAMBAHKAN: Ambil semua kategori untuk form tambah/edit
        $kategoris = Kategori::all();

        return view('admin.produk.index', compact('produks', 'kategoris'));
    }

    public function store(Request $request)
    {
        // DIUBAH: Validasi sekarang menggunakan 'kategori_id'
        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|integer|exists:kategoris,id', // Cek apakah ID kategori ada di tabel kategoris
            'harga' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:10240', // Tambahkan batas ukuran file
        ]);

        if (empty($data['harga'])) {
            unset($data['harga']);
        }

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('produk', 'cloudinary');
        }

        Produk::create($data);

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function update(Request $request, Produk $produk)
    {
        // DIUBAH: Validasi sekarang menggunakan 'kategori_id'
        $data = $request->validate([
            'nama_produk' => 'required|string|max:255',
            'kategori_id' => 'required|integer|exists:kategoris,id',
            'harga' => 'nullable|integer',
            'deskripsi' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        if (empty($data['harga'])) {
            $data['harga'] = $data['harga'] ?? 0;
        }

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
        // DIUBAH: Mengambil data dari tabel Kategori langsung
        $kategoris = Kategori::all();

        $query = Produk::query();

        // DIUBAH: Filter berdasarkan 'kategori_id'
        if ($request->filled('kategori')) {
            $query->where('kategori_id', $request->kategori);
        }

        if ($request->filled('search')) {
            $query->where('nama_produk', 'like', '%' . $request->search . '%');
        }

        $produks = $query->latest()->get();

        return view('produk', compact('produks', 'kategoris'));
    }

    public function show(Produk $produk)
    {
        return view('detail', compact('produk'));
    }
}