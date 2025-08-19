@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                        <h2 class="mb-3 mb-md-0" style="font-weight: 700; font-size: 2rem;">
                            <i class="fas fa-list-alt me-3"></i>GESTIÓN DE SERVICIOS
                        </h2>
                        <a href="{{ route('admin.service.create') }}" class="btn py-2 px-4" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.4rem;">
                            <i class="fas fa-plus-circle me-2"></i> CREAR NUEVO SERVICIO
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
        <th class="text-center" style="font-size: 1.5rem; font-weight: 600; padding-bottom: 8px;">
            NOMBRE DEL SERVICIO
        </th>
        <th class="text-center" style="font-size: 1.5rem; font-weight: 600; padding-bottom: 8px;">
            DESCRIPCIÓN
        </th>
        <th class="text-center" style="font-size: 1.5rem; font-weight: 600; padding-bottom: 8px;">
            IMAGEN
        </th>
        <th class="text-center" style="font-size: 1.5rem; font-weight: 600; width: 250px; padding-bottom: 8px;">
            ACCIONES
        </th>
    </tr>
</thead>

                           <tbody>
    @forelse($services as $service)
    <tr style="border-bottom: 2px solid #F4F4F4;">
        <td class="text-center" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
            {{ $service->name }}
        </td>
        <td class="text-center" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
            {{ $service->description }}
        </td>
        <td class="text-center">
            @if($service->image_url)
            <a href="{{ asset('storage/'.$service->image_url) }}" target="_blank"
                class="btn py-1 px-3"
                style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.2rem;">
                <i class="fas fa-expand me-1"></i> Ver Imagen
            </a>
            @else
            <span class="text-muted">Sin imagen</span>
            @endif
        </td>
        <td class="text-center">
            <div class="d-flex justify-content-center flex-wrap gap-2">
                <a href="{{ route('admin.service.edit', $service->id) }}" class="btn py-1 px-2"
                    style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.3rem; font-weight: 500;">
                    <i class="fas fa-edit me-1"></i>EDITAR
                </a>
                <form action="{{ route('admin.service.destroy', $service->id) }}" method="POST" class="d-inline form-eliminar">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn py-1 px-2"
                        style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.3rem; font-weight: 500;">
                        <i class="fas fa-trash-alt me-1"></i>ELIMINAR
                    </button>
                </form>
            </div>
        </td>
    </tr>
    @empty
    <tr>
        <td colspan="4" class="text-center py-4">
            <div class="text-muted">
                <i class="fas fa-concierge-bell fs-1" style="color: #1A365D; font-size: 3rem;"></i>
                <p class="mt-2 fs-5" style="font-size: 1.4rem; font-weight: 600;">
                    No hay servicios registrados
                </p>
            </div>
        </td>
    </tr>
    @endforelse
</tbody>
   
                        </table>
                    </div>

                    <div class="card-footer py-3" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                        <div class="d-flex flex-column flex-md-row justify-content-between align-items-start align-items-md-center">
                            <div class="text-muted" style="font-size: 1.4rem; font-weight: 500;">
                                <i class="fas fa-clipboard-list me-2"></i> MOSTRANDO <span class="fw-bold">{{ $services->count() }}</span> SERVICIOS REGISTRADOS
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
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts
        const alerts = document.querySelectorAll('.auto-dismiss');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });

        // Confirmación para eliminar servicio con SweetAlert2
        const deleteForms = document.querySelectorAll('.form-eliminar');
        deleteForms.forEach(form => {
            form.addEventListener('submit', function(event) {
                event.preventDefault();
                Swal.fire({
                    title: '¿Estás seguro?',
                    html: `
                        <div style="text-align: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                            <p>¿Está seguro que desea eliminar este servicio permanentemente?</p>
                            <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                        </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i> Cancelar',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-eliminar',
                        cancelButton: 'btn btn-secondary'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Enviar el formulario con fetch para manejar la respuesta
                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Content-Type': 'application/json',
                                'Accept': 'application/json'
                            },
                            body: JSON.stringify({
                                _method: 'DELETE'
                            })
                        })
                        .then(response => {
                            if (!response.ok) {
                                return response.json().then(err => { throw err; });
                            }
                            return response.json();
                        })
                        .then(data => {
                            if (data.success) {
                                Swal.fire({
                                    title: '¡Eliminado!',
                                    text: 'El servicio ha sido eliminado correctamente.',
                                    icon: 'success',
                                    confirmButtonText: 'Aceptar'
                                }).then(() => {
                                    window.location.reload();
                                });
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            let errorMessage = 'Ocurrió un error al eliminar el servicio.';
                            
                            if (error.message && error.message.includes('foreign key constraint')) {
                                errorMessage = 'No se puede eliminar este servicio porque está siendo utilizado en clases existentes. Primero elimine o modifique las clases asociadas.';
                            }
                            
                            Swal.fire({
                                title: 'Error',
                                html: `
                                    <div style="text-align: center;">
                                        <i class="fas fa-times-circle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                                        <p>${errorMessage}</p>
                                    </div>`,
                                icon: 'error',
                                confirmButtonText: 'Entendido'
                            });
                        });
                    }
                });
            });
        });
    });
</script>

@if(session('error'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Error',
            html: `
                <div style="text-align: center;">
                    <i class="fas fa-times-circle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>{{ session('error') }}</p>
                </div>`,
            icon: 'error',
            confirmButtonText: 'Entendido'
        });
    });
</script>
@endif
@endsection
