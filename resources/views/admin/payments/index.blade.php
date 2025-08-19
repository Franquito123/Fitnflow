@extends('layouts.admi-app-master')

@section('content')

<div class="container-fluid px-4 py-5">
    <!-- Encabezado Mejorado -->
    <div class="row mx-0">
    <div class="col-auto d-flex align-items-center gap-4 mb-3">
        <div class="logo-container bg-azul-marino text-white d-flex align-items-center justify-content-center"
            style="width: 150px; height: 45px; border-radius: 12px;">
            <i class="fas fa-credit-card" style="font-size: 1.8rem;"></i>
        </div>

            <div>
                <h1 class="fw-bold text-azul-marino mb-1" style="font-size: 1.9rem;">
                    FITINIFLOW
                </h1>
                <h2 class="fw-semibold text-azul-marino mb-1" style="font-size: 1.6rem;">
                    Gestión de Pagos
                </h2>
            </div>
        </div>
        <p class="text-muted" style="font-size: 1.5rem;">
            <i class="fas fa-info-circle me-2 text-verde-esmeralda"></i>Administra y revisa todos los pagos de membresías de tus clientes
        </p>
    </div>

    <!-- Filtro por estado - Diseño Premium -->
    <div class="card mb-5 border-0 shadow-lg">
        <div class="card-header bg-azul-marino text-white py-3">
            <h5 class="mb-0 fw-semibold" style="font-size: 1.4rem;">
                <i class="fas fa-filter me-2"></i>Filtros Avanzados
            </h5>
        </div>
        <div class="card-body bg-light-blue">
            <form action="{{ route('admin.payments.index') }}" method="GET">
                <div class="row g-4">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="estado" class="form-label fw-medium text-azul-marino mb-2" style="font-size: 1.4rem;">
                                <i class="fas fa-tag me-2"></i>Estado del Pago
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-circle text-azul-marino"></i>
                                </span>
                                <select name="estado" id="estado" class="form-select border-start-0 ps-2 estado-select" style="font-size: 1.3rem;" onchange="this.form.submit()">
                                    <option value="pendiente" class="text-warning" {{ request('estado', 'pendiente') == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                                    <option value="aprobado" class="text-success" {{ request('estado') == 'aprobado' ? 'selected' : '' }}>Aprobado</option>
                                    <option value="rechazado" class="text-danger" {{ request('estado') == 'rechazado' ? 'selected' : '' }}>Rechazado</option>
                                    <option value="vencido" class="text-secondary" {{ request('estado') == 'vencido' ? 'selected' : '' }}>Vencido</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="search" class="form-label fw-medium text-azul-marino mb-2" style="font-size: 1.4rem;">
                                <i class="fas fa-search me-2"></i>Buscar Usuario
                            </label>
                            <div class="input-group">
                                <span class="input-group-text bg-white border-end-0">
                                    <i class="fas fa-user text-azul-marino"></i>
                                </span>
                                <input 
                                    type="text"
                                    name="search"
                                    id="search"
                                    class="form-control border-start-0 ps-2"
                                    placeholder="Nombre, apellido o correo..."
                                    value="{{ request('search') }}"
                                    style="font-size: 1.3rem;"
                                >
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mt-4 gap-3">
                    <button type="submit" class="btn btn-primary px-4 py-2 fw-medium d-flex align-items-center" style="font-size: 1.3rem;">
                        <i class="fas fa-search me-2"></i> Aplicar Filtros
                    </button>
                    <a href="{{ route('admin.payments.index', ['estado' => request('estado', 'pendiente')]) }}" 
                        class="btn px-4 py-2 fw-medium d-flex align-items-center"
                        style="font-size: 1.3rem; background-color: #2EC4B6; color: white;">
                            <i class="fas fa-undo me-2"></i> Limpiar
                    </a>
                </div>
            </form>
        </div>
    </div>

    <!-- Resumen de totales - Tarjeta Moderna -->
    @if(request('estado') == 'aprobado')
    <div class="card mb-5 border-0 shadow-sm bg-gradient-primary">
        <div class="card-body py-3">
            <div class="row align-items-center">
                <div class="col-md-6 mb-3 mb-md-0">
                    <h6 class="text-white mb-0 fw-medium" style="font-size: 1.4rem;">
                        <i class="fas fa-chart-line me-2"></i>Resumen de Ventas
                    </h6>
                </div>
                <div class="col-md-6">
                    <div class="d-flex justify-content-between">
                        <div class="text-center">
                            <span class="d-block text-white fw-bold" style="font-size: 1.4rem;">${{ number_format($payments->sum('price'), 2) }}</span>
                            <small class="text-white-50" style="font-size: 1.3rem;">Total Ventas</small>
                        </div>
                        <div class="text-center">
                            <span class="d-block text-white fw-bold" style="font-size: 1.4rem;">{{ $payments->count() }}</span>
                            <small class="text-white-50" style="font-size: 1.3rem;">Membresías</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    <!-- Formulario de reportes - Diseño Profesional -->
    <div class="card mb-5 border-0 shadow-sm">
        <div class="card-header bg-white py-3 border-bottom">
            <h5 class="mb-0 fw-semibold text-azul-marino" style="font-size: 1.4rem;">
                <i class="fas fa-file-export me-2"></i>Generar Reportes
            </h5>
        </div>
        <div class="card-body">
            <form action="{{ route('admin.payments.report') }}" method="GET" id="report-form">
                <input type="hidden" name="estado" value="{{ request('estado', 'pendiente') }}">
                <input type="hidden" name="format" value="pdf">
                <input type="hidden" name="view" value="0" id="view-input">
                
                <div class="row g-4 align-items-end">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="mes" class="form-label fw-medium text-azul-marino mb-2" style="font-size: 1.4rem;">
                                <i class="fas fa-calendar-alt me-2"></i>Mes
                            </label>
                            <select name="mes" id="mes" class="form-select" style="font-size: 1.3rem;" required>
                                @foreach([
                                    1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
                                    5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
                                    9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
                                ] as $numero => $nombre)
                                    <option value="{{ $numero }}" {{ $numero == date('n') ? 'selected' : '' }}>{{ $nombre }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label for="anio" class="form-label fw-medium text-azul-marino mb-2" style="font-size: 1.4rem;">
                                <i class="fas fa-calendar me-2"></i>Año
                            </label>
                            <select name="anio" id="anio" class="form-select" required style="font-size: 1.3rem;">
                                @for ($i = date('Y'); $i <= date('Y') + 5; $i++)
                                    <option value="{{ $i }}" {{ $i == date('Y') ? 'selected' : '' }}>{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end gap-2">
                    <button type="submit" class="btn btn-sm w-100" style="font-size: 1.4rem; background-color: var(--naranja-brillante); color: var(--blanco);"
                        onclick="document.getElementById('view-input').value=0">
                        <i class="fas fa-file-download me-1"></i> Descargar PDF
                    </button>
                    <button type="submit" class="btn btn-sm w-100" style="font-size: 1.4rem; background-color: var(--verde-esmeralda); color: var(--blanco);"
                        onclick="document.getElementById('view-input').value=1; this.form.target='_blank';">
                        <i class="fas fa-eye me-1"></i> Ver PDF
                    </button>
                </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Contador y Paginación Superior - Estilo Moderno -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div class="d-flex align-items-center gap-3">
            <span class="badge bg-azul-marino text-white py-2 px-3 rounded-pill" style="font-size: 1.4rem;">
                <i class="fas fa-tag me-1"></i> {{ ucfirst(request('estado', 'pendiente')) }}
            </span>
            @if(request('estado') == 'aprobado')
            <span class="badge bg-success text-white py-2 px-3 rounded-pill" style="font-size: 1.4rem;">
                <i class="fas fa-dollar-sign me-1"></i> ${{ number_format($payments->sum('price'), 2) }}
            </span>
            @endif
            <span class="text-muted" style="font-size: 1.3rem;">
                Mostrando {{ $payments->firstItem() }} - {{ $payments->lastItem() }} de {{ $payments->total() }} registros
            </span>
        </div>
        
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link text-azul-marino" href="{{ $payments->previousPageUrl() }}" aria-label="Previous" style="font-size: 1.3rem;">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                    <li class="page-item {{ $payments->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link {{ $payments->currentPage() == $page ? 'bg-azul-marino text-white' : 'text-azul-marino' }}" 
                           href="{{ $url }}" style="font-size: 1.4rem;">{{ $page }}</a>
                    </li>
                @endforeach
                
                <li class="page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link text-azul-marino" href="{{ $payments->nextPageUrl() }}" aria-label="Next" style="font-size: 1.3rem;">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Tabla de pagos - Diseño Premium -->
    <div class="card border-0 shadow-lg mb-5 overflow-hidden">
        <div class="card-header bg-white py-3 border-bottom">
            <div class="d-flex justify-content-between align-items-center">
                <h5 class="mb-0 fw-semibold text-azul-marino" style="font-size: 1.5rem;">
                    <i class="fas fa-list-ul me-2"></i>Registros de Pagos
                </h5>
                <span class="badge bg-light text-azul-marino py-2 px-3" style="font-size: 1.4rem;">
                    <i class="fas fa-database me-1"></i> {{ $payments->total() }} registros
                </span>
            </div>
        </div>
        
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover align-middle mb-0">
                    <thead class="bg-light">
                        <tr>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem; min-width: 200px;">Usuario</th>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Membresía</th>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Monto</th>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Estado</th>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Fecha</th>
                            <th class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Comprobante</th>
                            <th id="th-comentario" class="text-azul-marino fw-medium py-3" style="display: none; font-size: 1.4rem;">Comentario</th>
                            <th id="th-accion" class="text-azul-marino fw-medium py-3" style="font-size: 1.4rem;">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="payment-table-body">
                        @foreach($payments as $payment)
                        @php
                            $statusClass = match($payment->status->name) {
                                'Pendiente de revisión' => 'pendiente',
                                'Aprobado' => 'aprobado',
                                'Rechazado' => 'rechazado',
                                'Vencido' => 'vencido',
                                default => ''
                            };
                            
                            $statusColor = match($payment->status->name) {
                                'Pendiente de revisión' => 'warning',
                                'Aprobado' => 'success',
                                'Rechazado' => 'danger',
                                'Vencido' => 'secondary',
                                default => 'primary'
                            };
                        @endphp
                        <tr class="payment-row {{ $statusClass }}">
                            <td class="py-3" style="font-size: 1.4rem;">
                                <div class="d-flex align-items-center">
                                    <div class="avatar-sm rounded-circle bg-azul-marino text-white d-flex align-items-center justify-content-center me-3">
                                        {{ substr($payment->user->names, 0, 1) }}{{ substr($payment->user->last_name, 0, 1) }}
                                    </div>
                                    <div>
                                        <h6 class="mb-0 fw-semibold" style="font-size: 1.4rem;">{{ $payment->user->names }} {{ $payment->user->last_name }}</h6>
                                        <small class="text-muted" style="font-size: 1.3rem;">{{ $payment->user->email }}</small>
                                    </div>
                                </div>
                            </td>
                            <td class="py-3" style="font-size: 1.4rem;">
                                <span class="fw-medium">{{ $payment->membership->name }}</span>
                                <small class="text-muted d-block" style="font-size: 1.3rem;">({{ $payment->membership->duration }} días)</small>
                            </td>
                            <td class="py-3 fw-medium" style="font-size: 1.4rem;">${{ number_format($payment->price, 2) }}</td>
                            <td class="py-3" style="font-size: 1.4rem;">
                                <span class="badge bg-{{ $statusColor }} text-white py-2 px-3 rounded-pill">{{ $payment->status->name }}</span>
                            </td>
                            <td class="py-3" style="font-size: 1.4rem;">
                                <div class="d-flex flex-column">
                                    <span>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d M Y') }}</span>
                                    @if($statusClass === 'vencido' && $payment->expiration_date)
                                    <small class="text-danger" style="font-size: 1.3rem;">
                                        <i class="fas fa-clock me-1"></i>Expiró: {{ \Carbon\Carbon::parse($payment->expiration_date)->translatedFormat('d M Y') }}
                                    </small>
                                    @endif
                                </div>
                            </td>
                            <td class="py-3" style="font-size: 1.4rem;">
                                <a href="{{ Storage::url($payment->receipt_url) }}" target="_blank" 
                                   class="btn btn-sm btn-outline-primary d-flex align-items-center" style="font-size: 1.3rem;">
                                    <i class="fas fa-eye me-2"></i> Ver
                                </a>
                            </td>
                            <td class="comentario-col py-3" style="{{ $statusClass === 'rechazado' ? '' : 'display:none' }}; font-size: 1.4rem;">
                                <small class="text-muted" style="font-size: 1.3rem;">{{ $statusClass === 'rechazado' ? ($payment->comment ?? 'Sin comentario') : '' }}</small>
                            </td>
                            <td class="accion-col py-3" style="font-size: 1.4rem;">
                                @if($statusClass === 'pendiente')
                                <form id="form-{{ $payment->id }}" action="{{ route('admin.payments.update', $payment) }}" method="POST">
                                    @csrf
                                    @method('PUT')
                                    <div class="d-flex gap-2">
                                        <div class="flex-grow-1">
                                            <select name="status_id" onchange="handleStatusChange(this, {{ $payment->id }})" class="form-select form-select-sm" style="font-size: 1.3rem;">
                                                <option value="4" selected>Pendiente</option>
                                                <option value="5">Aprobar</option>
                                                <option value="6">Rechazar</option>
                                            </select>
                                        </div>
                                        <div id="comment-area-{{ $payment->id }}" class="flex-grow-1" style="display: none;">
                                            <div class="input-group input-group-sm">
                                                <input type="text" name="comment" class="form-control" 
                                                    placeholder="Motivo" required style="font-size: 1.3rem;">
                                                <button type="submit" class="btn btn-sm btn-primary">
                                                    <i class="fas fa-check"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Paginación Inferior - Centrada -->
    <div class="d-flex justify-content-center mt-4">
        <nav aria-label="Page navigation">
            <ul class="pagination pagination-sm mb-0">
                <li class="page-item {{ $payments->onFirstPage() ? 'disabled' : '' }}">
                    <a class="page-link text-azul-marino" href="{{ $payments->previousPageUrl() }}" aria-label="Previous" style="font-size: 1.3rem;">
                        <span aria-hidden="true">&laquo;</span>
                    </a>
                </li>
                
                @foreach ($payments->getUrlRange(1, $payments->lastPage()) as $page => $url)
                    <li class="page-item {{ $payments->currentPage() == $page ? 'active' : '' }}">
                        <a class="page-link {{ $payments->currentPage() == $page ? 'bg-azul-marino text-white' : 'text-azul-marino' }}" 
                        href="{{ $url }}" style="font-size: 1.4rem;">{{ $page }}</a>
                    </li>
                @endforeach
                
                <li class="page-item {{ $payments->hasMorePages() ? '' : 'disabled' }}">
                    <a class="page-link text-azul-marino" href="{{ $payments->nextPageUrl() }}" aria-label="Next" style="font-size: 1.3rem;">
                        <span aria-hidden="true">&raquo;</span>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</div>

<style>
    :root {
        --azul-marino: #1A365D;
        --naranja-brillante: #FF6B35;
        --verde-esmeralda: #2EC4B6;
        --blanco: #FFFFFF;
        --azul-oscuro: #0f2a4a;
        --light-blue: #f8fafd;
    }
    
    /* Ajustes para las iniciales en el avatar */
    .avatar-sm {
        width: 40px;
        height: 40px;
        font-weight: 600;
        font-size: 1.4rem;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    
    /* Ajustes para el texto del estado */
    .badge {
        font-weight: 500;
        letter-spacing: 0.3px;
        font-size: 1.3rem;
    }

    /* Botón personalizado para "Limpiar" */
    .btn-outline-custom {
        color: var(--verde-esmeralda);
        border-color: var(--verde-esmeralda);
        background-color: transparent;
        transition: all 0.3s ease;
    }

    .btn-outline-custom:hover {
        background-color: var(--verde-esmeralda);
        border-color: var(--verde-esmeralda);
        color: var(--blanco);
        transform: translateY(-1px);
        box-shadow: 0 2px 5px rgba(0,0,0,0.1);
    }

    /* Estilos para el select de estado */
    .estado-select {
        transition: all 0.3s ease;
        border-left: 3px solid transparent !important;
    }

    /* Colores para las opciones del select */
    .estado-select option.text-warning { 
        background-color: rgba(255, 107, 53, 0.1);
        color: var(--naranja-brillante);
        padding: 8px 12px;
    }

    .estado-select option.text-success { 
        background-color: rgba(46, 196, 182, 0.1);
        color: var(--verde-esmeralda);
        padding: 8px 12px;
    }

    .estado-select option.text-danger { 
        background-color: rgba(220, 53, 69, 0.1);
        color: #dc3545;
        padding: 8px 12px;
    }

    .estado-select option.text-secondary { 
        background-color: rgba(108, 117, 125, 0.1);
        color: #6c757d;
        padding: 8px 12px;
    }

    .estado-select option[selected] {
        background-color: rgba(26, 54, 93, 0.15); 
        color: var(--azul-marino);
        font-weight: 600;
    }

    /* Borde izquierdo dinámico según estado seleccionado */
    .estado-select.select-pendiente {
        border-left-color: var(--naranja-brillante) !important;
    }

    .estado-select.select-aprobado {
        border-left-color: var(--verde-esmeralda) !important;
    }

    .estado-select.select-rechazado {
        border-left-color: #dc3545 !important;
    }

    .estado-select.select-vencido {
        border-left-color: #6c757d !important;
    }

    /* Mantengo todos tus estilos existentes */
    .text-azul-marino { color: var(--azul-marino); }
    .bg-azul-marino { background-color: var(--azul-marino); }
    .bg-verde-esmeralda { background-color: var(--verde-esmeralda); }
    .bg-naranja-brillante { background-color: var(--naranja-brillante); }
    .bg-light-blue { background-color: var(--light-blue); }
    
    .bg-gradient-primary {
        background: linear-gradient(135deg, var(--azul-marino) 0%, var(--azul-oscuro) 100%);
    }
    
    .logo-container {
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    }
    
    .card {
        border-radius: 12px;
        overflow: hidden;
    }
    
    .table-hover tbody tr {
        transition: all 0.2s ease;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(26, 54, 93, 0.03) !important;
        transform: translateY(-1px);
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
    }
    
    .form-select, .form-control {
        border-radius: 8px !important;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }
    
    .form-select:focus, .form-control:focus {
        border-color: var(--azul-marino);
        box-shadow: 0 0 0 0.25rem rgba(26, 54, 93, 0.15);
    }
    
    .btn {
        border-radius: 8px;
        transition: all 0.3s ease;
    }
    
    .btn-primary {
        background-color: var(--azul-marino);
        border-color: var(--azul-marino);
    }
    
    .btn-primary:hover {
        background-color: var(--azul-oscuro);
        border-color: var(--azul-oscuro);
        transform: translateY(-1px);
    }
    
    .btn-outline-primary {
        color: var(--azul-marino);
        border-color: var(--azul-marino);
    }
    
    .btn-outline-primary:hover {
        background-color: var(--azul-marino);
        border-color: var(--azul-marino);
    }
    
    .page-item.active .page-link {
        background-color: var(--azul-marino);
        border-color: var(--azul-marino);
    }
    
    .page-link {
        color: var(--azul-marino);
        border-radius: 8px !important;
        margin: 0 3px;
        min-width: 36px;
        text-align: center;
    }
    
    .page-link:hover {
        color: var(--azul-oscuro);
    }

    /* ==================== */
    /* ESTILOS PARA ALERTAS */
    /* ==================== */
    .swal2-popup.logout-alert {
        border: 3px solid var(--azul-marino);
        font-size: 1.4rem;
        border-radius: 12px;
        padding: 1.5rem;
        background-color: var(--blanco);
    }

    .swal2-title.logout-title {
        font-size: 1.6rem !important;
        color: var(--azul-marino) !important;
        font-weight: 600;
    }

    .swal2-html-container.logout-message {
        font-size: 1.4rem !important;
        color: var(--azul-marino) !important;
        line-height: 1.5;
    }

    /* Contenedor de botones */
    .swal2-actions.logout-actions {
        gap: 1.5rem !important;
        margin: 1.5rem 0 0 0 !important;
        padding: 0 !important;
        justify-content: center !important;
    }

    /* Estilos base para botones */
    .swal2-confirm.logout-confirm,
    .swal2-cancel.logout-cancel {
        font-size: 1.3rem !important;
        padding: 0.9rem 1.8rem !important;
        border-radius: 8px !important;
        margin: 0 !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
        border: none !important;
        font-weight: 500;
        letter-spacing: 0.5px;
    }

    /* Botón confirmar (naranja) */
    .swal2-confirm.logout-confirm {
        background: var(--naranja-brillante) !important;
        color: var(--blanco) !important;
    }

    .swal2-confirm.logout-confirm:hover {
        background: #e05a2b !important;
        transform: translateY(-1px);
    }

    /* Botón cancelar (verde) */
    .swal2-cancel.logout-cancel {
        background: var(--verde-esmeralda) !important;
        color: var(--blanco) !important;
    }

    .swal2-cancel.logout-cancel:hover {
        background: #25b0a2 !important;
        transform: translateY(-1px);
    }

    /* Animación para campos dinámicos */
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(-10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ==================== */
    /* RESPONSIVE */
    /* ==================== */
    @media (max-width: 768px) {
        .container-fluid {
            padding-left: 15px;
            padding-right: 15px;
        }
        
        .card-header h5, .card-body {
            font-size: 1.2rem;
        }
        
        .table th, .table td {
            font-size: 1.1rem;
            padding: 0.75rem 0.5rem;
        }
        
        .avatar-sm {
            width: 32px;
            height: 32px;
            font-size: 1.1rem;
        }
        
        .btn {
            padding: 0.375rem 0.75rem;
            font-size: 1.1rem;
        }

        /* Ajustes para alerts en mobile */
        .swal2-popup.logout-alert {
            width: 85% !important;
            font-size: 1.3rem;
            padding: 1rem;
        }

        .swal2-title.logout-title {
            font-size: 1.4rem !important;
        }

        .swal2-html-container.logout-message {
            font-size: 1.2rem !important;
        }

        .swal2-confirm.logout-confirm,
        .swal2-cancel.logout-cancel {
            font-size: 1.1rem !important;
            padding: 0.7rem 1.4rem !important;
        }
        
        /* Ajustes para el select de estado en móvil */
        .estado-select option {
            padding: 6px 10px;
            font-size: 1.2rem;
        }
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Función original de filtrado y animación
    filterPayments("{{ request('estado', 'pendiente') }}");

    // Animación de las filas (original)
    document.querySelectorAll('#payment-table-body tr').forEach((row, index) => {
        row.style.opacity = '0';
        row.style.transform = 'translateY(20px)';
        row.style.transition = `all 0.4s ease ${index * 0.05}s`;

        setTimeout(() => {
            row.style.opacity = '1';
            row.style.transform = 'translateY(0)';
        }, 50);
    });

    // Confirmación para rechazar (original)
    document.querySelectorAll('[id^="form-"]').forEach(form => {
        form.addEventListener('submit', function (e) {
            const select = form.querySelector('select[name="status_id"]');
            if (select.value == 6) { // Rechazado
                e.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    text: "¿Quieres rechazar este pago?",
                    icon: 'warning',
                    customClass: {
                        popup: 'logout-alert',
                        title: 'logout-title',
                        htmlContainer: 'logout-message',
                        actions: 'logout-actions',
                        confirmButton: 'logout-confirm',
                        cancelButton: 'logout-cancel'
                    },
                    showCancelButton: true,
                    confirmButtonText: 'Sí, rechazar',
                    cancelButtonText: 'Cancelar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    } else {
                        select.value = 4; // Volver a Pendiente
                        const commentArea = form.querySelector('[id^="comment-area-"]');
                        if (commentArea) {
                            commentArea.style.display = 'none';
                        }
                    }
                });
            }
        });
    });

    // Nuevo código para el select de estado
    const estadoSelect = document.getElementById('estado');
    if (estadoSelect) {
        function updateSelectClass() {
            estadoSelect.classList.remove(
                'select-pendiente', 
                'select-aprobado', 
                'select-rechazado', 
                'select-vencido'
            );
            estadoSelect.classList.add(`select-${estadoSelect.value}`);
        }
        
        estadoSelect.addEventListener('change', updateSelectClass);
        updateSelectClass();
    }
});

// Funciones originales
function handleStatusChange(select, id) {
    const form = document.getElementById(`form-${id}`);
    const commentArea = document.getElementById(`comment-area-${id}`);

    switch (parseInt(select.value)) {
        case 6: // Rechazado
            commentArea.style.display = 'block';
            commentArea.style.animation = 'fadeIn 0.3s ease';
            break;
            
        case 5: // Aprobado
            Swal.fire({
                title: '¿Estás seguro?',
                text: "¿Quieres aprobar este pago?",
                icon: 'question',
                customClass: {
                    popup: 'logout-alert',
                    title: 'logout-title',
                    htmlContainer: 'logout-message',
                    actions: 'logout-actions',
                    confirmButton: 'logout-confirm',
                    cancelButton: 'logout-cancel'
                },
                showCancelButton: true,
                confirmButtonText: 'Sí, aprobar',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    form.submit();
                } else {
                    select.value = 4; // Volver a Pendiente
                    if (commentArea) {
                        commentArea.style.display = 'none';
                    }
                }
            });
            break;
            
        case 4: // Pendiente
            if (commentArea) {
                commentArea.style.display = 'none';
            }
            break;
    }
}

function filterPayments(tipo) {
    document.querySelectorAll('.payment-row').forEach(row => {
        row.style.display = row.classList.contains(tipo) ? '' : 'none';
    });

    document.getElementById('th-accion').style.display = tipo === 'pendiente' ? '' : 'none';
    document.getElementById('th-comentario').style.display = tipo === 'rechazado' ? '' : 'none';
}

function filtrarPagosEnVivo() {
    const input = document.getElementById("search-live");
    const searchTerm = input.value.toLowerCase();
    const estadoActual = "{{ request('estado', 'pendiente') }}";
    const rows = document.querySelectorAll(`#payment-table-body tr.${estadoActual}`);

    rows.forEach(row => {
        const textoFila = row.textContent.toLowerCase();
        row.style.display = textoFila.includes(searchTerm) ? "" : "none";
    });
}
</script>
@endsection