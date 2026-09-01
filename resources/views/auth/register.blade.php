<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Register - SPK Bansos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">

    <div class="container d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-lg border-0" style="border-radius:18px;">
                    <div class="card-body bg-dark text-white p-4">

                        <h4 class="text-center mb-4">Register SPK Bansos BLT-DD Desa Sei Bamban</h4>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Nama -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>

                                <input type="text"
                                    name="name"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('name') }}"
                                    required>

                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- NIK -->
                            <div class="mb-3">
                                <label class="form-label">NIK</label>

                                <input type="text"
                                    name="nik"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('nik') }}"
                                    maxlength="16"
                                    minlength="16"
                                    inputmode="numeric"
                                    placeholder="Masukkan 16 digit NIK"
                                    required>

                                @error('nik')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Dusun -->
                            <div class="mb-3">
                                <label class="form-label">Asal Dusun</label>

                                <select name="dusun"
                                    class="form-select bg-dark text-white border-secondary"
                                    required>

                                    <option value="">-- Pilih Asal Dusun --</option>

                                    @foreach($dusunList as $dusun)
                                    <option value="{{ $dusun }}"
                                        {{ old('dusun') == $dusun ? 'selected' : '' }}>
                                        {{ $dusun }}
                                    </option>
                                    @endforeach

                                </select>

                                @error('dusun')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>

                                <input type="email"
                                    name="email"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('email') }}"
                                    required>

                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>

                                <input type="password"
                                    name="password"
                                    class="form-control bg-dark text-white border-secondary"
                                    required>

                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Konfirmasi Password -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>

                                <input type="password"
                                    name="password_confirmation"
                                    class="form-control bg-dark text-white border-secondary"
                                    required>

                                @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Button -->
                            <div class="d-grid mb-3">
                                <button type="submit" class="btn btn-primary">
                                    Register
                                </button>
                            </div>

                        </form>

                        <!-- Login Link -->
                        <div class="text-center">
                            <a href="{{ route('login') }}" class="text-info text-decoration-none">
                                Sudah punya akun? Login
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>