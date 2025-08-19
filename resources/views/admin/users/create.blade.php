@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-2" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                            <i class="fas fa-user-plus me-2"></i>CREAR NUEVO USUARIO
                        </h2>
                    </div>
                </div>

                <div class="card-body p-3">
                    @if($errors->any())
                        <div class="alert alert-dismissible fade show alert-error" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-2 alert-icon"></i>
                                <div class="alert-message">
                                    <strong>Error en el formulario:</strong>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    <form action="{{ route('admin.users.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <input type="hidden" name="redirect_filter" value="{{ request('roleFilter', '3') }}">

                        <div class="row g-3">
                            <!-- Columna Izquierda -->
                            <div class="col-md-6">
                                <!-- Nombres -->
                                <div class="mb-3">
                                    <label for="names" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Nombres</label>
                                    <input type="text" class="form-control @error('names') is-invalid @enderror" 
                                        id="names" name="names" value="{{ old('names') }}" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Ingrese nombres (solo letras y espacios)"
                                        maxlength="50">
                                    @error('names')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted d-block mt-1" id="namesCharCount">{{ strlen(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', old('names'))) }} / 50 caracteres</small>
                                </div>

                                <!-- Apellidos -->
                                <div class="mb-3">
                                    <label for="last_name" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Apellidos</label>
                                    <input type="text" class="form-control @error('last_name') is-invalid @enderror" 
                                        id="last_name" name="last_name" value="{{ old('last_name') }}" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Ingrese apellidos (solo letras y espacios)"
                                        maxlength="50">
                                    @error('last_name')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted d-block mt-1" id="lastNameCharCount">{{ strlen(preg_replace('/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/', '', old('last_name'))) }} / 50 caracteres</small>
                                </div>

                                <!-- Email -->
                                <div class="mb-3">
                                    <label for="email" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Email</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                        id="email" name="email" value="{{ old('email') }}" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="ejemplo@dominio.com">
                                    @error('email')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contraseña -->
                                <div class="mb-3">
                                    <label for="password" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Contraseña</label>
                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                        id="password" name="password" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Mínimo 8 caracteres"
                                        minlength="8">
                                    @error('password')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted d-block mt-1" id="passwordHelp">La contraseña debe tener al menos 8 caracteres</small>
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mb-3">
                                    <label for="password_confirmation" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Confirmar Contraseña</label>
                                    <input type="password" class="form-control" 
                                        id="password_confirmation" name="password_confirmation" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Repita la contraseña">
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-6">
                                <!-- Rol -->
                                <div class="mb-3">
                                    <label for="rol_id" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Rol</label>
                                    <select class="form-select @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" 
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" required>
                                        <option value="" selected disabled>-- Seleccione un rol --</option>
                                        @foreach($roles as $role)
                                            @if($role->name_rol !== 'Usuario')
                                                <option value="{{ $role->id }}" {{ old('rol_id') == $role->id ? 'selected' : '' }} data-role-name="{{ $role->name_rol }}">
                                                    {{ $role->name_rol }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('rol_id')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div class="mb-3">
                                    <label for="status_id" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Estado</label>
                                    <select class="form-select @error('status_id') is-invalid @enderror" id="status_id" name="status_id" 
                                            style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" required>
                                        <option value="" selected disabled>-- Seleccione estado --</option>
                                        @foreach ($statuses as $status)
                                            @if(in_array($status->name, ['Activo', 'Inactivo', 'Pendiente']))
                                                <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endif
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="invalid-feedback" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Fecha de Nacimiento -->
                                <div class="mb-3">
                                    <label for="birth_date" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Fecha de Nacimiento</label>
                                    <input type="text" class="form-control @error('birth_date') is-invalid @enderror" 
                                        id="birth_date" name="birth_date" 
                                        placeholder="Selecciona tu fecha" readonly
                                        value="{{ old('birth_date') }}"
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem; background-color: #FFFFFF; cursor: pointer;">
                                    @error('birth_date')
                                        <div class="invalid-feedback" style="font-size: 1.3rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                    <small class="text-muted" style="font-size: 1.3rem; color: #1A365D !important;">Debe tener 18 años cumplidos</small>
                                </div>

                                <!-- Género -->
                                <div class="mb-3">
                                    <label class="form-label fw-bold d-block" style="color: #1A365D; font-size: 1.4rem;">Género</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="masculino" 
                                                value="Masculino" {{ old('gender') == 'Masculino' ? 'checked' : '' }} 
                                                style="width: 22px; height: 22px; margin-top: 4px;" required>
                                            <label class="form-check-label fw-bold" for="masculino" style="font-size: 1.3rem; color: #1A365D;">Masculino</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="femenino" 
                                                value="Femenino" {{ old('gender') == 'Femenino' ? 'checked' : '' }} 
                                                style="width: 22px; height: 22px; margin-top: 4px;">
                                            <label class="form-check-label fw-bold" for="femenino" style="font-size: 1.3rem; color: #1A365D;">Femenino</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <div class="text-danger small mt-2" style="font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="row g-2">
                                    <!-- Especialidad -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="specialty" class="form-label fw-bold mb-1" style="color: #1A365D; font-size: 1.4rem;">
                                                Especialidad
                                            </label>
                                            <input type="text" class="form-control @error('specialty') is-invalid @enderror" 
                                                id="specialty" name="specialty" value="{{ old('specialty') }}"
                                                style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; 
                                                        font-size: 1.3rem; width: 100%;"
                                                placeholder="Ej: Cardiología"
                                                maxlength="100"
                                                {{ old('rol_id') && $roles->find(old('rol_id'))->name_rol !== 'Instructor' ? 'disabled' : '' }}>
                                            @error('specialty')
                                                <div class="invalid-feedback mt-1" style="font-size: 1.2rem;">
                                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="text-muted d-block mt-1" id="specialtyCharCount">{{ strlen(old('specialty')) }} / 100 caracteres</small>
                                        </div>
                                    </div>

                                    <!-- Certificación -->
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="certification" class="form-label fw-bold mb-1" style="color: #1A365D; font-size: 1.4rem;">
                                                Certificación
                                            </label>
                                            <input type="text" class="form-control @error('certification') is-invalid @enderror" 
                                                id="certification" name="certification" value="{{ old('certification') }}"
                                                style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; 
                                                        font-size: 1.3rem; width: 100%;"
                                                placeholder="Ej: ABC12345"
                                                maxlength="50"
                                                {{ old('rol_id') && $roles->find(old('rol_id'))->name_rol !== 'Instructor' ? 'disabled' : '' }}>
                                            @error('certification')
                                                <div class="invalid-feedback mt-1" style="font-size: 1.2rem;">
                                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                            <small class="text-muted d-block mt-1" id="certificationCharCount">{{ strlen(old('certification')) }} / 50 caracteres</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.users.index', ['roleFilter' => $redirectFilter]) }}" class="btn py-1 px-3" 
                            style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem; border: 2px solid #1A365D;">
                                <i class="fas fa-times-circle me-1"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-1 px-3" 
                                    style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-1"></i> GUARDAR USUARIO
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Flatpickr CSS -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
        margin-top: 10px;
    }
    
    .container-fluid {
        padding-top: 0.5rem !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.25);
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 8px;
        padding: 8px 12px;
        background-color: rgba(255, 107, 53, 0.1);
        border-radius: 6px;
        border-left: 4px solid #FF6B35;
        font-size: 1.2rem;
    }
    
    .btn {
        transition: all 0.3s ease;
        border-radius: 8px;
        padding: 0.65rem 1.5rem;
    }
    
    .btn:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.15);
    }
    
    /* Estilos para validación visual */
    .is-valid {
        border-color: #28a745 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='8' height='8' viewBox='0 0 8 8'%3e%3cpath fill='%2328a745' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        padding-right: 2.25rem;
    }
    
    .is-invalid {
        border-color: #dc3545 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' width='12' height='12' fill='none' stroke='%23dc3545' viewBox='0 0 12 12'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23dc3545' stroke='none'/%3e%3c/svg%3e");
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
        padding-right: 2.25rem;
    }
    
    /* ESTILOS DEL ALERT - TAMAÑOS AUMENTADOS */
    .alert-error {
        background-color: #FF6B35;
        color: #FFFFFF;
        border-left: 5px solid #1A365D;
        font-size: 1.6rem;
        margin-bottom: 1.5rem;
        padding: 1.5rem 2rem;
        border-radius: 8px;
    }

    .alert-error .alert-icon {
        font-size: 2.5rem;
        margin-right: 1.2rem;
    }

    .alert-error .alert-message strong {
        font-size: 1.8rem;
        display: block;
        margin-bottom: 0.8rem;
    }

    .alert-error ul {
        margin-bottom: 0;
        padding-left: 2.2rem;
    }

    .alert-error li {
        font-size: 1.5rem;
        margin-bottom: 0.5rem;
    }

    .btn-close-white {
        filter: invert(1);
        opacity: 0.8;
        font-size: 2rem;
    }

    /* ESTILOS SWEETALERT2 - TAMAÑOS AUMENTADOS */
    .swal2-popup {
        width: 450px !important;
        border-radius: 10px !important;
        padding: 2rem !important;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        border: 2px solid #1A365D !important;
        background: #FFFFFF !important;
    }
        
    .swal2-title {
        font-size: 1.8rem !important;
        color: #1A365D !important;
        font-weight: 700 !important;
        margin-bottom: 1.2rem !important;
    }
        
    .swal2-content {
        font-size: 1.5rem !important;
        color: #1A365D !important;
        line-height: 1.6;
    }
        
    .swal2-confirm {
        background-color: #1A365D !important;
        color: white !important;
        border: none !important;
        font-size: 1.3rem !important;
        padding: 0.8rem 2.5rem !important;
        border-radius: 6px !important;
        font-weight: 600 !important;
        margin-top: 1rem;
    }
        
    .swal2-icon.swal2-warning {
        color: #FF6B35 !important;
        border-color: #FF6B35 !important;
        transform: scale(1.2);
        margin: 1.2rem auto 0.8rem;
    }
    
    /* ESTILOS PARA EL CALENDARIO */
    .flatpickr-calendar {
        width: 320px !important;
        font-family: 'Poppins', sans-serif !important;
        box-shadow: 0 10px 20px rgba(0,0,0,0.2) !important;
        border: 2px solid #1A365D !important;
        border-radius: 8px !important;
    }
    
    .flatpickr-day.selected, 
    .flatpickr-day.selected:hover {
        background: #FF6B35 !important;
        border-color: #FF6B35 !important;
    }
    
    .flatpickr-day.today {
        border-color: #2EC4B6 !important;
    }
    
    .flatpickr-day.today:hover {
        background: #2EC4B6 !important;
        color: white !important;
    }
    
    .flatpickr-months .flatpickr-month {
        background: #1A365D !important;
        color: white !important;
        fill: white !important;
        border-radius: 6px 6px 0 0 !important;
    }
    
    .flatpickr-weekdays {
        background: #1A365D !important;
    }
    
    .flatpickr-weekday {
        color: white !important;
    }
    
    .flatpickr-current-month .flatpickr-monthDropdown-months {
        background: #1A365D !important;
        color: white !important;
    }
    
    .flatpickr-current-month input.cur-year {
        color: white !important;
        font-weight: 600 !important;
    }

    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .card-header h2 {
            font-size: 1.5rem !important;
        }
        
        .container-fluid {
            padding-top: 0 !important;
        }
        
        .form-label, .form-check-label {
            font-size: 1.3rem !important;
        }
        
        .form-control, .form-select {
            font-size: 1.2rem !important;
            padding: 12px 14px !important;
        }
        
        .btn {
            font-size: 1.2rem !important;
            padding: 0.8rem 1.2rem !important;
        }
        
        .d-flex.gap-3 {
            gap: 1.5rem !important;
        }
        
        .invalid-feedback {
            font-size: 1.1rem !important;
            padding: 10px 12px !important;
        }
        
        .form-check-input {
            width: 20px !important;
            height: 20px !important;
            margin-top: 5px !important;
        }
        
        /* ESTILOS DEL ALERT EN MÓVIL - TAMAÑOS AUMENTADOS */
        .alert-error {
            font-size: 1.8rem;
            padding: 1.8rem 2rem;
        }

        .alert-error .alert-icon {
            font-size: 3rem;
        }

        .alert-error .alert-message strong {
            font-size: 2rem;
        }

        .alert-error li {
            font-size: 1.7rem;
        }

        .btn-close-white {
            font-size: 2.5rem;
        }
        
        .swal2-popup {
            width: 350px !important;
            padding: 1.5rem !important;
        }
        
        .swal2-title {
            font-size: 1.8rem !important;
        }
        
        .swal2-content {
            font-size: 1.5rem !important;
        }
        
        .swal2-confirm {
            font-size: 1.4rem !important;
            padding: 0.8rem 1.8rem !important;
        }
    }
    
    /* Reducción general de espacios verticales */
    .row.g-3 {
        row-gap: 0.8rem !important;
    }
    
    .mb-3 {
        margin-bottom: 0.8rem !important;
    }
    
    .card-body {
        padding-top: 1rem !important;
        padding-bottom: 1rem !important;
    }

    /* Estilo para campos deshabilitados */
    .form-control:disabled {
        background-color: #f8f9fa !important;
        border-color: #dee2e6 !important;
        color: #6c757d !important;
        cursor: not-allowed !important;
    }
</style>

@section('scripts')
<!-- SweetAlert2 para diálogos personalizados -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<!-- Include Font Awesome for icons -->
<script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script>
<!-- Flatpickr JS -->
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Validación del formulario
        (function () {
            'use strict';
            var forms = document.querySelectorAll('.needs-validation');
            
            Array.prototype.slice.call(forms).forEach(function (form) {
                form.addEventListener('submit', function (event) {
                    if (!form.checkValidity()) {
                        event.preventDefault();
                        event.stopPropagation();

                        // Mostrar alerta de campos incompletos
                        Swal.fire({
                            icon: 'warning',
                            title: '<span style="font-size: 1.8rem; color: #1A365D; font-weight: 700;">Campos incompletos</span>',
                            html: '<span style="font-size: 1.5rem; color: #1A365D;">Por favor completa todos los campos obligatorios antes de continuar.</span>',
                            confirmButtonText: 'Aceptar',
                            confirmButtonColor: '#1A365D',
                            background: '#FFFFFF',
                            iconColor: '#FF6B35',
                            customClass: {
                                container: 'swal2-container-custom',
                                popup: 'swal2-popup-custom'
                            }
                        });
                    }

                    form.classList.add('was-validated');
                }, false);
            });
        })();

        // Calculamos la fecha exacta de hace 18 años
        const today = new Date();
        const maxDate = new Date(
            today.getFullYear() - 18,
            today.getMonth(),
            today.getDate()
        );

        // Configuración del datepicker modificada
        const birthDatePicker = flatpickr("#birth_date", {
            dateFormat: "Y-m-d",
            locale: "es",
            disableMobile: true,
            maxDate: maxDate,
            minDate: new Date().fp_incr(-100 * 365), // Máximo 100 años
            allowInput: false,
            clickOpens: true,
            defaultDate: null, // No mostrar fecha por defecto
            onChange: function(selectedDates, dateStr, instance) {
                // Validar edad mínima
                const minAgeDate = new Date();
                minAgeDate.setFullYear(minAgeDate.getFullYear() - 18);
                
                if (selectedDates[0] > minAgeDate) {
                    const errorElement = document.querySelector('#birth_date').nextElementSibling;
                    if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                        errorElement.style.display = 'block';
                        errorElement.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Debes tener al menos 18 años cumplidos';
                    }
                    instance.clear();
                } else {
                    const errorElement = document.querySelector('#birth_date').nextElementSibling;
                    if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                        errorElement.style.display = 'none';
                    }
                    // Actualizar el placeholder con la fecha seleccionada
                    instance.altInput.value = instance.formatDate(selectedDates[0], "j F Y");
                }
            },
            onOpen: function(selectedDates, dateStr, instance) {
                // Enfocar el año para facilitar selección
                setTimeout(() => {
                    const yearInput = instance.calendarContainer.querySelector('.numInput.cur-year');
                    if (yearInput) yearInput.focus();
                }, 100);
            }
        });

        // Validación adicional para asegurar 18 años cumplidos
        document.querySelector('form').addEventListener('submit', function(e) {
            const birthDateInput = document.getElementById('birth_date');
            const errorElement = birthDateInput.nextElementSibling;
            
            if (!birthDateInput.value) {
                e.preventDefault();
                if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                    errorElement.style.display = 'block';
                    errorElement.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Por favor selecciona tu fecha de nacimiento';
                }
                return;
            }
            
            const birthDate = new Date(birthDateInput.value);
            const today = new Date();
            let age = today.getFullYear() - birthDate.getFullYear();
            const monthDiff = today.getMonth() - birthDate.getMonth();
            
            if (monthDiff < 0 || (monthDiff === 0 && today.getDate() < birthDate.getDate())) {
                age--;
            }
            
            if (age < 18) {
                e.preventDefault();
                if (errorElement && errorElement.classList.contains('invalid-feedback')) {
                    errorElement.style.display = 'block';
                    errorElement.innerHTML = '<i class="fas fa-exclamation-circle me-2"></i>Debes tener al menos 18 años cumplidos';
                }
                birthDatePicker.open();
            }
        });

        // Función para contar caracteres válidos (letras y espacios, excluyendo números y especiales)
        function countValidChars(text) {
            const cleanText = text.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            return cleanText.length;
        }

        // Contador de caracteres para nombres
        const namesInput = document.getElementById('names');
        const namesCharCount = document.getElementById('namesCharCount');
        
        namesInput.addEventListener('input', function() {
            // Eliminar números y caracteres especiales
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            
            const charCountValue = countValidChars(this.value);
            namesCharCount.textContent = `${charCountValue} / 50 caracteres`;
            
            // Validación visual
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                if (this.value) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // Contador de caracteres para apellidos
        const lastNameInput = document.getElementById('last_name');
        const lastNameCharCount = document.getElementById('lastNameCharCount');
        
        lastNameInput.addEventListener('input', function() {
            // Eliminar números y caracteres especiales
            this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
            
            const charCountValue = countValidChars(this.value);
            lastNameCharCount.textContent = `${charCountValue} / 50 caracteres`;
            
            // Validación visual
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                if (this.value) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // Contador de caracteres para especialidad
        const specialtyInput = document.getElementById('specialty');
        const specialtyCharCount = document.getElementById('specialtyCharCount');
        
        specialtyInput.addEventListener('input', function() {
            const charCountValue = this.value.length;
            specialtyCharCount.textContent = `${charCountValue} / 100 caracteres`;
            
            // Validación visual
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                if (this.value) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // Contador de caracteres para certificación
        const certificationInput = document.getElementById('certification');
        const certificationCharCount = document.getElementById('certificationCharCount');
        
        certificationInput.addEventListener('input', function() {
            const charCountValue = this.value.length;
            certificationCharCount.textContent = `${charCountValue} / 50 caracteres`;
            
            // Validación visual
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                if (this.value) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
        });

        // Validación de contraseña
        const passwordInput = document.getElementById('password');
        const passwordConfirmInput = document.getElementById('password_confirmation');
        
        function validatePassword() {
            if (passwordInput.value !== passwordConfirmInput.value) {
                passwordConfirmInput.setCustomValidity("Las contraseñas no coinciden");
                passwordConfirmInput.classList.add('is-invalid');
            } else {
                passwordConfirmInput.setCustomValidity("");
                if (passwordConfirmInput.value) {
                    passwordConfirmInput.classList.add('is-valid');
                } else {
                    passwordConfirmInput.classList.remove('is-valid');
                }
                passwordConfirmInput.classList.remove('is-invalid');
            }
        }
        
        passwordInput.addEventListener('input', function() {
            if (this.checkValidity()) {
                this.classList.remove('is-invalid');
                if (this.value) {
                    this.classList.add('is-valid');
                } else {
                    this.classList.remove('is-valid');
                }
            } else {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            }
            validatePassword();
        });
        
        passwordConfirmInput.addEventListener('input', validatePassword);

        // Control de habilitación/deshabilitación de campos según rol seleccionado
        const rolSelect = document.getElementById('rol_id');
        const specialtyField = document.getElementById('specialty');
        const certificationField = document.getElementById('certification');

        function toggleSpecialtyFields() {
            const selectedOption = rolSelect.options[rolSelect.selectedIndex];
            const roleName = selectedOption.getAttribute('data-role-name');
            
            if (roleName === 'Instructor') {
                specialtyField.disabled = false;
                certificationField.disabled = false;
                specialtyField.required = true;
                certificationField.required = true;
            } else {
                specialtyField.disabled = true;
                certificationField.disabled = true;
                specialtyField.required = false;
                certificationField.required = false;
                specialtyField.value = '';
                certificationField.value = '';
                
                // Actualizar contadores
                document.getElementById('specialtyCharCount').textContent = '0 / 100 caracteres';
                document.getElementById('certificationCharCount').textContent = '0 / 50 caracteres';
                
                // Limpiar validación visual
                specialtyField.classList.remove('is-valid', 'is-invalid');
                certificationField.classList.remove('is-valid', 'is-invalid');
            }
        }

        // Ejecutar al cargar la página
        toggleSpecialtyFields();
        
        // Ejecutar cuando cambie el rol
        rolSelect.addEventListener('change', toggleSpecialtyFields);

        // Validación visual para campos con contenido al cargar
        if (namesInput.value && namesInput.checkValidity()) {
            namesInput.classList.add('is-valid');
        }
        
        if (lastNameInput.value && lastNameInput.checkValidity()) {
            lastNameInput.classList.add('is-valid');
        }
        
        const emailInput = document.getElementById('email');
        if (emailInput.value && emailInput.checkValidity()) {
            emailInput.classList.add('is-valid');
        }
        
        if (passwordInput.value && passwordInput.checkValidity()) {
            passwordInput.classList.add('is-valid');
        }
        
        if (passwordConfirmInput.value && passwordConfirmInput.checkValidity()) {
            passwordConfirmInput.classList.add('is-valid');
        }
        
        if (rolSelect.value && rolSelect.checkValidity()) {
            rolSelect.classList.add('is-valid');
        }
        
        const statusSelect = document.getElementById('status_id');
        if (statusSelect.value && statusSelect.checkValidity()) {
            statusSelect.classList.add('is-valid');
        }
        
        if (specialtyInput.value && specialtyInput.checkValidity()) {
            specialtyInput.classList.add('is-valid');
        }
        
        if (certificationInput.value && certificationInput.checkValidity()) {
            certificationInput.classList.add('is-valid');
        }
    });
</script>
@endsection

@endsection