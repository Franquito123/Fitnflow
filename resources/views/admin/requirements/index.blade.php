@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h2 class="mb-3 mb-md-0" style="font-weight: 700; font-size: 2rem;">
                            <i class="fas fa-list-alt me-3"></i>GESTIÓN DE REQUISITOS
                        </h2>
                        <a href="{{ route('admin.requirements.create') }}" class="btn py-2 px-4" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.4rem;">
                            <i class="fas fa-plus-circle me-2"></i> NUEVO REQUISITO
                        </a>
                    </div>
                </div>

                        <div class="card-body p-0">
                            @if (session('success'))
                                <div class="alert alert-dismissible fade show m-4 auto-dismiss" role="alert" style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.4rem;">
                                    <div class="d-flex align-items-center">
                                        <i class="fas fa-check-circle me-3 fs-4"></i>
                                            <strong style="font-size: 1.4rem !important;">{{ session('success') }}</strong>
                                        <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                                    </div>
                                </div>
                            @endif
                    <div class="table-responsive">  
                        <table class="table table-hover align-middle mb-0">
                            <thead style="background-color: #1A365D; color: #FFFFFF;">
                                <tr>
                                    <th class="text-center" style="font-size: 1.5rem; font-weight: 600; padding-bottom: 8px;">SERVICIO</th>
                                    <th class="text-center" style="font-size: 1.5rem; font-weight: 600; padding-bottom: 8px;">NOMBRE DEL REQUISITO</th>
                                    <th class="text-center" style="font-size: 1.5rem; font-weight: 600; width: 250px; padding-bottom: 8px;">ACCIONES</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($requirements as $requirement)
                                    <tr style="border-bottom: 2px solid #F4F4F4;">
                                        <!-- Columna Servicio (centrado) -->
                                        <td class="text-center" style="font-size: 1.4rem; color: #1A365D; padding: 16px; width: 35%;">
                                            <div class="d-flex justify-content-center align-items-start">
                                                <div class="icon-circle me-3" style="background-color: rgba(46, 196, 182, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-heart-pulse fs-4" style="color: #FF6B35;"></i>
                                                </div>
                                                <div style="text-align: center;">
                                                    <div style="font-weight: 600; margin-bottom: 8px;">{{ $requirement->service->name ?? 'Sin servicio'}}</div>
                                                    <small class="text-muted" style="font-size: 1.3rem; display: block;">ÚLTIMA ACTUALIZACIÓN: {{ \Carbon\Carbon::parse($requirement->updated_at)->translatedFormat('d \d\e F \d\e Y') }}</small>
                                                </div>
                                            </div>
                                        </td>
                                        
                                        <!-- Columna Nombre del Requisito (centrado) -->
                                        <td class="text-center" style="font-size: 1.4rem; color: #1A365D; padding: 16px; width: 35%;">
                                            <div class="d-flex justify-content-center align-items-start">
                                                <div class="icon-circle me-3" style="background-color: rgba(26, 54, 93, 0.1); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                                    <i class="fas fa-clipboard-list fs-4" style="color: #1A365D;"></i>
                                                </div>
                                                <div style="text-align: center; width: 200px; display: flex; flex-direction: column; align-items: center;">
                                                    <div style="font-weight: 600; margin-bottom: 8px; width: 100%; word-break: break-word; white-space: normal;">{{ $requirement->name }}</div>
                                                        <small class="text-muted" style="font-size: 1.3rem;">Detalles del requisito</small>
                                                    </div>
                                                </div>
                                            </td>

                                        <!-- Columna Acciones (centrado) width: 30% para más espacio-->
                                        <td class="text-center" style="padding: 12px 16px;">
                                            <div class="btn-group" role="group">
                                                <a href="{{ route('admin.requirements.edit', $requirement->id) }}" class="btn py-2 px-3 mx-1" 
                                                style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.3rem; font-weight: 500; border-radius: 6px; transition: all 0.2s ease;">
                                                    <i class="fas fa-edit me-2"></i> EDITAR
                                                </a>
                                                <form action="{{ route('admin.requirements.destroy', $requirement->id) }}" method="POST" class="d-inline form-eliminar">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn py-2 px-3 mx-1 btn-eliminar" 
                                                            style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.3rem; font-weight: 500; border-radius: 6px; transition: all 0.3s ease; box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);">
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

                    <div class="card-footer py-3" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="text-muted" style="font-size: 1.4rem; font-weight: 500;">
                                <i class="fas fa-clipboard-list me-2"></i> MOSTRANDO <span class="fw-bold">{{ $requirements->count() }}</span> REQUISITOS REGISTRADOS
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
        vertical-align: middle !important;
    }

    .table th {
        padding-top: 16px;
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
    /Estilo del alert/    
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

    .btn-group {
        display: inline-flex;
        flex-wrap: nowrap;
    }

    .icon-circle {
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .alert {
        border-radius: 6px;
    }

    @media (max-width: 992px) {
        .table th,
        .table td {
            white-space: nowrap;
            font-size: 1.2rem !important;
            padding: 12px 8px !important;
        }

        .btn-group {
            flex-direction: column;
            gap: 8px;
        }

        .btn-group .btn {
            width: 100%;
            font-size: 1.2rem !important;
        }
        
        .icon-circle {
            width: 40px !important;
            height: 40px !important;
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
            }, 3000); // 3000 milisegundos = 3 segundos
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        const botonesEliminar = document.querySelectorAll('.btn-eliminar');
        botonesEliminar.forEach(boton => {
            boton.addEventListener('click', function (event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `<div style="text-align: center;">
                        <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                        <p>¿Está seguro que desea eliminar este requisito permanentemente?</p>
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