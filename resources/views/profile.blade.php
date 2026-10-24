{{-- Menggunakan kerangka dari layout 'guest' --}}
@extends('layouts.guest')

{{-- Menetapkan judul spesifik untuk halaman ini --}}
@section('title', 'Profil - Oscar Multimedia')

{{-- Memulai bagian konten yang akan diisi --}}
@section('content')

{{-- CSS yang spesifik untuk halaman profil ini --}}
<style>
    .profile-container {
        max-width: 800px;
        margin: 0 auto;
    }
    .profile-logo {
        max-width: 180px;
        height: auto;
        margin-bottom: 1.25rem;
    }
    .profile-content p {
        max-width: 720px;
        margin-left: auto;
        margin-right: auto;
        text-align: justify;
        line-height: 1.8;
        color: #495057;
        font-size: 1.05rem;
    }
</style>

<div class="container text-center px-3 px-md-4 py-3 py-md-4 profile-container">
    {{-- Logo --}}
    @if ($profile && $profile->logo)
        <img src="{{ cloudinary_url($profile->logo, 'f_auto,q_auto,w_250') }}" alt="Oscar Multimedia" class="profile-logo" width="180" height="60" loading="lazy" decoding="async">
    @else
        <img src="{{ asset('logo_oscar_old.png') }}" alt="Oscar Multimedia" class="profile-logo" width="180" height="60" loading="lazy" decoding="async">
    @endif

    {{-- Judul Profil --}}
    <h2 class="fw-bold mb-3" style="color: #e8b535;">{{ $profile->judul ?? 'Oscar Multimedia' }}</h2>

    {{-- Konten Profil --}}
    <div class="profile-content mt-3">
        <p>{!! nl2br(e($profile->konten ?? 'Profil perusahaan belum diatur.')) !!}</p>
    </div>
</div>

@endsection