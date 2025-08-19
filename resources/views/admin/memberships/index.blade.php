@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h2 class="mb-3 mb-md-0" style="font-weight: 700; font-size: 2rem;">
                            <i class="fas fa-id-card-alt me-3"></i>MEMBRESÍAS
                        </h2>
                        <a href="{{ route('admin.memberships.create') }}" class="btn py-2 px-4" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.4rem;">
                            <i class="fas fa-plus-circle me-2"></i> CREAR MEMBRESÍA
                        </a>
                    </div>
                </div>

                @if(session('success'))
                    <div class="alert alert-dismissible fade show m-4 auto-dismiss" role="alert" 
                            style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.4rem;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-check-circle me-3 fs-4"></i>
                            <strong style="font-size: 1.4rem !important;">{{ session('success') }}</strong>
                            <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                @endif

                <div class="card-body p-0">
                    <div class="table-responsive">  
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #1A365D; color: #FFFFFF;">
                                <tr>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600;">
                                        <i class="fas fa-signature me-2"></i>NOMBRE
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600;">
                                        <i class="fas fa-align-left me-2"></i>DESCRIPCIÓN
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600;">
                                        <i class="fas fa-tag me-2"></i>PRECIO
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600;">
                                        <i class="far fa-calendar-alt me-2"></i>DURACIÓN
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600;">
                                        <i class="fas fa-info-circle me-2"></i>ESTADO
                                    </th>
                                    <th class="text-center" style="font-size: 1.4rem; font-weight: 600; width: 250px;">
                                        <i class="fas fa-cogs me-2"></i>ACCIONES
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($memberships as $membership)
                                    <tr style="border-bottom: 2px solid #F4F4F4;">
                                        <td class="text-center" style="font-size: 1.3rem; font-weight: 600; color: #1A365D; padding: 12px 16px;">
                                            <i class="fas fa-id-card me-2 text-primary"></i>{{ $membership->name }}
                                        </td>
                                       <td class="text-center" style="font-size: 1.3rem; color: #1A365D; padding: 12px 16px;">
    <div class="description-container" style="max-width: 300px; margin: 0 auto;">
        <div class="short-description">
            <i class="fas fa-align-left me-2 text-muted"></i>
            {{ Str::limit($membership->description, 50) }}
            @if(strlen($membership->description) > 50)
                <a href="#" class="show-more" style="color: #1A365D; font-weight: 600;">... <i class="fas fa-chevron-down"></i> Ver más</a>
            @endif
        </div>
        <div class="full-description d-none">
            <i class="fas fa-align-left me-2 text-muted"></i>
            {{ $membership->description }}
            <a href="#" class="show-less" style="color: #1A365D; font-weight: 600;"> <i class="fas fa-chevron-up"></i> Ver menos</a>
        </div>
    </div>
</td>
                                        <td class="text-center" style="font-size: 1.3rem; font-weight: 600; color: #1A365D; padding: 12px 16px;">
                                            <i class="fas fa-dollar-sign me-2 text-success"></i>${{ number_format($membership->price, 2) }}
                                        </td>
                                        <td class="text-center" style="font-size: 1.3rem; font-weight: 600; color: #1A365D; padding: 12px 16px;">
                                            <i class="far fa-clock me-2 text-info"></i>{{ $membership->duration }} días
                                        </td>
                                        <td class="text-center" style="padding: 12px 16px;">
                                            @php
                                                $status = strtolower($membership->status->name ?? 'N/A');
                                                $colors = [
                                                    'activo' => '#2EC4B6',
                                                    'inactivo' => '#FF6B35',
                                                    'pendiente' => '#FFD166',
                                                ];
                                                $color = $colors[$status] ?? '#A9A9A9';
                                                $icons = [
                                                    'activo' => 'fa-check-circle',
                                                    'inactivo' => 'fa-times-circle',
                                                    'pendiente' => 'fa-clock'
                                                ];
                                                $icon = $icons[$status] ?? 'fa-question-circle';
                                            @endphp
                                            <span class="badge" style="background-color: {{ $color }}; color: #FFFFFF; font-size: 1.3rem; padding: 8px 12px;">
                                                <i class="fas {{ $icon }} me-1"></i>
                                                {{ ucfirst($membership->status->name ?? 'N/A') }}
                                            </span>
                                        </td>
                                        <td class="text-center" style="padding: 12px 16px;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.memberships.edit', $membership) }}" class="btn py-2 px-3 mx-1" 
                                                    style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.3rem; font-weight: 500; border-radius: 6px; transition: all 0.2s ease;"
                                                    data-bs-toggle="tooltip" data-bs-placement="top" title="Editar">
                                                    <i class="fas fa-edit me-2"></i> EDITAR
                                                </a>
                                                <form action="{{ route('admin.memberships.destroy', $membership) }}" method="POST" class="d-inline form-eliminar">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn py-2 px-3 mx-1 btn-eliminar" 
                                                            style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.3rem; font-weight: 500;"
                                                            data-bs-toggle="tooltip" data-bs-placement="top" title="Eliminar">
                                                        <i class="fas fa-trash-alt me-2"></i> ELIMINAR
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="card-footer py-4" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="text-muted" style="font-size: 1.4rem; font-weight: 500;">
                                <i class="fas fa-clipboard-list me-2"></i> MOSTRANDO <span class="fw-bold">{{ $memberships->count() }}</span> MEMBRESÍAS REGISTRADAS
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .table th,
    .table td {
        text-align: center !important;
        vertical-align: middle !important;
    }

    .table th {
        padding: 18px 16px;
        text-transform: uppercase;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(46, 196, 182, 0.08);
        transform: translateY(-1px);
    }

    .btn {
        padding: 0.6rem 1.2rem;
        border-radius: 6px;
        transition: all 0.2s ease;
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

    .description-container {
        position: relative;
    }
    
    .short-description, .full-description {
        word-break: break-word;
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

    .badge {
        padding: 0.5em 0.9em;
        font-size: 1.1rem;
    }

    .btn-group {
        display: inline-flex;
        flex-wrap: nowrap;
    }

    @media (max-width: 992px) {
        .table th,
        .table td {
            white-space: nowrap;
            font-size: 1.1rem !important;
            padding: 14px 10px !important;
        }

        .btn-group {
            flex-direction: column;
            gap: 10px;
        }

        .btn-group .btn {
            width: 100%;
        }
        
         .description-container {
        max-width: 150px !important;
        white-space: normal !important;
    }
    
    .short-description, .full-description {
        white-space: normal;
        word-break: break-word;
        text-align: left;
    }
    
    .show-more, .show-less {
        display: block;
        margin-top: 5px;
        white-space: nowrap;
    }
    
    .table td:nth-child(2) { /* Columna de descripción */
        min-width: 150px;
        max-width: 180px;
    }
}

@media (max-width: 768px) {
    .description-container {
        max-width: 120px !important;
    }
    
    .table td:nth-child(2) { /* Columna de descripción */
        min-width: 120px;
        max-width: 150px;
    }
    }
</style>

<script>
    // Auto-dismiss alerts after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.auto-dismiss');
        
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });
        
        // Toggle description visibility
        document.querySelectorAll('.show-more').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const container = this.closest('.description-container');
                container.querySelector('.short-description').classList.add('d-none');
                container.querySelector('.full-description').classList.remove('d-none');
            });
        });
        
        document.querySelectorAll('.show-less').forEach(button => {
            button.addEventListener('click', function(e) {
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

        // Delete confirmation
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `<div style="text-align: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>¿Está seguro que desea eliminar esta membresía permanentemente?</p>
                        <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                    </div>`,                    
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i> Cancelar',
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