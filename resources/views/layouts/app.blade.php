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

            overflow-y: auto;
            overflow-x: hidden;
        }

        .sidebar::-webkit-scrollbar {
            width: 6px;
        }

        .sidebar::-webkit-scrollbar-thumb {
            background: #526477;
            border-radius: 10px;
        }

        .sidebar::-webkit-scrollbar-track {
            background: #1f2d3d;
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

        .sidebar a.active {
            background-color: #2b5697;
            color: white;
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

        .user-info {
            padding: 14px 16px;
            margin-top: 8px;
            border-top: 1px solid rgba(255, 255, 255, 0.12);
        }

        .user-info .user-icon {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid rgba(255, 255, 255, 0.8);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #fff;
            font-size: 17px;
        }

        .user-info .user-name {
            color: #fff;
            font-size: 14px;
            font-weight: 600;
            line-height: 1.2;
        }

        .user-info .user-role {
            color: rgba(255, 255, 255, 0.6);
            font-size: 11px;
            margin-top: 2px;
        }

        .table-responsive {
            width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            -webkit-overflow-scrolling: touch;
        }

        .table-responsive table {
            min-width: 700px;
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

        <a href="{{ route('dashboard') }}"
            class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
            Dashboard
        </a>

        @if(auth()->user()->role == 'admin')

        <a href="{{ route('kriteria.index') }}"
            class="{{ request()->routeIs('kriteria.*') ? 'active' : '' }}">
            Data Kriteria
        </a>

        <a href="{{ route('alternatif.index') }}"
            class="{{ request()->routeIs('alternatif.*') ? 'active' : '' }}">
            Data Alternatif
        </a>

        <a href="{{ route('penilaian.index') }}"
            class="{{ request()->routeIs('penilaian.*') ? 'active' : '' }}">
            Penilaian
        </a>

        <a href="{{ route('smart.index') }}"
            class="{{ request()->routeIs('smart.*') ? 'active' : '' }}">
            Perhitungan SMART
        </a>

        <a href="{{ route('copras.index') }}"
            class="{{ request()->routeIs('copras.*') ? 'active' : '' }}">
            Perhitungan COPRAS
        </a>

        <a href="{{ route('riwayat') }}"
            class="{{ request()->is('riwayat*') ? 'active' : '' }}">
            Riwayat Perankingan
        </a>

        <a href="{{ route('users.index') }}"
            class="{{ request()->routeIs('users.*') ? 'active' : '' }}">
            <i class="bi bi-people"></i> Manajemen User
        </a>

        @endif

        <a href="{{ route('penerima.index') }}"
            class="nav-link {{ request()->routeIs('penerima.index') ? 'active' : '' }}">

            <i class="bi bi-person-check me-2"></i>
            Penerima Bantuan

        </a>

        <a href="{{ route('profile.edit') }}"
            class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
            <i class="bi bi-person"></i> Profil
        </a>


        <div class="user-info">
            <div class="d-flex align-items-center">

                <div class="user-icon me-2">
                    <i class="bi bi-person-fill"></i>
                </div>

                <div>
                    <div class="user-name">
                        {{ Auth::user()->name }}
                    </div>

                    <div class="user-role">
                        {{ ucfirst(Auth::user()->role ?? 'User') }}
                    </div>
                </div>

            </div>
        </div>

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
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>