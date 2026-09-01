@extends('layouts.app')

@section('content')

<div class="row justify-content-center">
    <div class="col-12 col-md-10 col-lg-8">

        <!-- HEADER -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Edit User</h4>
                <p class="text-muted mb-0">
                    Perbarui informasi akun pengguna.
                </p>
            </div>

            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                <i class="bi bi-arrow-left"></i> Kembali
            </a>
        </div>

        <!-- FORM -->
        <div class="card shadow-sm">
            <div class="card-header text-white"
                style="background:#1f2d3d;">
                <i class="bi bi-person-gear"></i> Form Edit User
            </div>

            <div class="card-body">

                <form method="POST"
                    action="{{ route('users.update', $user->id) }}">

                    @csrf
                    @method('PUT')

                    <!-- NAMA -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Nama
                        </label>

                        <input type="text"
                            name="name"
                            class="form-control"
                            value="{{ old('name', $user->name) }}"
                            required>

                        @error('name')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- NIK -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            NIK
                        </label>

                        <input type="text"
                            name="nik"
                            class="form-control"
                            value="{{ old('nik', $user->nik) }}"
                            maxlength="16"
                            minlength="16"
                            inputmode="numeric"
                            required>

                        @error('nik')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- ASAL DUSUN -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Asal Dusun
                        </label>

                        <select name="dusun"
                            class="form-select"
                            required>

                            <option value="">
                                -- Pilih Asal Dusun --
                            </option>

                            @foreach ($dusunList as $dusun)
                            <option value="{{ $dusun }}"
                                {{ old('dusun', $user->dusun) == $dusun ? 'selected' : '' }}>
                                {{ $dusun }}
                            </option>
                            @endforeach

                        </select>

                        @error('dusun')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- EMAIL -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            class="form-control"
                            value="{{ old('email', $user->email) }}"
                            required>

                        @error('email')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- ROLE -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Role
                        </label>

                        <select name="role"
                            class="form-select"
                            required>

                            <option value="pengguna"
                                {{ old('role', $user->role) == 'pengguna' ? 'selected' : '' }}>
                                Pengguna
                            </option>

                            <option value="admin"
                                {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>
                                Admin
                            </option>

                        </select>

                        @error('role')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <hr class="my-4">

                    <!-- PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Password Baru
                            <span class="text-muted fw-normal">
                                (Opsional)
                            </span>
                        </label>

                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Kosongkan jika tidak ingin mengubah password">

                        @error('password')
                        <div class="text-danger small mt-1">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <!-- KONFIRMASI PASSWORD -->
                    <div class="mb-3">
                        <label class="form-label fw-semibold">
                            Konfirmasi Password Baru
                        </label>

                        <input type="password"
                            name="password_confirmation"
                            class="form-control"
                            placeholder="Ulangi password baru">
                    </div>

                    <!-- BUTTON -->
                    <div class="mt-4 d-flex justify-content-end gap-2">

                        <a href="{{ route('users.index') }}"
                            class="btn btn-secondary">
                            Batal
                        </a>

                        <button type="submit"
                            class="btn btn-primary">
                            <i class="bi bi-save"></i>
                            Simpan Perubahan
                        </button>

                    </div>

                </form>

            </div>
        </div>

    </div>
</div>

@endsection