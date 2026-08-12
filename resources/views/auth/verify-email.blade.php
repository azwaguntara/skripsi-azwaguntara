<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email - SPK Bansos</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body style="background: linear-gradient(135deg, #0f172a, #1e293b);">

    <div class="container min-vh-100 d-flex align-items-center">
        <div class="row justify-content-center w-100">
            <div class="col-md-6 col-lg-5">

                <div class="card shadow-lg border-0" style="border-radius:15px;">
                    <div class="card-body bg-dark text-white p-4 text-center">

                        <h4 class="mb-3">Verifikasi Email</h4>

                        <p class="text-secondary small">
                            Terima kasih sudah mendaftar. Silakan cek email kamu dan klik link verifikasi untuk melanjutkan.
                            Jika belum menerima email, kamu bisa kirim ulang.
                        </p>

                        <!-- Status -->
                        @if (session('status') == 'verification-link-sent')
                        <div class="alert alert-success mt-3">
                            Link verifikasi baru sudah dikirim ke email kamu.
                        </div>
                        @endif

                        <!-- Resend -->
                        <form method="POST" action="{{ route('verification.send') }}" class="mt-3">
                            @csrf
                            <div class="d-grid">
                                <button class="btn btn-primary">
                                    Kirim Ulang Email Verifikasi
                                </button>
                            </div>
                        </form>

                        <!-- Logout -->
                        <form method="POST" action="{{ route('logout') }}" class="mt-3">
                            @csrf
                            <button type="submit" class="btn btn-outline-light w-100">
                                Logout
                            </button>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>

</body>

</html>