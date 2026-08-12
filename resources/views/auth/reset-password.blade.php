<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Reset Password - SPK Bansos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">

    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-lg border-0" style="border-radius:15px;">
                    <div class="card-body bg-dark text-white p-4">

                        <h4 class="text-center mb-4">Reset Password</h4>

                        <form method="POST" action="{{ route('password.store') }}">
                            @csrf

                            <!-- Token -->
                            <input type="hidden" name="token" value="{{ $request->route('token') }}">

                            <!-- Email -->
                            <div class="mb-3">
                                <label class="form-label">Email</label>
                                <input type="email" name="email"
                                    class="form-control bg-dark text-white border-secondary"
                                    value="{{ old('email', $request->email) }}" required>

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
                            <div class="d-grid">
                                <button class="btn btn-primary">
                                    Reset Password
                                </button>
                            </div>

                        </form>

                        <!-- Back -->
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