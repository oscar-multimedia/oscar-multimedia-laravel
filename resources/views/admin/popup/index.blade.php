@extends('layouts.app') {{-- Sesuaikan dengan nama file layout utama Anda --}}

@section('title', 'Manajemen Pop-up')

@section('content')
<h3 class="mb-4">Manajemen Pop-up</h3>

{{-- 1. FORM UNGGAH GAMBAR BARU --}}
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-light fw-bold">
        Unggah Pop-up Baru
    </div>
    <div class="card-body">
        <form action="{{ route('admin.popup.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="image" class="form-label">Pilih Gambar (Max: 2MB, format: jpg, png, webp)</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image" required>
                @error('image')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <button type="submit" class="btn btn-primary"><i class="bi bi-upload me-2"></i>Unggah</button>
        </form>
    </div>
</div>

{{-- 2. POP-UP YANG AKTIF SAAT INI --}}
<div class="card shadow-sm border-0 rounded-3 mb-4">
    <div class="card-header bg-success text-white fw-bold">
        Pop-up Aktif Saat Ini
    </div>
    <div class="card-body text-center">
        @if ($activePopup)
            <p class="text-muted">Ini adalah gambar yang akan muncul sebagai pop-up di halaman pengunjung.</p>
            <img src="{{ cloudinary_url($activePopup->image_path) }}" alt="Pop-up Aktif" class="img-fluid rounded shadow" style="max-height: 300px;">
        @else
            <p class="my-4">Saat ini tidak ada pop-up yang aktif.</p>
        @endif
    </div>
</div>

{{-- 3. RIWAYAT POP-UP --}}
<div class="card shadow-sm border-0 rounded-3">
    <div class="card-header bg-light fw-bold">
        Riwayat Pop-up
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead>
                    <tr>
                        <th scope="col">Preview</th>
                        <th scope="col">Path File</th>
                        <th scope="col">Status</th>
                        <th scope="col" class="text-end">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($popups as $popup)
                        <tr>
                            <td>
                                <img src="{{ cloudinary_url($popup->image_path) }}" alt="Preview" width="150" class="img-thumbnail">
                            </td>
                            <td><code>{{ $popup->image_path }}</code></td>
                            <td>
                                @if ($popup->is_active)
                                    <span class="badge bg-success">Aktif</span>
                                @else
                                    <span class="badge bg-secondary">Tidak Aktif</span>
                                @endif
                            </td>
                            <td class="text-end">
                                {{-- Tombol Aktifkan --}}
                                @if (!$popup->is_active)
                                    <form action="{{ route('admin.popup.setActive', $popup->id) }}" method="POST" class="d-inline-block me-1">
                                        @csrf
                                        <button type="submit" class="btn btn-sm btn-outline-success" title="Jadikan Aktif">
                                            <i class="bi bi-check-circle"></i> Aktifkan
                                        </button>
                                    </form>
                                @endif

                                {{-- Tombol Hapus --}}
                                <form action="{{ route('admin.popup.destroy', $popup->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Anda yakin ingin menghapus gambar ini secara permanen?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-outline-danger" title="Hapus">
                                        <i class="bi bi-trash"></i> Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="4" class="text-center py-4">Belum ada gambar pop-up yang diunggah.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection