<section>

    <h5 class="mb-3 fw-bold">Informasi Profil</h5>
    <p class="text-muted mb-4">
        Update informasi profil dan email Anda.
    </p>

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- NAMA -->
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name"
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required>

            @error('name')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required>

            @error('email')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- VERIFIKASI -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())

        <div class="mb-3">
            <p class="text-warning small">
                Email belum terverifikasi.
            </p>

            <form method="post" action="{{ route('verification.send') }}">
                @csrf
                <button class="btn btn-warning btn-sm">
                    Kirim Ulang Verifikasi
                </button>
            </form>
        </div>

        @endif

        <!-- BUTTON -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>

        <!-- SUCCESS -->
        @if (session('status') === 'profile-updated')
        <div class="alert alert-success mt-3">
            Profil berhasil diperbarui
        </div>
        @endif

    </form>

</section>