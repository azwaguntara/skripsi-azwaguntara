<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Forgot Password - SPK Bansos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">

    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0" style="border-radius:15px;">
                    <div class="card-body bg-dark text-white p-4">

                        <h4 class="text-center mb-3">Lupa Password</h4>

                        <p class="text-secondary small text-center">
                            Masukkan email kamu, nanti sistem akan kirim link reset password.
                        </p>

                        <!-- Session Status -->
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        <form method="POST" action="{{ route('password.email') }}">
                            @csrf

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('email') }}" required>

                                @error('email')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Button -->
                            <div class="d-grid">
                                <button class="btn btn-primary">
                                    Kirim Link Reset
                                </button>
                            </div>

                        </form>

                        <!-- Back to Login -->
                        <div class="text-center mt-3">
                            <a href="{{ route('login') }}" class="text-info text-decoration-none">
                                ← Kembali ke Login
                            </a>
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>