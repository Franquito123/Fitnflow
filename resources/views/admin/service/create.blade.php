@extends('layouts.admi-app-master')

@section('content')  
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-md-8 col-lg-6">
            <div class="card shadow-sm" style="border: 2px solid #1A365D; border-radius: 10px; overflow: hidden;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                        <i class="fas fa-plus-circle me-3"></i>CREAR NUEVO SERVICIO
                    </h2>
                </div>

                <div class="card-body p-4" style="background-color: #F4F4F4;">
                    <form method="POST" action="{{ route('admin.service.store') }}" enctype="multipart/form-data" class="needs-validation" novalidate id="serviceForm">
                        @csrf

                        {{-- Nombre del servicio --}}
                        <div class="mb-4">
                            <label for="name" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                {{ __('Nombre del Servicio') }} <span class="required-star">*</span>
                            </label>
                            <input id="name" type="text" maxlength="15"
                                   class="form-control w-full p-3 border-2 rounded-lg @error('name') is-invalid @enderror" 
                                   name="name" value="{{ old('name') }}" required autofocus
                                   placeholder="Ingrese el nombre del servicio"
                                   style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;">
                            <div class="text-end mt-1">
                                <small id="name-counter" style="font-size: 1.1rem; color: #1A365D;">0 / 15</small>
                            </div>
                            @error('name')
                                <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Descripción del servicio --}}
                        <div class="mb-4">
                            <label for="description" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                {{ __('Descripción del Servicio') }}
                            </label>
                            <textarea id="description" maxlength="400"
                                      class="form-control w-full p-3 border-2 rounded-lg @error('description') is-invalid @enderror" 
                                      name="description" rows="5" placeholder="Describe el servicio de manera clara y concisa"
                                      style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%; min-height: 150px; resize: vertical;">{{ old('description') }}</textarea>
                            <div class="text-end mt-1">
                                <small id="description-counter" style="font-size: 1.1rem; color: #1A365D;">0 / 400</small>
                            </div>
                            @error('description')
                                <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        {{-- Imagen del servicio --}}
                        <div class="mb-4">
                            <label for="image_url" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-image me-2"></i>Imagen del Servicio
                            </label>
                            <input type="file" name="image_url" id="image_url" 
                                   class="form-control w-full p-3 border-2 rounded-lg @error('image_url') is-invalid @enderror" 
                                   style="border-color: #1A365D; font-size: 1.3rem;" required>
                            @error('image_url')
                                <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                    {{ $message }}
                                </div>
                            @enderror
                            <p class="mt-2" style="font-size: 1.2rem; color: #1A365D;">
                                <i class="fas fa-info-circle me-2"></i>Formatos aceptados: JPEG, PNG, JPG. Tamaño máximo: 2MB
                            </p>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.service.index') }}" class="btn py-2 px-4 me-3" 
                               style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-times me-2"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-2 px-4" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;"
                                    id="submitBtn">
                                <i class="fas fa-save me-2"></i> CREAR SERVICIO
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Validación visual con verde y rojo fuerte */
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

    const form = document.getElementById('serviceForm');

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
    });

    // Validar y filtrar solo letras en tiempo real
    const nameInput = document.getElementById('name');
    const descInput = document.getElementById('description');
    const nameCounter = document.getElementById('name-counter');
    const descCounter = document.getElementById('description-counter');

    function updateValidationState(input) {
        if (input.value.trim()) {
            input.classList.add('is-valid');
            input.classList.remove('is-invalid');
        } else {
            input.classList.remove('is-valid');
            input.classList.add('is-invalid');
        }
    }

    function filterOnlyLetters(value) {
        return value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
    }

    nameInput.addEventListener('input', function () {
        this.value = filterOnlyLetters(this.value);
        nameCounter.textContent = `${this.value.length} / 15`;
        updateValidationState(this);
    });

    descInput.addEventListener('input', function () {
        this.value = filterOnlyLetters(this.value);
        descCounter.textContent = `${this.value.length} / 400`;
        updateValidationState(this);
    });

    // Validación visual para todos los campos
    const inputs = document.querySelectorAll('.needs-validation input, .needs-validation select, .needs-validation textarea');

    inputs.forEach(input => {
        input.addEventListener('input', () => {
            updateValidationState(input);
        });

        // Inicializar estado si hay valor precargado
        if (input.value.trim()) {
            updateValidationState(input);
        }
    });

})();
</script>
@endsection

