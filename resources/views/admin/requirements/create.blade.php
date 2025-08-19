@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-xxl-6">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                            <i class="fas fa-plus-circle me-3"></i>CREAR NUEVO REQUISITO
                        </h2>
                    </div>
                </div>

                <div class="card-body p-4">
                    @if($errors->any())
                        <div class="alert alert-dismissible fade show mb-4" role="alert" 
                             style="background-color: #FF6B35; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-3 fs-4"></i>
                                <div>
                                    <strong class="fs-5">Error en el formulario:</strong>
                                    <ul class="mb-0 ps-3">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <form action="{{ route('admin.requirements.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf
                        <div class="mb-4">
                            <label for="service_id" class="form-label fw-bold" style="color: #1A365D; font-size: 1.3rem;">Servicio</label>
                            <select class="form-select py-2 px-3 @error('service_id') is-invalid @enderror" 
                                    id="service_id" name="service_id" required
                                    style="border: 2px solid #1A365D; border-radius: 6px; font-size: 1.3rem;">
                                <option value="" selected disabled>-- Seleccionar Servicio --</option>
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}" {{ old('service_id') == $service->id ? 'selected' : '' }}>
                                        {{ $service->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('service_id')
                                <div class="invalid-feedback" style="font-size: 1.2rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>
                        
                        <div class="mb-4">
                            <label for="name" class="form-label fw-bold" style="color: #1A365D; font-size: 1.3rem;">Nombre del Requisito</label>
                            <input type="text" class="form-control py-2 px-3 @error('name') is-invalid @enderror" 
                                   id="name" name="name" value="{{ old('name') }}" 
                                   maxlength="50" required
                                   style="border: 2px solid #1A365D; border-radius: 6px; font-size: 1.3rem;"
                                   placeholder="Ingrese el nombre del requisito (solo letras y espacios)">
                            @error('name')
                                <div class="invalid-feedback" style="font-size: 1.2rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1" id="charCount">0 / 50 caracteres</small>
                        </div>
                        
                        <div class="d-flex justify-content-end gap-3 mt-5">
                            <a href="{{ route('admin.requirements.index') }}" class="btn py-2 px-4" 
                            style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-times-circle me-2"></i> Cancelar
                            </a>
                            <button type="submit" class="btn py-2 px-4" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-2"></i> Guardar
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
        border-radius: 10px;
        overflow: hidden;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.25);
    }
    
    .btn {
        border-radius: 6px;
        transition: all 0.2s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
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
    
    /* Estilo personalizado para el alert */
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
            font-size: 1.6rem !important;
        }
        
        .btn {
            padding: 0.6rem 1rem !important;
            font-size: 1.1rem !important;
        }
        
        .form-control, .form-select {
            font-size: 1.1rem !important;
            padding: 0.5rem 0.8rem !important;
        }
        
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
    const inputs = document.querySelectorAll('.needs-validation input, .needs-validation select');
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

    // Función para contar caracteres válidos (letras y espacios, excluyendo números y especiales)
    function countValidChars(text) {
        // Eliminar números y caracteres especiales, mantener solo letras (incluyendo acentuadas) y espacios
        const cleanText = text.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        return cleanText.length;
    }

    // Contador de caracteres para el nombre del requisito
    const nameInput = document.getElementById('name');
    const charCount = document.getElementById('charCount');
    
    // Actualizar contador al cargar la página con el valor existente
    if (nameInput.value) {
        const initialCharCount = countValidChars(nameInput.value);
        charCount.textContent = `${initialCharCount} / 50 caracteres`;
    }
    
    // Validación visual inicial
    if (nameInput.checkValidity()) {
        nameInput.classList.add('is-valid');
    }
    
    // Actualizar contador mientras se escribe
    nameInput.addEventListener('input', function() {
        // Eliminar números y caracteres especiales
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        
        const charCountValue = countValidChars(this.value);
        charCount.textContent = `${charCountValue} / 50 caracteres`;
        
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