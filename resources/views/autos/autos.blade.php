<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vehículos - VMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600;700&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        :root {
            --white: #ffffff;
            --off-white: #f8f8f6;
            --gray-50: #f5f5f4;
            --gray-100: #eeeeec;
            --gray-200: #ddddd9;
            --gray-300: #c4c4be;
            --gray-400: #9d9d96;
            --gray-500: #737370;
            --gray-700: #3d3d3a;
            --gray-900: #1a1a18;
            --accent: #2d2d2a;
            --accent-light: #4a4a46;
            --gold: #b8935a;
            --gold-light: #d4aa72;
            --danger: #c0392b;
            --success-color: #27ae60;
            --shadow-sm: 0 1px 3px rgba(0,0,0,0.06), 0 1px 2px rgba(0,0,0,0.04);
            --shadow-md: 0 4px 16px rgba(0,0,0,0.08), 0 2px 6px rgba(0,0,0,0.04);
            --shadow-lg: 0 12px 40px rgba(0,0,0,0.10), 0 4px 12px rgba(0,0,0,0.06);
            --radius: 12px;
            --radius-sm: 8px;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--off-white);
            color: var(--gray-900);
            min-height: 100vh;
        }

        /* ── NAVBAR ── */
        .navbar-vms {
            background: var(--white);
            border-bottom: 1px solid var(--gray-100);
            padding: 0.9rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: var(--shadow-sm);
        }

        .navbar-brand-vms {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.5rem;
            color: var(--accent) !important;
            letter-spacing: -0.5px;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand-vms .brand-icon {
            width: 36px;
            height: 36px;
            background: var(--accent);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1rem;
        }

        .nav-link-vms {
            color: var(--gray-500) !important;
            font-weight: 500;
            font-size: 0.9rem;
            padding: 0.4rem 0.9rem !important;
            border-radius: 6px;
            transition: all 0.2s ease;
            text-decoration: none;
            letter-spacing: 0.1px;
        }

        .nav-link-vms:hover, .nav-link-vms.active {
            color: var(--accent) !important;
            background: var(--gray-50);
        }

        .nav-link-vms.active {
            font-weight: 600;
        }

        .user-pill {
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            padding: 0.4rem 1rem;
            border-radius: 50px;
            color: var(--gray-700);
            font-size: 0.875rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 0.4rem;
            text-decoration: none;
            transition: all 0.2s ease;
        }

        .user-pill:hover {
            background: var(--gray-100);
            color: var(--accent);
        }

        .btn-logout {
            background: none;
            border: 1px solid var(--gray-200);
            padding: 0.4rem 0.7rem;
            border-radius: 6px;
            color: var(--gray-400);
            cursor: pointer;
            transition: all 0.2s ease;
            font-size: 1rem;
        }

        .btn-logout:hover {
            background: #fdf2f2;
            border-color: #e0b4b4;
            color: var(--danger);
        }

        /* ── PAGE HEADER ── */
        .page-header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-100);
            padding: 2.5rem 0 2rem;
        }

        .page-header-inner {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 1.5rem;
        }

        .page-eyebrow {
            font-size: 0.75rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--gold);
            margin-bottom: 0.4rem;
        }

        .page-title {
            font-family: 'Playfair Display', serif;
            font-size: 2.4rem;
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1.1;
            letter-spacing: -0.5px;
        }

        .page-subtitle {
            color: var(--gray-400);
            font-size: 0.95rem;
            margin-top: 0.4rem;
        }

        .btn-new-vehicle {
            background: var(--accent);
            color: white;
            border: none;
            padding: 0.75rem 1.8rem;
            border-radius: var(--radius-sm);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            cursor: pointer;
            transition: all 0.25s ease;
            white-space: nowrap;
            letter-spacing: 0.2px;
        }

        .btn-new-vehicle:hover {
            background: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* ── FILTERS BAR ── */
        .filters-bar {
            background: var(--white);
            border-bottom: 1px solid var(--gray-100);
            padding: 1rem 0;
        }

        .filters-inner {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .search-box {
            position: relative;
            flex: 1;
            min-width: 220px;
            max-width: 340px;
        }

        .search-box i {
            position: absolute;
            left: 0.9rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray-300);
            font-size: 0.9rem;
            pointer-events: none;
        }

        .search-input {
            width: 100%;
            padding: 0.6rem 1rem 0.6rem 2.3rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            background: var(--gray-50);
            color: var(--gray-900);
            font-family: 'DM Sans', sans-serif;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--gray-400);
            background: var(--white);
            box-shadow: 0 0 0 3px rgba(45,45,42,0.06);
        }

        .filter-select {
            padding: 0.6rem 1rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            background: var(--gray-50);
            color: var(--gray-700);
            font-family: 'DM Sans', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--gray-400);
            background: var(--white);
        }

        .filters-count {
            margin-left: auto;
            font-size: 0.85rem;
            color: var(--gray-400);
            white-space: nowrap;
        }

        .filters-count span {
            font-weight: 600;
            color: var(--gray-700);
        }

        /* ── MAIN CONTENT ── */
        .main-wrapper {
            padding: 2rem 0 4rem;
        }

        /* ── TABLE CARD ── */
        .table-card {
            background: var(--white);
            border-radius: var(--radius);
            border: 1px solid var(--gray-100);
            box-shadow: var(--shadow-sm);
            overflow: hidden;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .vms-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 0.875rem;
        }

        .vms-table thead tr {
            border-bottom: 2px solid var(--gray-100);
            background: var(--gray-50);
        }

        .vms-table thead th {
            padding: 1rem 1.2rem;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            color: var(--gray-400);
            white-space: nowrap;
            text-align: left;
        }

        .vms-table tbody tr {
            border-bottom: 1px solid var(--gray-100);
            transition: background 0.15s ease;
        }

        .vms-table tbody tr:last-child {
            border-bottom: none;
        }

        .vms-table tbody tr:hover {
            background: var(--gray-50);
        }

        .vms-table td {
            padding: 1.1rem 1.2rem;
            color: var(--gray-700);
            vertical-align: middle;
        }

        /* Columna de vehículo */
        .vehicle-cell {
            display: flex;
            align-items: center;
            gap: 1rem;
            min-width: 220px;
        }

        .vehicle-thumb {
            width: 52px;
            height: 40px;
            background: var(--gray-100);
            border-radius: var(--radius-sm);
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-300);
            font-size: 1.3rem;
            flex-shrink: 0;
            overflow: hidden;
        }

        .vehicle-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .vehicle-name {
            font-weight: 600;
            color: var(--gray-900);
            font-size: 0.9rem;
        }

        .vehicle-brand {
            font-size: 0.78rem;
            color: var(--gray-400);
            margin-top: 1px;
        }

        /* Badges */
        .badge-tipo {
            display: inline-flex;
            align-items: center;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--gray-100);
            color: var(--gray-500);
            white-space: nowrap;
        }

        .badge-consignacion {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.25rem 0.7rem;
            border-radius: 50px;
            font-size: 0.73rem;
            font-weight: 600;
            background: #fef3e2;
            color: #b8700a;
            white-space: nowrap;
        }

        .badge-propio {
            background: #eef7f0;
            color: #2e7d4f;
        }

        .badge-oculto {
            display: inline-flex;
            align-items: center;
            gap: 0.25rem;
            font-size: 0.72rem;
            color: var(--gray-300);
            margin-top: 2px;
        }

        /* Precio */
        .price-cell {
            font-family: 'Playfair Display', serif;
            font-size: 1rem;
            font-weight: 600;
            color: var(--gray-900);
            letter-spacing: -0.3px;
        }

        /* Combustible chips */
        .chip-combustible {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            padding: 0.2rem 0.6rem;
            border-radius: 4px;
            font-size: 0.75rem;
            font-weight: 500;
            background: var(--gray-50);
            border: 1px solid var(--gray-200);
            color: var(--gray-500);
        }

        /* Acciones */
        .action-buttons {
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        .btn-action {
            width: 32px;
            height: 32px;
            border-radius: 6px;
            border: 1px solid var(--gray-200);
            background: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-400);
            font-size: 0.85rem;
            transition: all 0.2s ease;
            text-decoration: none;
        }

        .btn-action:hover {
            color: var(--accent);
            border-color: var(--gray-300);
            background: var(--gray-50);
        }

        .btn-action.delete:hover {
            color: var(--danger);
            border-color: #e0b4b4;
            background: #fdf2f2;
        }

        /* Empty state */
        .empty-state {
            text-align: center;
            padding: 5rem 2rem;
        }

        .empty-icon {
            width: 80px;
            height: 80px;
            background: var(--gray-100);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: var(--gray-300);
            font-size: 2rem;
        }

        .empty-title {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 600;
            color: var(--gray-700);
            margin-bottom: 0.5rem;
        }

        .empty-text {
            color: var(--gray-400);
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
        }

        /* ─── MODAL ─── */
        .modal-content {
            border: none;
            border-radius: 16px;
            box-shadow: var(--shadow-lg);
            background: var(--white);
            overflow: hidden;
        }

        .modal-header {
            background: var(--white);
            border-bottom: 1px solid var(--gray-100);
            padding: 1.8rem 2rem 1.4rem;
        }

        .modal-header-inner {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .modal-title-group {
            display: flex;
            align-items: center;
            gap: 0.9rem;
        }

        .modal-icon {
            width: 44px;
            height: 44px;
            background: var(--gray-900);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.1rem;
        }

        .modal-title-text {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 600;
            color: var(--gray-900);
            line-height: 1;
        }

        .modal-subtitle-text {
            font-size: 0.8rem;
            color: var(--gray-400);
            margin-top: 0.2rem;
        }

        .btn-close-custom {
            width: 32px;
            height: 32px;
            background: var(--gray-100);
            border: none;
            border-radius: 6px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            color: var(--gray-400);
            font-size: 0.9rem;
            transition: all 0.2s ease;
        }

        .btn-close-custom:hover {
            background: var(--gray-200);
            color: var(--gray-700);
        }

        .modal-body {
            padding: 1.8rem 2rem;
            background: var(--white);
        }

        /* Secciones del modal */
        .form-section {
            margin-bottom: 1.8rem;
        }

        .form-section-title {
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 1.5px;
            color: var(--gold);
            margin-bottom: 1rem;
            display: flex;
            align-items: center;
            gap: 0.6rem;
        }

        .form-section-title::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--gray-100);
        }

        /* Inputs */
        .field-group {
            margin-bottom: 1.1rem;
        }

        .field-label {
            display: block;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--gray-500);
            margin-bottom: 0.4rem;
            letter-spacing: 0.2px;
        }

        .field-label .required {
            color: var(--gold);
            margin-left: 2px;
        }

        .field-input {
            width: 100%;
            padding: 0.65rem 0.9rem;
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-family: 'DM Sans', sans-serif;
            color: var(--gray-900);
            background: var(--white);
            transition: all 0.2s ease;
        }

        .field-input:focus {
            outline: none;
            border-color: var(--gray-400);
            box-shadow: 0 0 0 3px rgba(45,45,42,0.06);
        }

        .field-input::placeholder {
            color: var(--gray-300);
        }

        .field-input.is-invalid {
            border-color: #e57373;
            background: #fffafa;
        }

        select.field-input {
            cursor: pointer;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 16 16'%3e%3cpath fill='none' stroke='%239d9d96' stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M2 5l6 6 6-6'/%3e%3c/svg%3e");
            background-repeat: no-repeat;
            background-position: right 0.7rem center;
            background-size: 14px 10px;
            padding-right: 2.2rem;
        }

        textarea.field-input {
            resize: vertical;
            min-height: 80px;
        }

        /* Toggle switches */
        .toggle-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0.9rem 1rem;
            background: var(--gray-50);
            border: 1px solid var(--gray-100);
            border-radius: var(--radius-sm);
            margin-bottom: 0.8rem;
            transition: background 0.2s ease;
        }

        .toggle-row:hover {
            background: var(--gray-100);
        }

        .toggle-info {
            display: flex;
            align-items: center;
            gap: 0.7rem;
        }

        .toggle-info-icon {
            width: 32px;
            height: 32px;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: 7px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--gray-400);
            font-size: 0.9rem;
        }

        .toggle-label {
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-700);
        }

        .toggle-desc {
            font-size: 0.75rem;
            color: var(--gray-400);
        }

        .form-switch-custom .form-check-input {
            width: 2.2rem;
            height: 1.2rem;
            cursor: pointer;
        }

        .form-check-input:checked {
            background-color: var(--accent);
            border-color: var(--accent);
        }

        .form-check-input:focus {
            box-shadow: 0 0 0 3px rgba(45,45,42,0.1);
            border-color: var(--accent);
        }

        /* Modal footer */
        .modal-footer-custom {
            background: var(--gray-50);
            border-top: 1px solid var(--gray-100);
            padding: 1.2rem 2rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 1rem;
        }

        .footer-note {
            font-size: 0.75rem;
            color: var(--gray-300);
            display: flex;
            align-items: center;
            gap: 0.3rem;
        }

        .footer-actions {
            display: flex;
            gap: 0.7rem;
        }

        .btn-cancel {
            padding: 0.65rem 1.4rem;
            background: var(--white);
            border: 1px solid var(--gray-200);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 500;
            color: var(--gray-500);
            cursor: pointer;
            transition: all 0.2s ease;
            font-family: 'DM Sans', sans-serif;
        }

        .btn-cancel:hover {
            background: var(--gray-100);
            border-color: var(--gray-300);
            color: var(--gray-700);
        }

        .btn-submit {
            padding: 0.65rem 1.8rem;
            background: var(--accent);
            border: 1px solid var(--accent);
            border-radius: var(--radius-sm);
            font-size: 0.875rem;
            font-weight: 600;
            color: white;
            cursor: pointer;
            transition: all 0.25s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-family: 'DM Sans', sans-serif;
            letter-spacing: 0.2px;
        }

        .btn-submit:hover {
            background: var(--accent-light);
            border-color: var(--accent-light);
            transform: translateY(-1px);
            box-shadow: var(--shadow-md);
        }

        /* Animaciones entrada */
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        .vms-table tbody tr {
            animation: fadeUp 0.35s ease backwards;
        }

        .vms-table tbody tr:nth-child(1)  { animation-delay: 0.05s; }
        .vms-table tbody tr:nth-child(2)  { animation-delay: 0.10s; }
        .vms-table tbody tr:nth-child(3)  { animation-delay: 0.15s; }
        .vms-table tbody tr:nth-child(4)  { animation-delay: 0.20s; }
        .vms-table tbody tr:nth-child(5)  { animation-delay: 0.25s; }

        /* ── RESPONSIVE ── */
        @media (max-width: 768px) {
            .page-title { font-size: 1.8rem; }
            .modal-body { padding: 1.4rem 1.2rem; }
            .modal-header { padding: 1.4rem 1.2rem; }
            .modal-footer-custom { flex-direction: column; align-items: stretch; }
            .footer-actions { justify-content: flex-end; }
        }
    </style>
</head>
<body>

    <!-- ── NAVBAR ── -->
    <nav class="navbar navbar-expand-lg navbar-vms">
        <div class="container-fluid px-4">
            <a class="navbar-brand-vms" href="{{ route('dashboard') }}">
                <div class="brand-icon"><i class="bi bi-car-front-fill"></i></div>
                VMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                style="border-color: var(--gray-200); padding: 0.4rem 0.6rem;">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto ms-4 gap-1">
                    <li class="nav-item">
                        <a class="nav-link-vms" href="{{ route('dashboard') }}">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-vms active" >
                            <i class="bi bi-car-front me-1"></i>Vehículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-vms" >
                            <i class="bi bi-tag me-1"></i>Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link-vms" >
                            <i class="bi bi-graph-up me-1"></i>Reportes
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-2">
                    <a href="#" class="user-pill">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->nombre ?? 'Usuario' }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST">
                        @csrf
                        <button type="submit" class="btn-logout" title="Cerrar sesión">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="container-fluid px-4">
            <div class="page-header-inner">
                <div>
                    <p class="page-eyebrow">Inventario</p>
                    <h1 class="page-title">Vehículos</h1>
                    <p class="page-subtitle">
                        {{ $totalVehiculos ?? 0 }} unidades registradas
                        @if(isset($totalConsignacion) && $totalConsignacion > 0)
                            &mdash; {{ $totalConsignacion }} en consignación
                        @endif
                    </p>
                </div>
                <button class="btn-new-vehicle" data-bs-toggle="modal" data-bs-target="#modalNuevoVehiculo">
                    <i class="bi bi-plus-lg"></i>
                    Agregar Vehículo
                </button>
            </div>
        </div>
    </div>

    <!-- ── FILTERS BAR ── -->
    <div class="filters-bar">
    <div class="container-fluid px-4">
        <form action="{{ route('autos.index') }}" method="GET" class="filters-inner" id="filterForm">
            
            <div class="search-box">
                <i class="bi bi-search"></i>
                <input type="text" name="search" class="search-input" 
                       placeholder="Buscar modelo, color, año..." 
                       value="{{ request('search') }}" id="searchInput">
            </div>

            <select class="filter-select" name="marca" onchange="this.form.submit()">
                <option value="">Todas las marcas</option>
                @foreach($marcas ?? [] as $marca)
                    <option value="{{ $marca->id_marca }}" {{ request('marca') == $marca->id_marca ? 'selected' : '' }}>
                        {{ $marca->nombre }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="tipo" onchange="this.form.submit()">
                <option value="">Todos los tipos</option>
                @foreach($tipos ?? [] as $tipo)
                    <option value="{{ $tipo->tipo }}" {{ request('tipo') == $tipo->tipo ? 'selected' : '' }}>
                        {{ $tipo->tipo }}
                    </option>
                @endforeach
            </select>

            <select class="filter-select" name="consignacion" onchange="this.form.submit()">
                <option value="">Todos</option>
                <option value="1" {{ request('consignacion') === '1' ? 'selected' : '' }}>En consignación</option>
                <option value="0" {{ request('consignacion') === '0' ? 'selected' : '' }}>Propios</option>
            </select>

            <span class="filters-count">
                Mostrando <span>{{ $vehiculos->total() }}</span> vehículos 
            </span>
            
            @if(request()->anyFilled(['search', 'marca', 'tipo', 'consignacion']))
                <a href="{{ route('autos.index') }}" class="btn btn-sm btn-outline-secondary">Limpiar</a>
            @endif
        </form>
    </div>
</div>

    <!-- ── MAIN CONTENT ── -->
    <div class="main-wrapper">
        <div class="container-fluid px-4">

            @if(session('success'))
                <div id="alertBox"></div>
            @endif

            <div class="table-card">
                @if(isset($vehiculos) && count($vehiculos) > 0)
                <div class="table-responsive">
                    <table class="vms-table" id="vehiculosTable">
                        <thead>
                            <tr>
                                <th>Vehículo</th>
                                <th>Tipo</th>
                                <th>Año</th>
                                <th>Color</th>
                                <th>Combustible</th>
                                <th>Kilometraje</th>
                                <th>Precio</th>
                                <th>Estado</th>
                                <th style="text-align:right;">Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($vehiculos as $vehiculo)
                            <tr data-marca="{{ $vehiculo->marca->nombre ?? '' }}"
                                data-tipo="{{ $vehiculo->tipo }}"
                                data-consignacion="{{ $vehiculo->consignacion ? '1' : '0' }}">
                                <td>
                                    <div class="vehicle-cell">
                                        <div class="vehicle-thumb">
                                            @if($vehiculo->imagenes && $vehiculo->imagenes->count() > 0)
                                                <img src="{{ asset('storage/' . $vehiculo->imagenes->first()->thumbnail) }}" alt="">
                                            @else
                                                <i class="bi bi-car-front"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <div class="vehicle-name">{{ $vehiculo->marca->nombre ?? '—' }} {{ $vehiculo->modelo }}</div>
                                            <div class="vehicle-brand">{{ $vehiculo->transmision }}</div>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <span class="badge-tipo">{{ $vehiculo->tipo }}</span>
                                </td>
                                <td style="font-weight: 500; color: var(--gray-700);">{{ $vehiculo->year }}</td>
                                <td style="color: var(--gray-500);">{{ $vehiculo->color }}</td>
                                <td>
                                    <span class="chip-combustible">
                                        <i class="bi bi-fuel-pump" style="font-size:0.7rem;"></i>
                                        {{ $vehiculo->combustible }}
                                    </span>
                                </td>
                                <td style="color: var(--gray-500);">
                                    @if($vehiculo->ocultar_kilometraje)
                                        <span class="badge-oculto"><i class="bi bi-eye-slash"></i> Oculto</span>
                                    @else
                                        {{ number_format($vehiculo->kilometraje) }} km
                                    @endif
                                </td>
                                <td>
                                    <span class="price-cell">${{ number_format($vehiculo->precio, 0) }}</span>
                                </td>
                                <td>
                                    @if($vehiculo->consignacion)
                                        <span class="badge-consignacion"><i class="bi bi-bookmark-star-fill"></i> Consignación</span>
                                    @else
                                        <span class="badge-consignacion badge-propio"><i class="bi bi-check-circle-fill"></i> Propio</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="action-buttons" style="justify-content: flex-end;">
                                        <a  class="btn-action" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a class="btn-action btn-edit" 
                                            title="Editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalNuevoVehiculo" {{-- Corregido: antes decía #modalVehiculo --}}
                                            data-id="{{ $vehiculo->id_auto }}"
                                            data-modelo="{{ $vehiculo->modelo }}"
                                            data-marca="{{ $vehiculo->id_marca }}"
                                            data-tipo="{{ $vehiculo->tipo }}"
                                            data-year="{{ $vehiculo->year }}"
                                            data-color="{{ $vehiculo->color }}"
                                            data-transmision="{{ $vehiculo->transmision }}"
                                            data-combustible="{{ $vehiculo->combustible }}"
                                            data-kilometraje="{{ $vehiculo->kilometraje }}"
                                            data-precio="{{ $vehiculo->precio }}"
                                            data-descripcion="{{ $vehiculo->descripcion }}"
                                            data-ocultar="{{ $vehiculo->ocultar_kilometraje ? '1' : '0' }}"
                                            data-consignacion="{{ $vehiculo->consignacion ? '1' : '0' }}"
                                            style="cursor: pointer;">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                            <form action="{{ route('autos.destroy', $vehiculo->id_auto) }}" method="POST" class="form-eliminar">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn-action delete btn-delete" title="Eliminar">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                        @if(session('success'))
                                            <script>
                                                Swal.fire({
                                                    icon: 'success',
                                                    title: '¡Hecho!',
                                                    text: "{{ session('success') }}",
                                                    timer: 3000,
                                                    showConfirmButton: false
                                                });
                                            </script>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                        
                    </table>
                    <div class="d-flex justify-content-center mt-4">
                            {{ $vehiculos->links() }}
                    </div>
                </div>
                @else
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="bi bi-car-front"></i>
                    </div>
                    <div class="empty-title">Sin vehículos registrados</div>
                    <p class="empty-text">Agrega el primer vehículo al inventario para comenzar.</p>
                    <button class="btn-new-vehicle mx-auto" data-bs-toggle="modal" data-bs-target="#modalNuevoVehiculo">
                        <i class="bi bi-plus-lg"></i> Agregar Vehículo
                    </button>
                </div>
                @endif
            </div>

        </div>
    </div>

    <!-- ══════════════════════════════════
         MODAL — NUEVO VEHÍCULO
    ══════════════════════════════════ -->
    <div class="modal fade" id="modalNuevoVehiculo" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
        <div class="modal-content">

            <div class="modal-header">
                <div class="modal-header-inner">
                    <div class="modal-title-group">
                        <div class="modal-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                        <div>
                            <div class="modal-title-text" id="modalTitle">Nuevo Vehículo</div>
                            <div class="modal-subtitle-text">Completa los datos para registrar en el inventario</div>
                        </div>
                    </div>
                    <button class="btn-close-custom" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg"></i>
                    </button>
                </div>
            </div>

            <form action="{{ route('autos.store') }}" method="POST" id="formVehiculo">
                @csrf
                <input type="hidden" name="_method" id="methodField" value="POST">
                
                <div class="modal-body">
                    <div class="row g-4">

                        <div class="col-lg-6">

                            <div class="form-section">
                                <div class="form-section-title">Identificación</div>
                                <div class="row g-3">
                                    <div class="col-12">
                                        <div class="field-group">
                                            <label class="field-label">Marca <span class="required">*</span></label>
                                            <select class="field-input" name="id_marca" id="id_marca" required>
                                                <option value="">— Selecciona una marca —</option>
                                                @foreach($marcas as $marca)
                                                    <option value="{{ $marca->id_marca }}">
                                                        {{ $marca->nombre }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-8">
                                        <div class="field-group">
                                            <label class="field-label">Modelo <span class="required">*</span></label>
                                            <input type="text" class="field-input" name="modelo" id="modelo"
                                                placeholder="Corolla, Civic, Sentra..." required>
                                        </div>
                                    </div>
                                    <div class="col-4">
                                        <div class="field-group">
                                            <label class="field-label">Año <span class="required">*</span></label>
                                            <input type="number" class="field-input" name="year" id="year"
                                                placeholder="{{ date('Y') }}"
                                                min="1900" max="{{ date('Y') + 1 }}" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Tipo <span class="required">*</span></label>
                                            <select class="field-input" name="tipo" id="tipo" required>
                                                <option value="">Seleccionar</option>
                                                <option value="Sedán">Sedán</option>
                                                <option value="SUV">SUV</option>
                                                <option value="Pickup">Pickup</option>
                                                <option value="Hatchback">Hatchback</option>
                                                <option value="Coupé">Coupé</option>
                                                <option value="Convertible">Convertible</option>
                                                <option value="Van">Van</option>
                                                <option value="Deportivo">Deportivo</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Color <span class="required">*</span></label>
                                            <input type="text" class="field-input" name="color" id="color"
                                                placeholder="Negro, Blanco, Rojo..." required>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="form-section-title">Mecánica</div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Transmisión <span class="required">*</span></label>
                                            <select class="field-input" name="transmision" id="transmision" required>
                                                <option value="">Seleccionar</option>
                                                <option value="Manual">Manual</option>
                                                <option value="Automática">Automática</option>
                                                <option value="CVT">CVT</option>
                                                <option value="Dual Clutch">Dual Clutch</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Combustible <span class="required">*</span></label>
                                            <select class="field-input" name="combustible" id="combustible" required>
                                                <option value="">Seleccionar</option>
                                                <option value="Gasolina">Gasolina</option>
                                                <option value="Diésel">Diésel</option>
                                                <option value="Eléctrico">Eléctrico</option>
                                                <option value="Híbrido">Híbrido</option>
                                                <option value="Híbrido Enchufable">Híbrido Enchufable</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="form-section">
                                <div class="form-section-title">Comercialización</div>
                                <div class="row g-3">
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Kilometraje <span class="required">*</span></label>
                                            <input type="number" class="field-input" name="kilometraje" id="kilometraje"
                                                placeholder="50,000" min="0" required>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="field-group">
                                            <label class="field-label">Precio de Venta <span class="required">*</span></label>
                                            <input type="number" class="field-input" name="precio" id="precio"
                                                placeholder="25,000" min="0" step="0.01" required>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-3">
                                    <div class="toggle-row">
                                        <div class="toggle-info">
                                            <div class="toggle-info-icon"><i class="bi bi-eye-slash"></i></div>
                                            <div>
                                                <div class="toggle-label">Ocultar kilometraje</div>
                                                <div class="toggle-desc">No se mostrará en el catálogo público</div>
                                            </div>
                                        </div>
                                        <div class="form-switch-custom form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="ocultar_kilometraje" id="ocultar_kilometraje" value="1">
                                        </div>
                                    </div>

                                    <div class="toggle-row">
                                        <div class="toggle-info">
                                            <div class="toggle-info-icon"><i class="bi bi-bookmark-star"></i></div>
                                            <div>
                                                <div class="toggle-label">En consignación</div>
                                                <div class="toggle-desc">Vehículo de cliente externo</div>
                                            </div>
                                        </div>
                                        <div class="form-switch-custom form-check">
                                            <input class="form-check-input" type="checkbox"
                                                name="consignacion" id="consignacion" value="1">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-section">
                                <div class="form-section-title">Notas</div>
                                <div class="field-group" style="margin-bottom: 0;">
                                    <label class="field-label">Descripción <span style="color:var(--gray-300); font-weight:400;">(Opcional)</span></label>
                                    <textarea class="field-input" name="descripcion" id="descripcion" rows="4"
                                        placeholder="Características especiales..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer-custom">
                    <span class="footer-note">
                        <i class="bi bi-shield-check"></i>
                        Los campos con <span style="color:var(--gold);font-weight:700;margin:0 2px;">*</span> son requeridos
                    </span>
                    <div class="footer-actions">
                        <button type="button" class="btn-cancel" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn-submit" id="btnSubmit">
                            <i class="bi bi-plus-lg" id="btnSubmitIcon"></i>
                            <span id="btnSubmitText">Registrar Vehículo</span>
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    </div>

    <!-- DATA PARA JS -->
    <div id="laravel-data"
        data-has-errors="{{ $errors->any() ? 'true' : 'false' }}"
        data-success="{{ session('success') }}"
        data-error-msg="{{ $errors->first() }}">
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/autos.js') }}"></script>

    @if(session('success'))
    <script>
        Swal.fire({
            title: '¡Logrado!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonColor: '#1e293b', // Ajusta al color de tu VMS
            confirmButtonText: 'Genial'
        });
    </script>
@endif
</body>
</html>