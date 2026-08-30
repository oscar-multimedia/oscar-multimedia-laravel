@extends('layouts.app')

@section('title', 'Profile')

@section('content')
<div class="py-2">
    <h3 class="mb-4">Pengaturan Halaman Profile</h3>

    <form action="{{ route('admin.profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Judul</label>
            <input type="text" name="judul" class="form-control" value="{{ old('judul', $profile->judul ?? '') }}">
        </div>

        <div class="mb-3">
            <label>Konten</label>
            <textarea name="konten" class="form-control" rows="7">{{ old('konten', $profile->konten ?? '') }}</textarea>
        </div>

        <div class="mb-3">
            <label>Logo</label>
            <input type="file" name="logo" class="form-control">
            @if (!empty($profile->logo))
                <img src="{{ cloudinary_url($profile->logo) }}" alt="Logo" width="150" class="mt-3 mb-3">
            @endif
        </div>

        <button type="submit" class="btn btn-primary">Simpan</button>
    </form>
</div>
@endsection