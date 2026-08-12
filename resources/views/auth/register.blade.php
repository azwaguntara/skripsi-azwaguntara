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

                        <h4 class="text-center mb-4">Register SPK Bansos</h4>

                        <form method="POST" action="{{ route('register') }}">
                            @csrf

                            <!-- Name -->
                            <div class="mb-3">
                                <label class="form-label">Nama</label>
                                <input type="text" name="name"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('name') }}" required>

                                @error('name')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

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

                            <!-- Password -->
                            <div class="mb-3">
                                <label class="form-label">Password</label>
                                <input type="password" name="password"
                                    class="form-control bg-dark text-white border-secondary" required>

                                @error('password')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Confirm Password -->
                            <div class="mb-3">
                                <label class="form-label">Konfirmasi Password</label>
                                <input type="password" name="password_confirmation"
                                    class="form-control bg-dark text-white border-secondary" required>

                                @error('password_confirmation')
                                <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <!-- Button -->
                            <div class="d-grid mb-3">
                                <button class="btn btn-primary">Register</button>
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