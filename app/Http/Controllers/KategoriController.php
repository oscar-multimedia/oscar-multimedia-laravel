<?php

namespace App\Http\Controllers;

use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    public function index()
    {
        $kategori = Kategori::latest()->get();
        return view('admin.kategori.index', compact('kategori'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori',
        ]);

        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil ditambahkan.');
    }

    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => 'required|string|max:100|unique:kategoris,nama_kategori,' . $kategori->id,
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diupdate.');
    }

    public function destroy(Kategori $kategori)
    {
        if ($kategori->produks()->exists()) {
            return redirect()->route('admin.kategori.index')->with('error', 'Kategori "' . e($kategori->nama_kategori) . '" tidak dapat dihapus karena masih digunakan oleh produk.');
        }

        $kategori->delete();
        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil dihapus.');
    }
}
