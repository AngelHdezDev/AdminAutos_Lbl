@extends('layouts.app')

@section('title', 'Inventario de Vehículos')

@push('styles')
<link rel="stylesheet" href="{{ asset('css/autos.css') }}">
@endpush



@section('content')
 <!-- ── PAGE HEADER ── -->
    <div class="page-header">
        <div class="container-fluid px-4">
            <div class="page-header-inner">
                <div>
                    <p class="page-eyebrow">Inventario</p>
                    <h1 class="page-title">Vehículos</h1>
                    <p class="page-subtitle">
                        {{ $vehiculos->total() }} unidades registradas
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
                                        <!-- <a  class="btn-action" title="Ver detalle">
                                            <i class="bi bi-eye"></i>
                                        </a> -->
                                        <a class="btn-action btn-edit" 
                                            title="Editar" 
                                            data-bs-toggle="modal" 
                                            data-bs-target="#modalNuevoVehiculo" {{-- Corregido: antes decía #modalVehiculo --}}
                                            data-id="{{ $vehiculo->id_auto }}"
                                            data-modelo="{{ $vehiculo->modelo }}"
                                            data-id_marca="{{ $vehiculo->id_marca }}"
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
                </div>
                @if($vehiculos->hasPages())
                        <div class="pagination-wrapper">
                            <div class="w-100">
                                @if($vehiculos->total() > 0)
                                    <div class="pagination-info">
                                        Mostrando <strong>{{ $vehiculos->firstItem() }}</strong> a <strong>{{ $vehiculos->lastItem() }}</strong>
                                        de <strong>{{ $vehiculos->total() }}</strong> vehículos
                                    </div>
                                @endif
                                <div class="d-flex justify-content-center">
                                    {{ $vehiculos->appends(['search' => request('search')])->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        </div>
                @endif
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

    <!-- 
         MODAL — NUEVO VEHÍCULO
    -->
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


@endsection






    

   