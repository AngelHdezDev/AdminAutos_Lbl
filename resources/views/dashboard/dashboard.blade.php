<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - VMS</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --vms-dark: #0a0e27;
            --vms-accent: #00d4ff;
            --vms-secondary: #ff6b35;
            --vms-success: #4ecca3;
            --vms-warning: #ffd700;
            --vms-purple: #a855f7;
            --vms-bg: #0f1535;
            --vms-card: #1a1f3a;
            --vms-text: #e4e8f0;
            --vms-text-muted: #8891a8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Outfit', sans-serif;
            background: var(--vms-bg);
            color: var(--vms-text);
            overflow-x: hidden;
        }

        /* Background Effects */
        body::before {
            content: '';
            position: fixed;
            top: -50%;
            right: -20%;
            width: 800px;
            height: 800px;
            background: radial-gradient(circle, rgba(0, 212, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 20s ease-in-out infinite;
        }

        body::after {
            content: '';
            position: fixed;
            bottom: -30%;
            left: -10%;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(168, 85, 247, 0.1) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
            animation: float 25s ease-in-out infinite reverse;
        }

        @keyframes float {
            0%, 100% { transform: translate(0, 0) scale(1); }
            50% { transform: translate(-50px, 50px) scale(1.1); }
        }

        /* Navbar */
        .navbar-vms {
            background: rgba(26, 31, 58, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: 1px solid rgba(0, 212, 255, 0.1);
            padding: 1rem 0;
            position: sticky;
            top: 0;
            z-index: 1000;
            box-shadow: 0 4px 30px rgba(0, 0, 0, 0.3);
        }

        .navbar-brand {
            font-family: 'Orbitron', sans-serif;
            font-weight: 900;
            font-size: 1.5rem;
            color: var(--vms-accent) !important;
            text-transform: uppercase;
            letter-spacing: 2px;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .navbar-brand i {
            font-size: 2rem;
            animation: pulse-glow 2s ease-in-out infinite;
        }

        @keyframes pulse-glow {
            0%, 100% { 
                filter: drop-shadow(0 0 5px var(--vms-accent));
                transform: scale(1);
            }
            50% { 
                filter: drop-shadow(0 0 15px var(--vms-accent));
                transform: scale(1.05);
            }
        }

        .nav-link {
            color: var(--vms-text) !important;
            font-weight: 500;
            padding: 0.5rem 1rem !important;
            position: relative;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--vms-accent) !important;
            transform: translateY(-2px);
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            width: 0;
            height: 2px;
            background: var(--vms-accent);
            transition: all 0.3s ease;
            transform: translateX(-50%);
        }

        .nav-link:hover::after {
            width: 80%;
        }

        .user-menu {
            background: rgba(0, 212, 255, 0.1);
            border: 1px solid rgba(0, 212, 255, 0.3);
            padding: 0.5rem 1.2rem;
            border-radius: 50px;
            color: var(--vms-accent);
            font-weight: 600;
            display: flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .user-menu:hover {
            background: rgba(0, 212, 255, 0.2);
            transform: scale(1.05);
        }

        /* Main Content */
        .main-content {
            position: relative;
            z-index: 1;
            padding: 2rem 0 4rem;
        }

        /* Header Section */
        .dashboard-header {
            margin-bottom: 3rem;
            animation: slideDown 0.6s ease-out;
        }

        @keyframes slideDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .dashboard-header h1 {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            font-size: 2.5rem;
            background: linear-gradient(135deg, var(--vms-accent) 0%, var(--vms-purple) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .dashboard-header p {
            color: var(--vms-text-muted);
            font-size: 1.1rem;
        }

        /* Stats Cards */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .stat-card {
            background: linear-gradient(135deg, var(--vms-card) 0%, rgba(26, 31, 58, 0.8) 100%);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: all 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            animation: fadeInUp 0.6s ease-out backwards;
        }

        .stat-card:nth-child(1) { animation-delay: 0.1s; }
        .stat-card:nth-child(2) { animation-delay: 0.2s; }
        .stat-card:nth-child(3) { animation-delay: 0.3s; }
        .stat-card:nth-child(4) { animation-delay: 0.4s; }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .stat-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 4px;
            background: linear-gradient(90deg, transparent, var(--card-color), transparent);
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
        }

        .stat-card:hover {
            transform: translateY(-10px);
            border-color: var(--card-color);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.4), 0 0 30px var(--card-color-alpha);
        }

        .stat-card.accent { 
            --card-color: var(--vms-accent); 
            --card-color-alpha: rgba(0, 212, 255, 0.3);
        }
        .stat-card.secondary { 
            --card-color: var(--vms-secondary); 
            --card-color-alpha: rgba(255, 107, 53, 0.3);
        }
        .stat-card.success { 
            --card-color: var(--vms-success); 
            --card-color-alpha: rgba(78, 204, 163, 0.3);
        }
        .stat-card.warning { 
            --card-color: var(--vms-warning); 
            --card-color-alpha: rgba(255, 215, 0, 0.3);
        }

        .stat-icon {
            width: 70px;
            height: 70px;
            background: rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 2rem;
            color: var(--card-color);
            margin-bottom: 1.5rem;
            border: 2px solid rgba(255, 255, 255, 0.1);
            transition: all 0.3s ease;
        }

        .stat-card:hover .stat-icon {
            transform: rotate(10deg) scale(1.1);
            background: var(--card-color-alpha);
            border-color: var(--card-color);
        }

        .stat-value {
            font-family: 'Orbitron', sans-serif;
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--card-color);
            margin-bottom: 0.5rem;
            line-height: 1;
        }

        .stat-label {
            font-size: 0.95rem;
            color: var(--vms-text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .stat-change {
            display: inline-flex;
            align-items: center;
            gap: 0.3rem;
            margin-top: 0.8rem;
            font-size: 0.85rem;
            padding: 0.3rem 0.8rem;
            border-radius: 20px;
            font-weight: 600;
        }

        .stat-change.positive {
            background: rgba(78, 204, 163, 0.2);
            color: var(--vms-success);
        }

        .stat-change.negative {
            background: rgba(255, 107, 53, 0.2);
            color: var(--vms-secondary);
        }

        /* Quick Actions */
        .quick-actions {
            margin-bottom: 3rem;
        }

        .section-title {
            font-family: 'Orbitron', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--vms-text);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.8rem;
        }

        .section-title::before {
            content: '';
            width: 4px;
            height: 30px;
            background: linear-gradient(180deg, var(--vms-accent), var(--vms-purple));
            border-radius: 2px;
        }

        .action-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(220px, 1fr));
            gap: 1.2rem;
        }

        .action-btn {
            background: rgba(26, 31, 58, 0.6);
            border: 2px solid rgba(255, 255, 255, 0.1);
            border-radius: 16px;
            padding: 1.8rem 1.5rem;
            color: var(--vms-text);
            text-decoration: none;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 1rem;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .action-btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.1), transparent);
            transition: left 0.5s ease;
        }

        .action-btn:hover::before {
            left: 100%;
        }

        .action-btn:hover {
            transform: translateY(-5px);
            border-color: var(--vms-accent);
            background: rgba(0, 212, 255, 0.1);
            color: var(--vms-accent);
            box-shadow: 0 10px 30px rgba(0, 212, 255, 0.2);
        }

        .action-btn i {
            font-size: 2.5rem;
            transition: all 0.3s ease;
        }

        .action-btn:hover i {
            transform: scale(1.2) rotate(5deg);
        }

        .action-btn span {
            font-weight: 600;
            font-size: 1rem;
        }

        /* Recent Activity */
        .activity-section {
            margin-bottom: 3rem;
        }

        .activity-card {
            background: rgba(26, 31, 58, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
        }

        .activity-item {
            display: flex;
            align-items: start;
            gap: 1.2rem;
            padding: 1.2rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            margin-bottom: 1rem;
            border-left: 3px solid transparent;
            transition: all 0.3s ease;
        }

        .activity-item:hover {
            background: rgba(255, 255, 255, 0.05);
            border-left-color: var(--vms-accent);
            transform: translateX(5px);
        }

        .activity-icon {
            width: 45px;
            height: 45px;
            background: rgba(0, 212, 255, 0.15);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--vms-accent);
            font-size: 1.3rem;
            flex-shrink: 0;
        }

        .activity-content {
            flex: 1;
        }

        .activity-title {
            font-weight: 600;
            color: var(--vms-text);
            margin-bottom: 0.3rem;
        }

        .activity-meta {
            font-size: 0.85rem;
            color: var(--vms-text-muted);
        }

        .activity-time {
            color: var(--vms-accent);
            font-size: 0.8rem;
            white-space: nowrap;
        }

        /* Charts Section */
        .charts-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(400px, 1fr));
            gap: 1.5rem;
            margin-bottom: 3rem;
        }

        .chart-card {
            background: rgba(26, 31, 58, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            padding: 2rem;
        }

        .chart-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .chart-title {
            font-family: 'Orbitron', sans-serif;
            font-weight: 600;
            font-size: 1.2rem;
            color: var(--vms-text);
        }

        .chart-badge {
            background: rgba(0, 212, 255, 0.15);
            color: var(--vms-accent);
            padding: 0.4rem 1rem;
            border-radius: 20px;
            font-size: 0.8rem;
            font-weight: 600;
        }

        /* Brand List */
        .brand-item {
            display: flex;
            align-items: center;
            gap: 1rem;
            padding: 1rem;
            background: rgba(255, 255, 255, 0.02);
            border-radius: 12px;
            margin-bottom: 0.8rem;
            transition: all 0.3s ease;
        }

        .brand-item:hover {
            background: rgba(255, 255, 255, 0.05);
            transform: translateX(5px);
        }

        .brand-logo {
            width: 50px;
            height: 50px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            color: var(--vms-accent);
        }

        .brand-info {
            flex: 1;
        }

        .brand-name {
            font-weight: 600;
            color: var(--vms-text);
            margin-bottom: 0.2rem;
        }

        .brand-count {
            font-size: 0.85rem;
            color: var(--vms-text-muted);
        }

        .brand-value {
            font-family: 'Orbitron', sans-serif;
            font-weight: 700;
            color: var(--vms-success);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .dashboard-header h1 {
                font-size: 2rem;
            }

            .stats-grid {
                grid-template-columns: 1fr;
            }

            .charts-grid {
                grid-template-columns: 1fr;
            }

            .action-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        @media (max-width: 576px) {
            .action-grid {
                grid-template-columns: 1fr;
            }

            .navbar-brand {
                font-size: 1.2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-vms">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">
                <i class="bi bi-car-front-fill"></i>
                VMS
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link active" >
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" >
                            <i class="bi bi-car-front me-1"></i> Vehículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" >
                            <i class="bi bi-tag me-1"></i> Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" >
                            <i class="bi bi-graph-up me-1"></i> Reportes
                        </a>
                    </li>
                </ul>
                <div class="d-flex align-items-center gap-3">
                    <a href="#" class="user-menu">
                        <i class="bi bi-person-circle"></i>
                        {{ Auth::user()->nombre ?? 'Usuario' }}
                    </a>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="btn btn-link nav-link">
                            <i class="bi bi-box-arrow-right"></i>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="container-fluid">
            <!-- Header -->
            <div class="dashboard-header">
                <h1>Centro de Control VMS</h1>
                <p>Bienvenido de nuevo, {{ Auth::user()->nombre ?? 'Administrador' }}. Aquí está el resumen de tu inventario.</p>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card accent">
                    <div class="stat-icon">
                        <i class="bi bi-car-front-fill"></i>
                    </div>
                    <div class="stat-value">{{ $totalVehiculos ?? 47 }}</div>
                    <div class="stat-label">Vehículos en Stock</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +12% este mes
                    </div>
                </div>

                <div class="stat-card success">
                    <div class="stat-icon">
                        <i class="bi bi-cash-stack"></i>
                    </div>
                    <div class="stat-value">${{ number_format($valorInventario ?? 2450000, 0) }}</div>
                    <div class="stat-label">Valor Inventario</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +8.5% trimestre
                    </div>
                </div>

                <div class="stat-card secondary">
                    <div class="stat-icon">
                        <i class="bi bi-bookmark-star-fill"></i>
                    </div>
                    <div class="stat-value">{{ $totalConsignacion ?? 12 }}</div>
                    <div class="stat-label">En Consignación</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i> +3 nuevos
                    </div>
                </div>

                <div class="stat-card warning">
                    <div class="stat-icon">
                        <i class="bi bi-tags-fill"></i>
                    </div>
                    <div class="stat-value">{{ $totalMarcas ?? 15 }}</div>
                    <div class="stat-label">Marcas Activas</div>
                    <div class="stat-change negative">
                        <i class="bi bi-arrow-down"></i> -2 descontinuadas
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="quick-actions">
                <h2 class="section-title">Acciones Rápidas</h2>
                <div class="action-grid">
                    <a  class="action-btn">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Nuevo Vehículo</span>
                    </a>
                    <a  class="action-btn">
                        <i class="bi bi-tag-fill"></i>
                        <span>Nueva Marca</span>
                    </a>
                    <a  class="action-btn">
                        <i class="bi bi-images"></i>
                        <span>Subir Imágenes</span>
                    </a>
                    <a  class="action-btn">
                        <i class="bi bi-file-earmark-bar-graph"></i>
                        <span>Ver Reportes</span>
                    </a>
                </div>
            </div>

            <!-- Charts and Lists -->
            <div class="charts-grid">
                <!-- Recent Activity -->
                <div class="activity-section">
                    <h2 class="section-title">Actividad Reciente</h2>
                    <div class="activity-card">
                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Nuevo vehículo registrado</div>
                                <div class="activity-meta">Toyota Corolla 2023 - Negro - $18,500</div>
                            </div>
                            <div class="activity-time">Hace 2h</div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-camera"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Galería actualizada</div>
                                <div class="activity-meta">8 imágenes añadidas a Honda Civic</div>
                            </div>
                            <div class="activity-time">Hace 5h</div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-pencil-square"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Precio actualizado</div>
                                <div class="activity-meta">Nissan Sentra 2022 - Nuevo precio: $16,200</div>
                            </div>
                            <div class="activity-time">Ayer</div>
                        </div>

                        <div class="activity-item">
                            <div class="activity-icon">
                                <i class="bi bi-bookmark-check"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Consignación aceptada</div>
                                <div class="activity-meta">Mazda 3 2021 - Comisión: 15%</div>
                            </div>
                            <div class="activity-time">Hace 2 días</div>
                        </div>
                    </div>
                </div>

                <!-- Top Brands -->
                <div class="activity-section">
                    <h2 class="section-title">Marcas Top</h2>
                    <div class="chart-card">
                        <div class="brand-item">
                            <div class="brand-logo">T</div>
                            <div class="brand-info">
                                <div class="brand-name">Toyota</div>
                                <div class="brand-count">12 vehículos</div>
                            </div>
                            <div class="brand-value">$342K</div>
                        </div>

                        <div class="brand-item">
                            <div class="brand-logo">N</div>
                            <div class="brand-info">
                                <div class="brand-name">Nissan</div>
                                <div class="brand-count">9 vehículos</div>
                            </div>
                            <div class="brand-value">$198K</div>
                        </div>

                        <div class="brand-item">
                            <div class="brand-logo">H</div>
                            <div class="brand-info">
                                <div class="brand-name">Honda</div>
                                <div class="brand-count">8 vehículos</div>
                            </div>
                            <div class="brand-value">$176K</div>
                        </div>

                        <div class="brand-item">
                            <div class="brand-logo">M</div>
                            <div class="brand-info">
                                <div class="brand-name">Mazda</div>
                                <div class="brand-count">7 vehículos</div>
                            </div>
                            <div class="brand-value">$154K</div>
                        </div>

                        <div class="brand-item">
                            <div class="brand-logo">V</div>
                            <div class="brand-info">
                                <div class="brand-name">Volkswagen</div>
                                <div class="brand-count">5 vehículos</div>
                            </div>
                            <div class="brand-value">$112K</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>