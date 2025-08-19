@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-2" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                        <i class="fas fa-calendar-alt me-2"></i> EDITAR CLASE
                    </h2>
                </div>

                <div class="card-body p-3">
                    <form method="POST" action="{{ route('admin.classes.update', $class->id) }}" class="needs-validation" novalidate>
                        @csrf
                        @method('PUT')

                        <div class="row g-3">
                            <!-- Columna Izquierda -->
                            <div class="col-md-6">
                                <!-- Servicio -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Servicio</label>
                                    <select name="service_id" class="form-select @error('service_id') is-invalid @enderror" 
                                            style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;" required>
                                        <option value="" disabled>-- Seleccionar Servicio --</option>
                                        @foreach($services as $service)
                                            <option value="{{ $service->id }}" {{ $class->service_id == $service->id ? 'selected' : '' }}>
                                                {{ $service->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('service_id')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Instructor -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Instructor</label>
                                    <select name="instructor_id" class="form-select @error('instructor_id') is-invalid @enderror" 
                                            style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;" required>
                                        <option value="" disabled>-- Seleccionar Instructor --</option>
                                        @foreach($instructors as $instructor)
                                            <option value="{{ $instructor->id }}" {{ $class->instructor_id == $instructor->id ? 'selected' : '' }}>
                                                {{ $instructor->names }} {{ $instructor->last_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('instructor_id')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Hora -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Hora</label>
                                    <input type="time" name="time" id="timeInput" class="form-control @error('time') is-invalid @enderror" 
                                           value="{{ \Carbon\Carbon::parse($class->time)->format('H:i') }}" 
                                           style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;"
                                           required placeholder="Seleccione la hora">
                                    @error('time')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-6">
                                <!-- Estado -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Estado</label>
                                    <select name="status_id" class="form-select @error('status_id') is-invalid @enderror" 
                                            style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;" required>
                                        <option value="" disabled>-- Seleccionar Estado --</option>
                                        @foreach($statuses as $status)
                                            <option value="{{ $status->id }}" {{ $class->status_id == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('status_id')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Fecha -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Fecha</label>
                                    <input type="date" name="date" id="dateInput" class="form-control @error('date') is-invalid @enderror" 
                                           value="{{ $class->date->format('Y-m-d') }}" 
                                           style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;"
                                           required placeholder="Seleccione la fecha">
                                    @error('date')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Capacidad Máxima -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Capacidad Máxima</label>
                                    <input type="number" name="max_capacity" class="form-control @error('max_capacity') is-invalid @enderror" 
                                           value="{{ $class->max_capacity }}" min="1" max="30" 
                                           style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;"
                                           required placeholder="Ej: 15">
                                    @error('max_capacity')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Campos de ancho completo -->
                        <div class="row">
                            <div class="col-md-6">
                                <!-- Sala -->
                                <div class="mb-2">
                                    <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Sala</label>
                                    <input type="text" name="room" class="form-control @error('room') is-invalid @enderror" 
                                           value="{{ $class->room }}" 
                                           style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem;"
                                           required placeholder="Ej: Sala 1">
                                    @error('room')
                                        <div class="invalid-feedback" style="font-size: 0.9rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-2">
                            <label class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Descripción</label>
                            <textarea name="description" id="description" class="form-control @error('description') is-invalid @enderror" 
                                      style="border: 2px solid #1A365D; border-radius: 6px; padding: 8px 12px; font-size: 1.3rem; height: 80px;" 
                                      required placeholder="Ingrese la descripción de la clase (solo letras y espacios)">{{ $class->description }}</textarea>
                            @error('description')
                                <div class="invalid-feedback" style="font-size: 0.9rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1" id="charCount">0 / 150 caracteres</small>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('admin.classes.index') }}" class="btn py-1 px-3 me-2" 
                               style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem; border: 2px solid #1A365D;">
                                <i class="fas fa-times-circle me-1"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-1 px-3" 
                                    style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-1"></i> ACTUALIZAR CLASE
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 8px;
        overflow: hidden;
        margin-top: 5px;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 3px;
        padding: 3px 6px;
        background-color: rgba(255, 107, 53, 0.1);
        border-radius: 4px;
        border-left: 3px solid #FF6B35;
        font-size: 0.85rem;
    }
    
    .btn {
        transition: all 0.2s ease;
        border-radius: 5px;
        padding: 6px 12px;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.1);
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
    
    /* Estilos para el alert de validación */
    .swal2-popup.custom-alert {
        border: 3px solid #1A365D;
        font-size: 1.4rem;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .swal2-title {
        font-size: 1.6rem !important;
        color: #1A365D !important;
    }

    .swal2-html-container {
        font-size: 1.4rem !important;
        color: #1A365D !important;
    }

    .swal2-confirm {
        font-size: 1.3rem !important;
        padding: 0.6rem 1.4rem !important;
        background-color: #1A365D !important;
    }

    .swal2-icon.swal2-warning {
        color: #FF6B35 !important;
        border-color: #FF6B35 !important;
    }
    
    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .card-header h2 {
            font-size: 1.3rem !important;
        }
        
        .form-label {
            font-size: 1.0rem !important;
        }
        
        .form-control, .form-select, textarea {
            font-size: 0.9rem !important;
            padding: 6px 10px !important;
        }
        
        .btn {
            font-size: 1.0rem !important;
            padding: 5px 10px !important;
        }
        
        .invalid-feedback {
            font-size: 0.8rem !important;
            padding: 2px 4px !important;
        }
        
        /* Ajustes para el alert en móviles */
        .swal2-popup.custom-alert {
            font-size: 1.2rem !important;
            padding: 1rem !important;
        }
        
        .swal2-title {
            font-size: 1.4rem !important;
        }
        
        .swal2-html-container {
            font-size: 1.2rem !important;
        }
        
        .swal2-confirm {
            font-size: 1.1rem !important;
            padding: 0.5rem 1.2rem !important;
        }
    }
</style>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<script>
(function () {
    'use strict';

    var forms = document.querySelectorAll('.needs-validation');
    Array.prototype.slice.call(forms).forEach(function (form) {
        form.addEventListener('submit', function (event) {
            if (!form.checkValidity()) {
                event.preventDefault();
                event.stopPropagation();

                Swal.fire({
                    icon: 'warning',
                    title: 'Campos incompletos',
                    text: 'Por favor completa todos los campos obligatorios antes de continuar.',
                    confirmButtonText: 'Aceptar',
                    confirmButtonColor: '#1A365D',
                    background: '#FFFFFF',
                    iconColor: '#FF6B35',
                    color: '#1A365D',
                    customClass: { popup: 'custom-alert' }
                });
            }
            form.classList.add('was-validated');
        }, false);
    });

    // Validación visual en tiempo real para todos los inputs
    const inputs = document.querySelectorAll('.needs-validation input, .needs-validation select, .needs-validation textarea');
    inputs.forEach(input => {
        input.addEventListener('input', function () {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
                input.classList.add('is-valid');
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        });
        
        // Validación inicial al cargar la página
        if (input.checkValidity()) {
            input.classList.add('is-valid');
        }
    });

    // Abrir selector nativo al hacer clic en fecha y hora
    const dateInput = document.getElementById('dateInput');
    const timeInput = document.getElementById('timeInput');
    if (dateInput) {
        dateInput.addEventListener('click', function() {
            this.showPicker?.();
        });
    }
    if (timeInput) {
        timeInput.addEventListener('click', function() {
            this.showPicker?.();
        });
    }

    // Función para contar caracteres válidos (letras y espacios, excluyendo números y especiales)
    function countValidChars(text) {
        const cleanText = text.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        return cleanText.length;
    }

    // Contador de caracteres para descripción
    const description = document.getElementById('description');
    const charCount = document.getElementById('charCount');
    
    // Actualizar contador al cargar la página con el valor existente
    const initialCharCount = countValidChars(description.value);
    charCount.textContent = `${initialCharCount} / 150 caracteres`;
    
    // Validación visual inicial
    if (description.checkValidity()) {
        description.classList.add('is-valid');
    }
    
    // Limpiar caracteres no permitidos y actualizar contador mientras se escribe
    description.addEventListener('input', function() {
        const cleanValue = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        if (this.value !== cleanValue) {
            this.value = cleanValue;
        }
        const charCountValue = countValidChars(this.value);
        charCount.textContent = `${charCountValue} / 150 caracteres`;
        
        // Validación visual
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            this.classList.add('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });
})();
</script>
@endsection

@endsection
