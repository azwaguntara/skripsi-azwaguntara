<section>

    <h5 class="mb-3 fw-bold">Informasi Profil</h5>
    <p class="text-muted mb-4">
        Update informasi profil dan email Anda.
    </p>

    @php
    $dusunList = [
    "Dusun Titi Belanga Sentosa",
    "Dusun Titi Belanga Sejahtera",
    "Dusun Titi Belanga",
    "Dusun Puji Dadi I",
    "Dusun Puji Dadi II",
    "Dusun Puji Dadi III",
    "Dusun Puji Dadi IV",
    "Dusun Sumber Rejo Utara",
    "Dusun Sumber Rejo Selatan",
    "Dusun Jati Mulyo",
    "Dusun Jati Mulyo Makmur",
    "Dusun Sido Mulyo",
    "Dusun Tahun X Utara",
    "Dusun Tahun X Selatan",
    "Dusun Benteng Teladan",
    "Dusun Klonie I",
    "Dusun Tahun XI",
    ];
    @endphp

    <form method="post" action="{{ route('profile.update') }}">
        @csrf
        @method('patch')

        <!-- NAMA -->
        <div class="mb-3">
            <label class="form-label">Nama</label>

            <input type="text"
                name="name"
                class="form-control"
                value="{{ old('name', $user->name) }}"
                required>

            @error('name')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- NIK -->
        <div class="mb-3">
            <label class="form-label">NIK</label>

            <input type="text"
                name="nik"
                class="form-control"
                value="{{ old('nik', $user->nik) }}"
                maxlength="16"
                minlength="16"
                inputmode="numeric"
                required>

            @error('nik')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- ASAL DUSUN -->
        <div class="mb-3">
            <label class="form-label">Asal Dusun</label>

            <select name="dusun" class="form-select" required>
                <option value="">-- Pilih Asal Dusun --</option>

                @foreach ($dusunList as $dusun)
                <option value="{{ $dusun }}"
                    {{ old('dusun', $user->dusun) == $dusun ? 'selected' : '' }}>
                    {{ $dusun }}
                </option>
                @endforeach
            </select>

            @error('dusun')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- EMAIL -->
        <div class="mb-3">
            <label class="form-label">Email</label>

            <input type="email"
                name="email"
                class="form-control"
                value="{{ old('email', $user->email) }}"
                required>

            @error('email')
            <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <!-- VERIFIKASI EMAIL -->
        @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
        <div class="mb-3">
            <p class="text-warning small mb-2">
                Email belum terverifikasi.
            </p>

            <button type="submit"
                form="verification-form"
                class="btn btn-warning btn-sm">
                Kirim Ulang Verifikasi
            </button>
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
            Profil berhasil diperbarui.
        </div>
        @endif

    </form>

    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! $user->hasVerifiedEmail())
    <form id="verification-form"
        method="post"
        action="{{ route('verification.send') }}"
        class="d-none">
        @csrf
    </form>
    @endif

</section>