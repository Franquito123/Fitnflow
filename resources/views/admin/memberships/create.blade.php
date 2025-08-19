@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-lg-8 col-xl-6">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-2" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                        <i class="fas fa-id-card-alt me-2"></i> CREAR MEMBRESÍA
                    </h2>
                </div>

                <div class="card-body p-3">
                    <form action="{{ route('admin.memberships.store') }}" method="POST" class="needs-validation" novalidate>
                        @csrf

                        <!-- Nombre -->
                        <div class="mb-3">
                            <label for="name" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Nombre</label>
                            <input type="text" name="name" id="name" 
                                class="form-control @error('name') is-invalid @enderror" 
                                value="{{ old('name') }}" 
                                style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                required
                                placeholder="Ingrese el nombre de la membresía (solo letras y espacios)">
                            @error('name')
                                <div class="invalid-feedback" style="font-size: 1.0rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1" id="nameCharCount">0 / 50 caracteres</small>
                        </div>

                        <!-- Descripción -->
                        <div class="mb-3">
                            <label for="description" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Descripción</label>
                            <textarea name="description" id="description" rows="3"
                                class="form-control @error('description') is-invalid @enderror"
                                style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;"
                                placeholder="Ingrese la descripción de la membresía (solo letras y espacios)">{{ old('description') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback" style="font-size: 1.0rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                            <small class="text-muted d-block mt-1" id="descCharCount">0 / 200 caracteres</small>
                        </div>

                        <div class="row g-2">
                            <!-- Precio -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="price" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Precio ($)</label>
                                    <input type="number" step="0.01" min="0" name="price" id="price"
                                        class="form-control @error('price') is-invalid @enderror"
                                        value="{{ old('price') }}"
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Ej: 99.99">
                                    @error('price')
                                        <div class="invalid-feedback" style="font-size: 1.0rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Duración -->
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="duration" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Duración (días)</label>
                                    <input type="number" name="duration" id="duration" min="1"
                                        class="form-control @error('duration') is-invalid @enderror"
                                        value="{{ old('duration', 30) }}"
                                        style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" 
                                        required
                                        placeholder="Ej: 30">
                                    @error('duration')
                                        <div class="invalid-feedback" style="font-size: 1.0rem;">
                                            <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <!-- Estado -->
                        <div class="mb-3">
                            <label for="status_id" class="form-label fw-bold" style="color: #1A365D; font-size: 1.4rem;">Estado</label>
                            <select name="status_id" id="status_id" 
                                class="form-select @error('status_id') is-invalid @enderror"
                                style="border: 2px solid #1A365D; border-radius: 6px; padding: 10px 14px; font-size: 1.3rem;" required>
                                <option value="" selected disabled>-- Seleccionar Estado --</option>
                                @foreach($statuses as $status)
                                    <option value="{{ $status->id }}" {{ old('status_id') == $status->id ? 'selected' : '' }}>
                                        {{ $status->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('status_id')
                                <div class="invalid-feedback" style="font-size: 1.0rem;">
                                    <i class="fas fa-exclamation-circle me-1"></i>{{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-end gap-2 mt-3">
                            <a href="{{ route('admin.memberships.index') }}" class="btn py-1 px-3" 
                                style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem; border: 2px solid #1A365D;">
                                <i class="fas fa-times-circle me-1"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-1 px-3" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-1"></i> CREAR
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
        margin-top: 10px;
    }
    
    .container-fluid {
        padding-top: 0.5rem !important;
    }
    
    .form-control:focus, .form-select:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.2rem rgba(255, 107, 53, 0.25);
    }
    
    .invalid-feedback {
        display: block;
        margin-top: 5px;
        padding: 5px 8px;
        background-color: rgba(255, 107, 53, 0.1);
        border-radius: 5px;
        border-left: 3px solid #FF6B35;
        font-size: 1.0rem;
    }
    
    .btn {
        transition: all 0.2s ease;
        border-radius: 5px;
        padding: 7px 14px;
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
    
    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .card-header h2 {
            font-size: 1.3rem !important;
        }
        
        .container-fluid {
            padding-top: 0 !important;
        }
        
        .form-label {
            font-size: 1.1rem !important;
        }
        
        .form-control, .form-select {
            font-size: 1.0rem !important;
            padding: 7px 9px !important;
        }
        
        .btn {
            font-size: 1.0rem !important;
            padding: 6px 12px !important;
        }
        
        .invalid-feedback {
            font-size: 0.95rem !important;
            padding: 4px 6px !important;
        }
    }
    
    /* Espaciado general */
    .mb-3 {
        margin-bottom: 0.9rem !important;
    }
    
    .card-body {
        padding: 1.2rem !important;
    }
    
    /* Alert de los campos */
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

    // Validación visual en tiempo real para inputs, selects y textarea
    const inputs = document.querySelectorAll('.needs-validation input, .needs-validation select, .needs-validation textarea');
    inputs.forEach(input => {
        if (input.value && input.checkValidity()) {
            input.classList.add('is-valid');
        }
        
        input.addEventListener('input', function () {
            if (input.checkValidity()) {
                input.classList.remove('is-invalid');
                if (input.value) {
                    input.classList.add('is-valid');
                } else {
                    input.classList.remove('is-valid');
                }
            } else {
                input.classList.remove('is-valid');
                input.classList.add('is-invalid');
            }
        });
    });

    // Contador y validación para Nombre (solo letras y espacios)
    const nameInput = document.getElementById('name');
    const nameCharCount = document.getElementById('nameCharCount');
    nameInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        const charCountValue = this.value.length;
        nameCharCount.textContent = `${charCountValue} / 50 caracteres`;

        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            if (this.value) this.classList.add('is-valid');
            else this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });

    // Contador y validación para Descripción (solo letras y espacios)
    const descInput = document.getElementById('description');
    const descCharCount = document.getElementById('descCharCount');
    descInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        const charCountValue = this.value.length;
        descCharCount.textContent = `${charCountValue} / 200 caracteres`;

        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            if (this.value) this.classList.add('is-valid');
            else this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });

    // Inicializar contadores con valores al cargar
    if (nameInput.value) {
        nameCharCount.textContent = `${nameInput.value.length} / 50 caracteres`;
        if (nameInput.checkValidity()) nameInput.classList.add('is-valid');
    }

    if (descInput.value) {
        descCharCount.textContent = `${descInput.value.length} / 200 caracteres`;
        if (descInput.checkValidity()) descInput.classList.add('is-valid');
    }

    // Validar duración también visualmente
    const durationInput = document.getElementById('duration');
    if (durationInput.value && durationInput.checkValidity()) {
        durationInput.classList.add('is-valid');
    }
    durationInput.addEventListener('input', function() {
        if (this.checkValidity()) {
            this.classList.remove('is-invalid');
            if (this.value) this.classList.add('is-valid');
            else this.classList.remove('is-valid');
        } else {
            this.classList.remove('is-valid');
            this.classList.add('is-invalid');
        }
    });
})();
</script>
@endsection

@endsection
