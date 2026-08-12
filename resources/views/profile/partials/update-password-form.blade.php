<section>

    <h5 class="mb-3 fw-bold">Ubah Password</h5>
    <p class="text-muted mb-4">
        Gunakan password yang kuat untuk menjaga keamanan akun Anda.
    </p>

    <form method="post" action="{{ route('password.update') }}">
        @csrf
        @method('put')

        <!-- PASSWORD LAMA -->
        <div class="mb-3">
            <label class="form-label">Password Lama</label>
            <input type="password" name="current_password"
                class="form-control">

            @error('current_password', 'updatePassword')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- PASSWORD BARU -->
        <div class="mb-3">
            <label class="form-label">Password Baru</label>
            <input type="password" name="password"
                class="form-control">

            @error('password', 'updatePassword')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- KONFIRMASI -->
        <div class="mb-3">
            <label class="form-label">Konfirmasi Password</label>
            <input type="password" name="password_confirmation"
                class="form-control">

            @error('password_confirmation', 'updatePassword')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="mt-4 text-end">
            <button type="submit" class="btn btn-primary">
                <i class="bi bi-save"></i> Simpan
            </button>
        </div>

        <!-- SUCCESS -->
        @if (session('status') === 'password-updated')
        <div class="alert alert-success mt-3">
            Password berhasil diperbarui
        </div>
        @endif

    </form>

</section>