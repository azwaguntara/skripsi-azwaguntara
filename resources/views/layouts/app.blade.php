<!DOCTYPE html>
<html>

<head>

    <title>SPK Bansos</title>

    <!-- WAJIB -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        body {
            background: #f4f6f9;
            overflow-x: hidden;
        }

        /* SIDEBAR */
        .sidebar {
            width: 250px;
            height: 100vh;
            background: #1f2d3d;
            position: fixed;
            top: 0;
            left: 0;
            transition: 0.3s;
            z-index: 1000;
        }

        .sidebar a {
            color: white;
            text-decoration: none;
            display: block;
            padding: 12px;
        }

        .sidebar a:hover {
            background: #34495e;
        }

        /* CONTENT */
        .content {
            margin-left: 250px;
            padding: 20px;
            transition: 0.3s;
        }

        /* HEADER MOBILE */
        .mobile-header {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            z-index: 9999;
        }

        /* CARD */
        .card {
            border-radius: 12px;
            border: none;
            box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
        }

        /* RESPONSIVE */
        @media (max-width: 768px) {

            .sidebar {
                left: -250px;
            }

            .sidebar.active {
                left: 0;
            }

            .content {
                margin-left: 0;
                padding-top: 70px;
            }

            .mobile-header {
                display: flex;
                align-items: center;
                background: #1f2d3d;
                color: white;
                padding: 10px 15px;
            }

            .mobile-header h5 {
                margin: 0;
                flex: 1;
            }





            /* CARD */
            .card {
                border-radius: 12px;
                border: none;
                box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05);
            }

            /* INPUT */
            input,
            select,
            textarea {
                width: 100% !important;
                padding: 10px !important;
                border-radius: 8px !important;
                border: 1px solid #ced4da !important;
            }

            /* LABEL */
            label {
                font-weight: 500;
                margin-bottom: 5px;
            }

            /* BUTTON */
            button,
            .btn {
                border-radius: 8px !important;
            }

            /* BUTTON PRIMARY (SAVE) */
            button[type="submit"] {
                background: #1f2d3d !important;
                color: white !important;
                border: none !important;
                padding: 8px 16px !important;
            }

            button[type="submit"]:hover {
                background: #34495e !important;
            }

            /* FIX FORM JETSTREAM */
            [x-data] input {
                width: 100% !important;
            }
        }
    </style>

</head>

<body>

    <!-- MOBILE HEADER -->
    <div class="mobile-header d-md-none">
        <button class="btn btn-light btn-sm me-2" onclick="toggleSidebar()">☰</button>
        <h5>SPK Bansos</h5>
    </div>

    <!-- SIDEBAR -->
    <div class="sidebar" id="sidebar">

        <h4 class="text-white p-3">SPK Bansos</h4>

        
        <a href="{{route('dashboard')}}">
            <i></i> Dashboard
        </a>

        @if(auth()->user()->role == 'admin')

            <a href="{{ route('kriteria.index') }}">
                <i></i> Data Kriteria
            </a>

            <a href="{{ route('alternatif.index') }}">
                <i ></i> Data Alternatif
            </a>

            <a href="{{ route('penilaian.index') }}">
                <i></i> Penilaian
            </a>

            <a href="{{ route('smart.index') }}">
                <i></i> Perhitungan SMART
            </a>

            <a href="{{ route('copras.index') }}">
                <i></i> Perhitungan COPRAS
            </a>

        @endif

        <a href="{{ route('riwayat') }}">
            Riwayat Perankingan
        </a>

        <a href="{{ route('profile.edit') }}">
            <i class="bi bi-person"></i> Profil
        </a>



        <form method="POST" action="{{route('logout')}}" class="p-3">
            @csrf
            <button class="btn btn-danger btn-sm w-100">Logout</button>
        </form>

    </div>

    <!-- CONTENT -->
    <div class="content">

        @yield('content')

    </div>

    <!-- SCRIPT -->
    <script>
        function toggleSidebar() {
            document.getElementById('sidebar').classList.toggle('active');
        }
    </script>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</body>

</html>