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

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">

    
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