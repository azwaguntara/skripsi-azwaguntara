@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">

        <h4 class="mb-4 fw-bold">Profil Pengguna</h4>

        <!-- PROFILE -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white" style="background:#1f2d3d;">
                <i class="bi bi-person"></i> Informasi Profil
            </div>
            <div class="card-body">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <!-- PASSWORD -->
        <div class="card shadow-sm mb-4">
            <div class="card-header text-white" style="background:#34495e;">
                <i class="bi bi-lock"></i> Ubah Password
            </div>
            <div class="card-body">
                @include('profile.partials.update-password-form')
            </div>
        </div>

        <!-- DELETE -->
        <div class="card shadow-sm">
            <div class="card-header text-white" style="background:#e74c3c;">
                <i class="bi bi-trash"></i> Hapus Akun
            </div>
            <div class="card-body">
                @include('profile.partials.delete-user-form')
            </div>
        </div>

    </div>
</div>

@endsection