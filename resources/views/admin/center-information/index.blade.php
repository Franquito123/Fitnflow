@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-8">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                        <i class="fas fa-info-circle me-3"></i>INFORMACIÓN DEL CENTRO
                    </h2>
                </div>

                <div class="card-body p-4">
                    @if (session('success'))
                        <div class="alert alert-dismissible fade show mb-4 auto-dismiss-alert" role="alert" 
                            style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 fs-4"></i>
                                <strong class="fs-5">{{ session('success') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('deleted'))
                        <div class="alert alert-dismissible fade show mb-4 auto-dismiss-alert" role="alert" 
                            style="background-color: #FF6B35; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-trash-alt me-3 fs-4"></i>
                                <strong class="fs-5">{{ session('deleted') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if(isset($info) && $info)
                        <div class="space-y-4" style="font-size: 1.4rem; color: #1A365D;">
                            <p>
                                <span style="font-weight: 600;">
                                    <i class="fas fa-calendar-alt me-2"></i>Días de atención:
                                </span> 
                                {{ $info->days ?? 'No especificado' }}
                            </p>
                            <p>
    <span style="font-weight: 600;">
        <i class="fas fa-clock me-2"></i>Horario de apertura:
    </span> 
    {{ $info->opening_time ? \Carbon\Carbon::parse($info->opening_time)->format('h:i A') : 'No especificado' }}
</p>
<p>
    <span style="font-weight: 600;">
        <i class="fas fa-clock me-2"></i>Horario de cierre:
    </span> 
    {{ $info->closing_time ? \Carbon\Carbon::parse($info->closing_time)->format('h:i A') : 'No especificado' }}
</p>

                                <span style="font-weight: 600;">
                                    <i class="fas fa-phone me-2"></i>Teléfono:
                                </span> 
                                {{ $info->phone }}
                            </p>
                            <p>
                                <span style="font-weight: 600;">
                                    <i class="fas fa-envelope me-2"></i>Email:
                                </span> 
                                {{ $info->email }}
                            </p>
                            <p>
                                <span style="font-weight: 600;">
                                    <i class="fas fa-map-marker-alt me-2"></i>Dirección:
                                </span> 
                                {{ $info->address }}
                            </p>

                            @if($info->map_embed)
                            <div class="mt-4">
                                <span style="font-weight: 600;">
                                    <i class="fas fa-map me-2"></i>Ubicación en mapa:
                                </span>
                                <div class="mt-2" style="border:1px solid #1A365D; border-radius:6px; overflow:hidden;">
                                    {!! $info->map_embed !!}
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.center-information.edit', $info->id) }}"
                               class="btn py-2 px-4 me-3" 
                               style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                               <i class="fas fa-edit me-2"></i> EDITAR
                            </a>
                            <form action="{{ route('admin.center-information.destroy', $info->id) }}" method="POST" class="d-inline">
                                @csrf
                                @method('DELETE')
                                <button type="button" class="btn py-2 px-4 btn-eliminar">
                                    <i class="fas fa-trash-alt me-2"></i> ELIMINAR
                                </button>
                            </form>
                        </div>
                    @else
                        <div class="text-center py-4">
                            <div class="text-muted">
                                <i class="fas fa-info-circle fs-1" style="color: #1A365D; font-size: 3rem;"></i>
                                <p class="mt-3 fs-5" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                    No hay información del centro registrada aún
                                </p>
                            </div>
                        </div>

                        <div class="d-flex justify-content-center mt-4">
                            <a href="{{ route('admin.center-information.create') }}"
                               class="btn py-2 px-4" 
                               style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                               <i class="fas fa-plus-circle me-2"></i> AGREGAR INFORMACIÓN
                            </a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
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
    
    .btn-eliminar:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(46, 196, 182, 0.08);
        transform: translateY(-1px);
    }
    
    .alert {
        border-radius: 6px;
    }

    .wrap-text {
        white-space: normal;
        word-break: break-word;
    }

    /* Estilo del alert */
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
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Ajustes para móviles */
    @media (max-width: 992px) {
        .card-header h2 {
            font-size: 1.4rem !important;
        }
        
        .btn {
            padding: 0.5rem 1rem !important;
            font-size: 1.1rem !important;
        }
        
        .space-y-4 p {
            font-size: 1.2rem !important;
        }
    }
</style>

@section('scripts')
<script>
    // Auto-dismiss alerts after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts
        const alerts = document.querySelectorAll('.auto-dismiss-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });

        // Confirmación para eliminar
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `<div style="text-align: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>¿Está seguro que desea eliminar esta información permanentemente?</p>
                        <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                    </div>`,                    
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i> Cancelar',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-eliminar',
                        cancelButton: 'btn',
                        popup: 'swal2-popup-custom'
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
@endsection