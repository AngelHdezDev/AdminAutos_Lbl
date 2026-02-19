@extends('layouts.app')

@section('title', 'Dashboard')

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/dashboard.css') }}">
@endpush

@section('content')


    <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="container-fluid px-4">
            <p class="page-eyebrow">Sistema de Gestión</p>
            <h1 class="page-title">Dashboard</h1>
            <p class="page-subtitle">
                Resumen general del inventario y operaciones
            </p>
        </div>
    </div>

    <!-- ── MAIN CONTENT ── -->
    <div class="main-wrapper">
        <div class="container-fluid px-4">

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="bi bi-car-front-fill"></i>
                        </div>
                    </div>
                    <div class="stat-label">Total Vehículos</div>
                    <div class="stat-value">{{ $totalVehiculos ?? 0 }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        +{{ $diffVehiculos ?? 0 }}% este mes
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="bi bi-cash-stack"></i>
                        </div>
                    </div>
                    <div class="stat-label">Valor Inventario</div>
                    <div class="stat-value">${{ number_format($valorInventario ?? 0, 0) }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        +{{ $diffInventario ?? 0 }}% trimestre
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="bi bi-bookmark-star-fill"></i>
                        </div>
                    </div>
                    <div class="stat-label">En Consignación</div>
                    <div class="stat-value">{{ $totalConsignacion ?? 0 }}</div>
                    <div class="stat-change positive">
                        <i class="bi bi-arrow-up"></i>
                        +{{ $consignacionNuevos ?? 0 }} nuevos
                    </div>
                </div>

                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon">
                            <i class="bi bi-tags-fill"></i>
                        </div>
                    </div>
                    <div class="stat-label">Marcas Activas</div>
                    <div class="stat-value">{{ $totalMarcas ?? 0 }}</div>
                    <div class="stat-change negative">
                        <i class="bi bi-arrow-down"></i>
                        -{{ $marcasDescontinuadas ?? 0 }} descontinuadas
                    </div>
                </div>
            </div>

            <!-- Content Grid -->
            <div class="content-grid">

                <!-- Recent Vehicles -->
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="bi bi-clock-history"></i>
                            Vehículos Recientes
                        </h2>
                        <a href="{{ route('autos.index') }}" class="card-link">
                            Ver todos →
                        </a>
                    </div>
                    <div class="card-body">
                        @if(isset($vehiculosRecientes) && count($vehiculosRecientes) > 0)
                            @foreach($vehiculosRecientes as $vehiculo)
                                <div class="vehicle-list-item">
                                    <div class="vehicle-thumb">
                                        @if($vehiculo->imagenes && $vehiculo->imagenes->count() > 0)
                                            <img src="{{ asset('storage/' . $vehiculo->imagenes->first()->thumbnail) }}" alt="">
                                        @else
                                            <i class="bi bi-car-front"></i>
                                        @endif
                                    </div>
                                    <div class="vehicle-info">
                                        <div class="vehicle-name">{{ $vehiculo->marca->nombre ?? '' }} {{ $vehiculo->modelo }}
                                        </div>
                                        <div class="vehicle-meta">{{ $vehiculo->year }} · {{ $vehiculo->color }} ·
                                            {{ $vehiculo->tipo }}
                                        </div>
                                    </div>
                                    <div class="vehicle-price">${{ number_format($vehiculo->precio, 0) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-car-front"></i>
                                </div>
                                <p class="empty-text">No hay vehículos registrados</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Top Brands -->
                <div class="content-card">
                    <div class="card-header">
                        <h2 class="card-title">
                            <i class="bi bi-trophy"></i>
                            Ultimas Marcas Agregadas
                        </h2>
                        <a href="{{ route('marcas.index') }}" class="card-link">
                            Ver todas →
                        </a>
                    </div>
                    <div class="card-body">
                        @if(isset($marcasTop) && count($marcasTop) > 0)
                            @foreach($marcasTop as $marca)
                                <div class="brand-list-item">
                                    <div class="brand-logo-small">
                                        @if($marca->imagen)
                                            <img src="{{ asset($marca->imagen) }}" alt="{{ $marca->nombre }}">
                                        @else
                                            {{ strtoupper(substr($marca->nombre, 0, 1)) }}
                                        @endif
                                    </div>
                                    <div class="brand-info">
                                        <div class="brand-name">{{ $marca->nombre }}</div>
                                        <div class="brand-count">{{ $marca->vehiculos_count ?? 0 }} vehículos</div>
                                    </div>
                                    <div class="brand-value">${{ number_format($marca->valor_inventario ?? 0, 0) }}</div>
                                </div>
                            @endforeach
                        @else
                            <div class="empty-state">
                                <div class="empty-icon">
                                    <i class="bi bi-tag"></i>
                                </div>
                                <p class="empty-text">No hay marcas registradas</p>
                            </div>
                        @endif
                    </div>
                </div>

            </div>

            <!-- Activity Timeline -->
            <div class="content-card">
                <div class="card-header">
                    <h2 class="card-title">
                        <i class="bi bi-activity"></i>
                        Actividad Reciente
                    </h2>
                </div>
                <div class="card-body">
                    @if(isset($actividades) && count($actividades) > 0)
                        @foreach($actividades as $actividad)
                            <div class="activity-item">
                                <div class="activity-icon-wrapper">
                                    <i class="bi bi-{{ $actividad->icono ?? 'circle-fill' }}"></i>
                                </div>
                                <div class="activity-content">
                                    <div class="activity-title">{{ $actividad->titulo }}</div>
                                    <div class="activity-desc">{{ $actividad->descripcion }}</div>
                                </div>
                                <div class="activity-time">{{ $actividad->tiempo }}</div>
                            </div>
                        @endforeach
                    @else
                        <div class="activity-item">
                            <div class="activity-icon-wrapper">
                                <i class="bi bi-plus-circle"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Nuevo vehículo registrado</div>
                                <div class="activity-desc">Toyota Corolla 2023 · $18,500</div>
                            </div>
                            <div class="activity-time">Hace 2h</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-wrapper">
                                <i class="bi bi-camera"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Galería actualizada</div>
                                <div class="activity-desc">8 imágenes añadidas a Honda Civic</div>
                            </div>
                            <div class="activity-time">Hace 5h</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-wrapper">
                                <i class="bi bi-pencil"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Precio actualizado</div>
                                <div class="activity-desc">Nissan Sentra 2022 · Nuevo precio: $16,200</div>
                            </div>
                            <div class="activity-time">Ayer</div>
                        </div>
                        <div class="activity-item">
                            <div class="activity-icon-wrapper">
                                <i class="bi bi-bookmark-check"></i>
                            </div>
                            <div class="activity-content">
                                <div class="activity-title">Consignación aceptada</div>
                                <div class="activity-desc">Mazda 3 2021 · Comisión: 15%</div>
                            </div>
                            <div class="activity-time">Hace 2 días</div>
                        </div>
                    @endif
                </div>
            </div>

        </div>
    </div>

@endsection