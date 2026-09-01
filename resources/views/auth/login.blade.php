<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - SPK Bansos</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">


    <div class="container d-flex align-items-center justify-content-center min-vh-100 px-3">
        <div class="card shadow-lg border-0" style="width: 600px; border-radius: 15px;">

            <div class="card-body p-4 bg-dark text-white">
                <h3 class="text-center ">Sistem Pendukung Keputusan Penentuan Penerima Bansos Desa Sei Bamban</h3>
                <h5 class="text-center mb-4">
                    <p class="text-secondary">
                        Bantuan Langsung Tunai Dana Desa
                    </p>
                </h5>


                <!-- Session Status -->
                @if (session('status'))
                <div class="alert alert-success">
                    {{ session('status') }}
                </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">Email</label>
                        <input type="email" name="email" class="form-control bg-secondary text-white border-0" required>
                        @error('email')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-4">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" class="form-control bg-secondary text-white border-0"
                            required>
                        @error('password')
                        <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>

                 <!-- Remember -->
{{--                    <div class="form-check mb-3">
                        <input type="checkbox" name="remember" class="form-check-input">
                        <label class="form-check-label">Remember me</label>
                    </div>
--}}
                    <!-- Button -->
                    <div class="d-grid">
                        <button class="btn btn-primary">Login</button>
                    </div>

                    <!-- Forgot -->
{{--                    @if (Route::has('password.request'))
                    <div class="text-center mt-3">
                        <a href="{{ route('password.request') }}" class="text-decoration-none text-info">
                            Forgot password?
                        </a>
                    </div>
                    @endif
--}}
                </form>

                @if (Route::has('register'))
                <div class="text-center mt-2">
                    <span class="text-light">Belum punya akun? </span>
                    <a href="{{ route('register') }}" class="text-decoration-none text-primary fw-semibold">
                        Register
                    </a>
                </div>
                @endif

                <hr class="mt-4">

                <div class="text-center footer">
                    © 2026 SPK BLT-DD Desa Sei Bamban
                </div>
            </div>


        </div>
    </div>




</body>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</html>