<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - SPK Bansos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        html,
        body {
            width: 100%;
            min-height: 100%;
            margin: 0;
        }

        body {
            background: linear-gradient(135deg, #0f172a, #1e293b);
        }

        .reset-container {
            min-height: 100vh;
            width: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .reset-card {
            width: 100%;
            max-width: 420px;
            border-radius: 15px;
            overflow: hidden;
        }

        .reset-card-body {
            background: #212529;
            color: white;
            padding: 30px;
        }

        .form-control {
            min-height: 42px;
        }

        .btn-reset {
            min-height: 42px;
        }

        @media (max-width: 576px) {
            .reset-container {
                padding: 15px;
            }

            .reset-card {
                max-width: 100%;
            }

            .reset-card-body {
                padding: 24px 20px;
            }

            h4 {
                font-size: 21px;
            }
        }
    </style>
</head>

<body>

    <div class="reset-container">

        <div class="reset-card card shadow-lg border-0">

            <div class="reset-card-body">

                <h4 class="text-center mb-4">
                    Reset Password
                </h4>

                <form method="POST" action="{{ route('password.store') }}">
                    @csrf

                    <!-- Token -->
                    <input type="hidden"
                        name="token"
                        value="{{ $request->route('token') }}">

                    <!-- Email -->
                    <div class="mb-3">
                        <label class="form-label">
                            Email
                        </label>

                        <input type="email"
                            name="email"
                            class="form-control bg-dark text-white border-secondary"
                            value="{{ old('email', $request->email) }}"
                            required>

                        @error('email')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div class="mb-3">
                        <label class="form-label">
                            Password
                        </label>

                        <input type="password"
                            name="password"
                            class="form-control bg-dark text-white border-secondary"
                            required>

                        @error('password')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <!-- Confirm Password -->
                    <div class="mb-3">
                        <label class="form-label">
                            Konfirmasi Password
                        </label>

                        <input type="password"
                            name="password_confirmation"
                            class="form-control bg-dark text-white border-secondary"
                            required>

                        @error('password_confirmation')
                        <small class="text-danger">
                            {{ $message }}
                        </small>
                        @enderror
                    </div>

                    <!-- Button -->
                    <div class="d-grid mt-4">
                        <button type="submit" class="btn btn-primary btn-reset">
                            Reset Password
                        </button>
                    </div>

                </form>

                <!-- Back -->
                <div class="text-center mt-3">
                    <a href="{{ route('login') }}"
                        class="text-info text-decoration-none">
                        ← Kembali ke Login
                    </a>
                </div>

            </div>
        </div>

    </div>

</body>

</html>