{{-- Menggunakan kerangka dari layout 'guest' --}}
@extends('layouts.guest')

{{-- Menetapkan judul spesifik untuk halaman ini --}}
@section('title', 'Profil - Oscar Multimedia')

{{-- Memulai bagian konten yang akan diisi --}}
@section('content')

{{-- CSS yang spesifik untuk halaman profil ini --}}
<style>
    .profile-container {
        min-height: calc(100vh - 250px); /* Menjaga agar footer tetap di bawah */
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
    }
    .profile-logo {
        max-width: 200px;
        margin-bottom: 1rem;
    }
    .profile-content p {
        max-width: 700px;
        margin-left: auto;
        margin-right: auto;
        text-align: justify;
    }
</style>

<div class="container text-center px-4 my-5 profile-container">
    {{-- Logo --}}
    @if ($profile->logo)
        <img src="{{ cloudinary_url($profile->logo) }}" alt="Oscar Multimedia" class="profile-logo">
    @endif

    {{-- Judul Profil --}}
    <h2 class="fw-bold" style="color: #e8b535;">{!! $profile->judul !!}</h2>

    {{-- Konten Profil --}}
    <div class="profile-content mt-4">
        <p>{!! $profile->konten !!}</p>
    </div>
</div>

@endsection
{{-- Akhir dari bagian konten --}}