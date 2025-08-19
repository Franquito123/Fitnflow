@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <h2 class="mb-2 mb-md-0" style="font-weight: 700; font-size: 1.9rem;">
                            <i class="fas fa-dumbbell me-2"></i>GESTIÓN DE CLASES
                        </h2>
                        <a href="{{ route('admin.classes.create') }}" class="btn py-2 px-4" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.2rem;">
                            <i class="fas fa-plus-circle me-1"></i> NUEVA CLASE
                        </a>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if(session('success'))
                        <div class="alert alert-dismissible fade show m-3 auto-dismiss" role="alert" 
                             style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.4rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-2 fs-4"></i>
                                <strong>{{ session('success') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-dismissible fade show m-3" role="alert" 
                             style="background-color: #FF6B35; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.2rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2 fs-4"></i>
                                <strong>{{ session('error') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #1A365D; color: #FFFFFF;">
                                <tr>
                                    <th style="font-size: 1.4rem; font-weight: 600; width: 10%;">
                                        <i class="fas fa-list-alt me-2"></i>SERVICIO
                                    </th>
                                    <th style="font-size: 1.4rem; font-weight: 600; width: 15%;">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>INSTRUCTOR
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 8%;">
                                        <i class="far fa-calendar-alt me-2"></i>FECHA
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 8%;">
                                        <i class="far fa-clock me-2"></i>HORA
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 8%;">
                                        <i class="fas fa-users me-2"></i>CAPACIDAD
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 8%;">
                                        <i class="fas fa-user-check me-2"></i>INSCRITOS
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 6%;">
                                        <i class="fas fa-door-open me-2"></i>SALÓN
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 10%;">
                                        <i class="fas fa-align-left me-2"></i>DESCRIPCIÓN
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 10%;">
                                        <i class="fas fa-info-circle me-2"></i>ESTADO
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 12%;">
                                        <i class="fas fa-cogs me-2"></i>ACCIONES
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($classes as $class)
                                    <tr style="border-bottom: 2px solid #F4F4F4;">
                                        <td style="font-size: 1.3rem;">
                                            <i class="fas fa-{{ $class->service ? 'check-circle text-success' : 'times-circle text-danger' }} me-2"></i>
                                            {{ $class->service?->name ?? 'Sin servicio' }}
                                        </td>
                                        <td style="font-size: 1.3rem;">
                                            <i class="fas fa-user-tie me-2 text-primary"></i>
                                            {{ $class->instructor->names }} {{ $class->instructor->last_name }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem;">
                                            <i class="far fa-calendar me-2 text-info"></i>
                                            {{ \Carbon\Carbon::parse($class->date)->translatedFormat('d \d\e F \d\e Y')}}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem;">
                                            <i class="fas fa-clock me-2 text-warning"></i>
                                            {{ \Carbon\Carbon::parse($class->time)->format('h:i A') }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem;">
                                            <i class="fas fa-chair me-2 text-secondary"></i>
                                            {{ $class->max_capacity }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem;">
                                            <i class="fas fa-user-plus me-2 text-success"></i>
                                            {{ $class->registrations->count() }} / {{ $class->max_capacity }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem;">
                                            <i class="fas fa-door-closed me-2 text-muted"></i>
                                            {{ $class->room }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem; color: #1A365D; padding: 12px 16px;">
                                            <div class="description-container" style="max-width: 300px; margin: 0 auto;">
                                                <div class="short-description">
                                                    <i class="fas fa-align-left me-2 text-muted"></i>
                                                    {{ Str::limit($class->description, 50) }}
                                                    @if(strlen($class->description) > 50)
                                                        <a href="#" class="show-more" style="color: #1A365D; font-weight: 600;">... <i class="fas fa-chevron-down"></i> Ver más</a>
                                                    @endif
                                                </div>
                                                <div class="full-description d-none">
                                                    <i class="fas fa-align-left me-2 text-muted"></i>
                                                    {{ $class->description }}
                                                    <a href="#" class="show-less" style="color: #1A365D; font-weight: 600;"> <i class="fas fa-chevron-up"></i> Ver menos</a>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="text-center">
                                            @php
                                            $status = strtolower($class->status->name ?? 'N/A');
                                            $colors = [
                                                'disponible' => '#2EC4B6',
                                                'cupo lleno' => '#FF6B35',
                                                'cancelada' => '#FFD166',
                                            ];
                                            $color = $colors[$status] ?? '#A9A9A9';
                                            $icons = [
                                                'disponible' => 'fa-check-circle',
                                                'cupo lleno' => 'fa-times-circle',
                                                'cancelada' => 'fa-ban'
                                            ];
                                            $icon = $icons[$status] ?? 'fa-question-circle';
                                            @endphp

                                            <span class="badge" style="background-color: {{ $color }}; color: #FFFFFF; font-size: 1.3rem; padding: 0.5em 0.8em;">
                                                <i class="fas {{ $icon }} me-1"></i>
                                                {{ ucfirst($class->status->name ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            <div class="d-flex justify-content-center gap-2" role="group">
                                                <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn py-2 px-3" 
                                                    style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.4rem; font-weight: 500; min-width: 65px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="fas fa-edit"></i>
                                                </a>
                                                <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn py-2 px-3 mx-1 mb-2 mb-md-0 btn-eliminar" 
                                                            style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.4rem; font-weight: 500; min-width: 65px;"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                                <a href="{{ route('admin.classes.registrations', $class->id) }}" class="btn py-2 px-3" 
                                                    style="background-color: #1A365D; color: #FFFFFF; font-size: 1.4rem; font-weight: 500; min-width: 65px;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Inscripciones">
                                                    <i class="fas fa-users"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="10" class="text-center text-muted py-3" style="font-size: 1.4rem;">
                                            <i class="fas fa-exclamation-triangle me-2"></i>No hay clases registradas
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer py-3" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                            <div class="text-muted" style="font-size: 1.4rem; font-weight: 500;">
                                <i class="fas fa-clipboard-list me-1"></i> MOSTRANDO <span class="fw-bold">{{ $classes->count() }}</span> CLASES REGISTRADAS
                            </div>
                            <div class="mt-2 mt-md-0">
                                {{ $classes->links('pagination::bootstrap-4') }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('styles')
<style>
    .card {
        border-radius: 8px;
        overflow: hidden;
    }
    
    .table th {
        padding: 14px 12px;
        text-transform: uppercase;
    }
    
    .table td {
        padding: 12px 10px;
        vertical-align: middle;
    }
    
    .btn {
        padding: 0.6rem 1rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(46, 196, 182, 0.08);
    }
    
    .alert {
        border-radius: 6px;
        padding: 12px 16px;
    }
    
    body {
        font-size: 1.15rem;
    }

    .btn-eliminar {
        background-color: #FF6B35 !important;
        color: #FFFFFF !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
        min-width: 100px !important;
        border: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    /*Estilo del alert*/    
    .btn-eliminar {
        background-color: #FF6B35 !important;
        color: #FFFFFF !important;
        font-size: 1.3rem !important; /* Aumentado de 1.1rem */
        font-weight: 500 !important;
        min-width: 100px !important;
        border: none !important;
        transition: all 0.3s ease !important;
    }

    .swal2-actions {
        gap: 1.5rem !important;
        margin-top: 1.5rem !important;
    }
    
    .swal2-confirm, .swal2-cancel {
        padding: 0.6rem 1.5rem !important;
        margin: 0 !important;
    }

    .swal2-popup { 
        border-radius: 10px !important;
        border: 2px solid #1A365D !important;
        font-size: 1.3rem !important;
    }
    
    .swal2-title {
        color: #1A365D !important;
        font-size: 1.7rem !important;
        font-weight: 700 !important;
    }

    .swal2-icon.swal2-warning {
        color: #FF6B35 !important;
        border-color: #FF6B35 !important;
    }

    .swal2-confirm {
        background-color: #FF6B35 !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
    }

    .swal2-cancel {
        background-color: #2EC4B6 !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
    }

    .pagination .page-item.active .page-link {
        background-color: #1A365D;
        border-color: #1A365D;
        font-size: 1.1rem;
        padding: 0.5rem 0.9rem;
    }

    .pagination .page-link {
        color: #1A365D;
        font-size: 1.1rem;
        padding: 0.5rem 0.9rem;
    }

    .badge {
        padding: 0.5em 0.9em;
        font-size: 1.1rem;
    }

    @media (max-width: 992px) {
        .table-responsive {
            overflow-x: auto;
        }

        .table th, .table td {
            font-size: 1.1rem !important;
            padding: 10px 8px !important;
        }

        .btn {
            padding: 0.5rem 0.9rem !important;
            font-size: 1.1rem !important;
        }

        .card-header h2 {
            font-size: 1.5rem !important;
        }

        .card-header .btn {
            font-size: 1.1rem !important;
            padding: 0.4rem 0.9rem !important;
        }

        .card-footer div {
            font-size: 1.1rem !important;
        }
        
        /* En móviles, los botones se apilan verticalmente */
        .d-flex.justify-content-center {
            flex-direction: column;
            gap: 8px;
        }
        
        .d-flex.justify-content-center .btn {
            width: 100%;
        }
    }
</style>
@endsection

@section('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Auto-dismiss alerts after 5 seconds
        const alerts = document.querySelectorAll('.auto-dismiss');
        
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000); // 3000 milisegundos = 3 segundos
        });

        // Funcionalidad para "Ver más" / "Ver menos"
        document.querySelectorAll('.show-more').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.description-container');
                container.querySelector('.short-description').classList.add('d-none');
                container.querySelector('.full-description').classList.remove('d-none');
            });
        });

        document.querySelectorAll('.show-less').forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.description-container');
                container.querySelector('.full-description').classList.add('d-none');
                container.querySelector('.short-description').classList.remove('d-none');
            });
        });

        // Inicializar tooltips
        const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
        tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl);
        });

        // Tu código existente para los botones de eliminar...
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');

        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (event) {
                event.preventDefault();

                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `<div style="text-align: center; font-size: 1.4rem;">
                    <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>¿Está seguro que desea eliminar esta clase permanentemente?</p>
                    <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                </div>`,                    
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash-alt me-1"></i> Eliminar',
                    cancelButtonText: '<i class="fas fa-times me-1"></i> Cancelar',
                    buttonsStyling: false,
                    customClass: {
                    confirmButton: 'btn btn-eliminar',
                    cancelButton: 'btn'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        this.closest('form').submit();
                    }
                });
            });
        });
    });
</script>
@endsection