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
    <link
        href="https://fonts.googleapis.com/css2?family=Orbitron:wght@400;500;700;900&family=Outfit:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


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
                        <a class="nav-link active">
                            <i class="bi bi-speedometer2 me-1"></i> Dashboard
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <i class="bi bi-car-front me-1"></i> Vehículos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
                            <i class="bi bi-tag me-1"></i> Marcas
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link">
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
                <p>Bienvenido de nuevo, {{ Auth::user()->nombre ?? 'Administrador' }}. Aquí está el resumen de tu
                    inventario.</p>
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
                    <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#modalNuevoVehiculo">
                        <i class="bi bi-plus-circle-fill"></i>
                        <span>Nuevo Vehículo</span>
                    </a>
                    <a href="#" class="action-btn" data-bs-toggle="modal" data-bs-target="#modalNuevaMarca">
                        <i class="bi bi-tag-fill"></i>
                        <span>Nueva Marca</span>
                    </a>
                    <a class="action-btn">
                        <i class="bi bi-images"></i>
                        <span>Subir Imágenes</span>
                    </a>
                    <a class="action-btn">
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

    <!-- Modal Nuevo Vehículo -->
    <div class="modal fade" id="modalNuevoVehiculo" tabindex="-1" aria-labelledby="modalNuevoVehiculoLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevoVehiculoLabel">
                        <i class="bi bi-car-front-fill"></i>
                        Registrar Nuevo Vehículo
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('autos.store') }}" method="POST" id="formNuevoVehiculo">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <!-- Columna Izquierda -->
                            <div class="col-md-6">
                                <!-- Marca -->
                                <!-- Marca -->
                                <div class="mb-3">
                                    <label for="id_marca" class="form-label-modal">
                                        <i class="bi bi-tag-fill"></i>
                                        Marca
                                    </label>
                                    <select class="form-control-select" id="id_marca" name="id_marca" required>
                                        <option value="" disabled selected hidden>Selecciona una marca</option>
                                        @foreach($marcas as $marca)
                                            <option value="{{ $marca->id_marca }}" {{ old('id_marca') == $marca->id_marca ? 'selected' : '' }}>
                                                {{ $marca->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <!-- Modelo -->
                                <div class="mb-3">
                                    <label for="modelo" class="form-label-modal">
                                        <i class="bi bi-car-front"></i>
                                        Modelo
                                    </label>
                                    <input type="text" class="form-control-modal" id="modelo" name="modelo"
                                        placeholder="Ej: Corolla, Civic, Sentra..." required>
                                </div>

                                <!-- Tipo -->
                                <div class="mb-3">
                                    <label for="tipo" class="form-label-modal">
                                        <i class="bi bi-truck"></i>
                                        Tipo de Vehículo
                                    </label>
                                    <select class="form-control-select" id="tipo" name="tipo" required>
                                        <option value="">Selecciona el tipo</option>
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

                                <!-- Año -->
                                <div class="mb-3">
                                    <label for="year" class="form-label-modal">
                                        <i class="bi bi-calendar-event"></i>
                                        Año
                                    </label>
                                    <input type="number" class="form-control-modal" id="year" name="year"
                                        placeholder="2024" min="1900" max="{{ date('Y') + 1 }}" required>
                                </div>

                                <!-- Color -->
                                <div class="mb-3">
                                    <label for="color" class="form-label-modal">
                                        <i class="bi bi-palette-fill"></i>
                                        Color
                                    </label>
                                    <input type="text" class="form-control-modal" id="color" name="color"
                                        placeholder="Ej: Negro, Blanco, Rojo..." required>
                                </div>

                                <!-- Transmisión -->
                                <div class="mb-3">
                                    <label for="transmision" class="form-label-modal">
                                        <i class="bi bi-gear-fill"></i>
                                        Transmisión
                                    </label>
                                    <select class="form-control-select" id="transmision" name="transmision" required>
                                        <option value="">Selecciona transmisión</option>
                                        <option value="Manual">Manual</option>
                                        <option value="Automática">Automática</option>
                                        <option value="CVT">CVT</option>
                                        <option value="Dual Clutch">Dual Clutch</option>
                                    </select>
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-6">
                                <!-- Combustible -->
                                <div class="mb-3">
                                    <label for="combustible" class="form-label-modal">
                                        <i class="bi bi-fuel-pump-fill"></i>
                                        Combustible
                                    </label>
                                    <select class="form-control-select" id="combustible" name="combustible" required>
                                        <option value="">Selecciona combustible</option>
                                        <option value="Gasolina">Gasolina</option>
                                        <option value="Diésel">Diésel</option>
                                        <option value="Eléctrico">Eléctrico</option>
                                        <option value="Híbrido">Híbrido</option>
                                        <option value="Híbrido Enchufable">Híbrido Enchufable</option>
                                    </select>
                                </div>

                                <!-- Kilometraje -->
                                <div class="mb-3">
                                    <label for="kilometraje" class="form-label-modal">
                                        <i class="bi bi-speedometer"></i>
                                        Kilometraje
                                    </label>
                                    <input type="number" class="form-control-modal" id="kilometraje" name="kilometraje"
                                        placeholder="50000" min="0" required>
                                </div>

                                <!-- Ocultar Kilometraje -->
                                <div class="mb-3">
                                    <div class="form-check" style="padding-left: 0;">
                                        <label class="form-label-modal" style="margin-bottom: 0.5rem;">
                                            <input type="checkbox" class="form-check-input" id="ocultar_kilometraje"
                                                name="ocultar_kilometraje" value="1" style="margin-right: 0.5rem;">
                                            <i class="bi bi-eye-slash"></i>
                                            Ocultar kilometraje en catálogo
                                        </label>
                                    </div>
                                </div>

                                <!-- Precio -->
                                <div class="mb-3">
                                    <label for="precio" class="form-label-modal">
                                        <i class="bi bi-currency-dollar"></i>
                                        Precio de Venta
                                    </label>
                                    <input type="number" class="form-control-modal" id="precio" name="precio"
                                        placeholder="25000" min="0" step="0.01" required>
                                </div>

                                <!-- Consignación -->
                                <div class="mb-3">
                                    <div class="form-check" style="padding-left: 0;">
                                        <label class="form-label-modal" style="margin-bottom: 0.5rem;">
                                            <input type="checkbox" class="form-check-input" id="consignacion"
                                                name="consignacion" value="1" style="margin-right: 0.5rem;">
                                            <i class="bi bi-bookmark-star"></i>
                                            Vehículo en consignación
                                        </label>
                                    </div>
                                </div>

                                <!-- Descripción -->
                                <div class="mb-3">
                                    <label for="descripcion" class="form-label-modal">
                                        <i class="bi bi-card-text"></i>
                                        Descripción (Opcional)
                                    </label>
                                    <textarea class="form-control-modal" id="descripcion" name="descripcion" rows="3"
                                        placeholder="Características adicionales del vehículo..."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-modal-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Vehículo
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <!-- Modal Nueva Marca -->
    <div class="modal fade" id="modalNuevaMarca" tabindex="-1" aria-labelledby="modalNuevaMarcaLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalNuevaMarcaLabel">
                        <i class="bi bi-tag-fill"></i>
                        Registrar Nueva Marca
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('marcas.store') }}" method="POST" enctype="multipart/form-data"
                    id="formNuevaMarca">
                    @csrf
                    <div class="modal-body">
                        @if(session('success'))
                            <div class="alert-success-modal">
                                <i class="bi bi-check-circle-fill"></i>
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert-danger-modal">
                                <i class="bi bi-exclamation-triangle-fill"></i>
                                <div>
                                    @foreach($errors->all() as $error)
                                        <div>{{ $error }}</div>
                                    @endforeach
                                </div>
                            </div>
                        @endif

                        <!-- Nombre de la Marca -->
                        <div class="mb-4">
                            <label for="nombre" class="form-label-modal">
                                <i class="bi bi-pencil-fill"></i>
                                Nombre de la Marca
                            </label>
                            <input type="text" class="form-control-modal @error('nombre') is-invalid @enderror"
                                id="nombre" name="nombre" placeholder="Ej: Toyota, Honda, Nissan..."
                                value="{{ old('nombre') }}" required>
                            @error('nombre')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Imagen/Logo -->
                        <div class="mb-4">
                            <label class="form-label-modal">
                                <i class="bi bi-image-fill"></i>
                                Logo de la Marca
                            </label>
                            <div class="file-upload-wrapper">
                                <input type="file" class="@error('imagen') is-invalid @enderror" id="imagen"
                                    name="imagen" accept="image/jpeg,image/png,image/jpg" required
                                    onchange="previewImage(event)">
                                <div class="file-upload-icon">
                                    <i class="bi bi-cloud-upload-fill"></i>
                                </div>
                                <div class="file-upload-text">
                                    Haz clic o arrastra una imagen aquí
                                </div>
                                <div class="file-upload-hint">
                                    Formatos: JPG, JPEG, PNG (Máx. 2MB)
                                </div>
                            </div>
                            <div id="imagePreview" style="display: none; text-align: center;">
                                <img id="preview" class="preview-image" alt="Preview">
                                <div class="file-name-display">
                                    <i class="bi bi-file-earmark-image"></i>
                                    <span id="fileName"></span>
                                </div>
                            </div>
                            @error('imagen')
                                <div class="invalid-feedback d-block">
                                    <i class="bi bi-exclamation-circle"></i> {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-modal-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle me-2"></i>Cancelar
                        </button>
                        <button type="submit" class="btn btn-modal-primary">
                            <i class="bi bi-check-circle me-2"></i>Guardar Marca
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div id="laravel-data" data-has-errors="{{ $errors->any() ? 'true' : 'false' }}"
        data-success="{{ session('success') }}" data-error-msg="{{ $errors->first() }}">
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/dashboard.js') }}"></script>

</body>

</html>