<?php

namespace App\Http\Controllers;

use App\Models\Kontak;
use Illuminate\Http\Request;

class KontakController extends Controller
{
    // Menampilkan form edit kontak di dashboard admin
    public function form()
    {
        $kontak = Kontak::first(); // hanya satu record
        return view('admin.kontak.index', compact('kontak'));
    }

    // public view
    public function show()
    {
        $kontak = \Illuminate\Support\Facades\Cache::remember('site_kontak', 3600, function () {
            return Kontak::first();
        });
        return view('kontak', compact('kontak'));
    }

    // Menyimpan atau update data kontak
    public function storeOrUpdate(Request $request)
    {
        $request->validate([
            'alamat' => 'required',
            'email' => 'required|email',
            'maps_link' => 'nullable|url',
            'whatsapp_link' => 'nullable|url',
        ]);

        Kontak::updateOrCreate(
            ['id' => 1], // paksa hanya 1 record yang boleh ada
            [
                'alamat' => $request->alamat,
                'email' => $request->email,
                'maps_link' => $request->maps_link,
                'whatsapp_link' => $request->whatsapp_link,
            ]
        );

        \Illuminate\Support\Facades\Cache::forget('site_kontak');

        return redirect()->route('admin.kontak.index')->with('success', 'Data kontak berhasil disimpan!');
    }
}
