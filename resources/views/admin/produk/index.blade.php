@extends('layouts.app')

@section('title', 'Produk')

@section('content')
<div class="py-2">
    <h3 class="mb-4">Data Produk Oscar Multimedia</h3>

    {{-- Tombol Tambah --}}
    <button class="btn btn-primary mb-3" data-bs-toggle="modal" data-bs-target="#createModal">
        + Tambah Produk
    </button>

    {{-- Tabel Produk --}}
    <div class="table-responsive">
        <table class="table table-hover">
            <thead>
                <tr>
                    <th>No</th>
                    <th>Foto</th>
                    <th>Nama Produk</th>
                    <th>Kategori</th>
                    <th>Harga</th>
                    <th>Deskripsi</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                {{-- MENGGUNAKAN @forelse untuk menangani data kosong --}}
                @forelse ($produks as $produk)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>
                        @if ($produk->foto)
                            <img src="{{ cloudinary_url($produk->foto) }}" class="img-thumbnail" style="max-width: 100px;">
                        @else
                            <span class="text-muted fst-italic">Belum ada foto</span>
                        @endif
                    </td>
                    <td>{{ $produk->nama_produk }}</td>
                    {{-- DIPERBAIKI: Menggunakan relasi untuk menampilkan nama kategori --}}
                    <td>{{ $produk->kategori->nama_kategori ?? 'Tidak ada kategori' }}</td>
                    <td>Rp {{ number_format($produk->harga, 0, ',', '.') }}</td>
                    <td>{{ $produk->deskripsi }}</td>
                    <td>
                        <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                            data-bs-target="#editModal{{ $produk->id }}">Edit</button>

                        <form action="{{ route('admin.produk.destroy', $produk) }}" method="POST" class="d-inline"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>

                {{-- Modal Edit (Kode ini sudah benar karena ada di dalam loop) --}}
                <div class="modal fade" id="editModal{{ $produk->id }}" tabindex="-1">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <form method="POST" action="{{ route('admin.produk.update', $produk) }}"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                <div class="modal-header">
                                    <h5 class="modal-title">Edit Produk</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mb-2">
                                        <label>Nama Produk</label>
                                        <input type="text" name="nama_produk" class="form-control"
                                            value="{{ $produk->nama_produk }}" required>
                                    </div>
                                    <div class="mb-2">
                                        <label>Kategori</label>
                                        <select name="kategori_id" class="form-select" required>
                                            @foreach ($kategoris as $kategori)
                                                <option value="{{ $kategori->id }}" {{ $produk->kategori_id == $kategori->id ? 'selected' : '' }}>
                                                    {{ $kategori->nama_kategori }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-2">
                                        <label>Harga</label>
                                        <input type="number" name="harga" class="form-control"
                                            value="{{ $produk->harga }}">
                                    </div>
                                    <div class="mb-2">
                                        <label>Deskripsi</label>
                                        <textarea name="deskripsi" class="form-control">{{ $produk->deskripsi }}</textarea>
                                    </div>
                                    <div class="mb-2">
                                        <label>Ganti Foto</label>
                                        <input type="file" name="foto" class="form-control">
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-primary">Simpan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                @empty
                <tr>
                    <td colspan="7" class="text-center">Belum ada data produk.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="d-flex justify-content-between align-items-center mt-4">
        {{-- Info di kiri --}}
        <div class="pagination-info">
            @if($produks->total() > 0)
                <span class="text-muted small">
                    Showing {{ $produks->firstItem() }} to {{ $produks->lastItem() }} of {{ $produks->total() }} entries
                </span>
            @else
                <span class="text-muted small">No entries found</span>
            @endif
        </div>
        
        {{-- Pagination di kanan --}}
        <div class="pagination-nav">
            @if($produks->hasPages())
                {{ $produks->appends(request()->query())->links('pagination::bootstrap-4') }}
            @endif
        </div>
    </div>
</div>

{{-- Modal Tambah --}}
<div class="modal fade" id="createModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" action="{{ route('admin.produk.store') }}" enctype="multipart/form-data">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Produk</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-2">
                        <label>Nama Produk</label>
                        <input type="text" name="nama_produk" class="form-control" required placeholder="Masukkan nama produk">
                    </div>
                    <div class="mb-2">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-select" required>
                            {{-- DITAMBAHKAN: Opsi default --}}
                            <option value="" disabled selected>-- Pilih Kategori --</option>
                            @foreach ($kategoris as $kategori)
                                {{-- DIPERBAIKI: Menghapus logika perbandingan dengan $produk --}}
                                <option value="{{ $kategori->id }}">
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-2">
                        <label>Harga</label>
                        <input type="number" name="harga" class="form-control" placeholder="Masukkan harga">
                    </div>
                    <div class="mb-2">
                        <label>Deskripsi</label>
                        <textarea name="deskripsi" class="form-control" placeholder="Masukkan deskripsi singkat"></textarea>
                    </div>
                    <div class="mb-2">
                        <label>Foto</label>
                        <input type="file" name="foto" id="foto" class="form-control">
                        <img id="previewFoto" src="#" alt="Preview Foto" class="mt-2" style="max-width: 100%; display: none;"/>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- SCRIPT SUDAH BENAR --}}
<script>
    const inputFoto = document.getElementById('foto');
    const previewFoto = document.getElementById('previewFoto');

    inputFoto.addEventListener('change', function() {
        const file = this.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                previewFoto.src = e.target.result;
                previewFoto.style.display = 'block';
            }
            reader.readAsDataURL(file);
        } else {
            previewFoto.src = '#';
            previewFoto.style.display = 'none';
        }
    });
</script>
@endsection