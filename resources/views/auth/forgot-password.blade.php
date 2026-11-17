<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Lupa Password - SPK Bansos</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
        rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">

    <div class="container min-vh-100 d-flex align-items-center">

        <div class="row justify-content-center w-100">

            <div class="col-md-5 col-lg-4">

                <div class="card shadow-lg border-0"
                    style="border-radius: 15px;">

                    <div class="card-body bg-dark text-white p-4">

                        {{-- Judul --}}
                        <h4 class="text-center mb-3 fw-bold">
                            Lupa Password
                        </h4>

                        {{-- Informasi --}}
                        <p class="text-secondary small text-center mb-4">
                            Masukkan email yang telah didaftarkan.
                            Kami akan mengirimkan tautan untuk
                            mengatur ulang password Anda.
                        </p>

                        {{-- Pesan sukses --}}
                        @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                        @endif

                        {{-- Error --}}
                        @if ($errors->any())
                        <div class="alert alert-danger">
                            {{ $errors->first() }}
                        </div>
                        @endif

                        {{-- Form --}}
                        <form method="POST"
                            action="{{ route('password.email') }}">

                            @csrf

                            <div class="mb-3">

                                <label for="email"
                                    class="form-label">
                                    Email
                                </label>

                                <input
                                    type="email"
                                    id="email"
                                    name="email"
                                    class="form-control"
                                    value="{{ old('email') }}"
                                    placeholder="Masukkan email yang terdaftar"
                                    required
                                    autofocus>

                            </div>

                            <div class="d-grid">

                                <button type="submit"
                                    class="btn btn-primary">

                                    Kirim Link Reset Password

                                </button>

                            </div>

                        </form>

                        {{-- Kembali ke login --}}
                        <div class="text-center mt-3">

                            <a href="{{ route('login') }}"
                                class="text-info text-decoration-none">

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