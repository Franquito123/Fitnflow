@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-8">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                        <i class="fas fa-edit me-2"></i>EDITAR INFORMACIÓN DEL CENTRO
                    </h2>
                </div>

                <div class="card-body p-4">
                    <form id="centerForm" action="{{ route('admin.center-information.update', $centerInformation->id) }}" method="POST">
                        @csrf
                        @method('PUT')

                        {{-- Horario de Apertura --}}
                        <div class="mb-4 position-relative">
                            <label for="opening_time" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-clock me-2"></i>Horario de Apertura
                            </label>
                            <input type="time" name="opening_time" id="opening_time" 
                                value="{{ old('opening_time', $centerInformation->opening_time) }}" 
                                class="form-control validate-field"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <span class="validation-icon" id="icon-opening_time" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('opening_time')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Horario de Cierre --}}
                        <div class="mb-4 position-relative">
                            <label for="closing_time" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-clock me-2"></i>Horario de Cierre
                            </label>
                            <input type="time" name="closing_time" id="closing_time" 
                                value="{{ old('closing_time', $centerInformation->closing_time) }}" 
                                class="form-control validate-field"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <span class="validation-icon" id="icon-closing_time" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('closing_time')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Días de Atención --}}
                        <div class="mb-4 position-relative">
                            <label for="days" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-calendar-alt me-2"></i>Días de Atención
                            </label>
                            <input type="text" name="days" id="days" 
                                value="{{ old('days', $centerInformation->days) }}" 
                                class="form-control validate-field" data-max="20" 
                                placeholder="Ejemplo: Lunes a Viernes, Sábado"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <small id="count-days" class="text-muted"></small>
                            <span class="validation-icon" id="icon-days" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('days')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Teléfono --}}
                        <div class="mb-4 position-relative">
                            <label for="phone" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-phone me-2"></i>Teléfono
                            </label>
                            <input type="text" name="phone" id="phone" 
                                value="{{ old('phone', $centerInformation->phone) }}" 
                                class="form-control validate-field" data-max="10" 
                                placeholder="Ejemplo: 9999999999"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <small id="count-phone" class="text-muted"></small>
                            <span class="validation-icon" id="icon-phone" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('phone')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Email --}}
                        <div class="mb-4 position-relative">
                            <label for="email" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" 
                                value="{{ old('email', $centerInformation->email) }}" 
                                class="form-control validate-field" data-max="50" 
                                placeholder="Ejemplo: correo@ejemplo.com"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <small id="count-email" class="text-muted"></small>
                            <span class="validation-icon" id="icon-email" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('email')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Dirección --}}
                        <div class="mb-4 position-relative">
                            <label for="address" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-map-marker-alt me-2"></i>Dirección
                            </label>
                            <input type="text" name="address" id="address" 
                                value="{{ old('address', $centerInformation->address) }}" 
                                class="form-control validate-field" data-max="100" 
                                placeholder="Ejemplo: Calle #123, Colonia, Ciudad"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; padding-right: 2.5rem;">
                            <small id="count-address" class="text-muted"></small>
                            <span class="validation-icon" id="icon-address" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('address')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        {{-- Mapa Embed --}}
                        <div class="mb-4 position-relative">
                            <label for="map_embed" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-map me-2"></i>Mapa (Embed HTML)
                            </label>
                            <textarea name="map_embed" id="map_embed" rows="4" 
                                class="form-control validate-field" data-max="1000" 
                                placeholder="Pega aquí el código HTML del iframe de Google Maps"
                                style="border-color: #1A365D; font-size: 1.2rem; color: #1A365D; min-height: 100px; padding-right: 2.5rem;">{{ old('map_embed', $centerInformation->map_embed) }}</textarea>
                            <small id="count-map" class="text-muted"></small>
                            <span class="validation-icon" id="icon-map_embed" style="position: absolute; right: 10px; top: 42px; font-size: 1.5rem; pointer-events:none;"></span>
                            @error('map_embed')
                                <p class="mt-1" style="color: #FF6B35; font-size: 1.1rem;">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.center-information.index') }}" class="btn py-2 px-4 me-3" 
                               style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.2rem;">
                                <i class="fas fa-times me-2"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-2 px-4" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.2rem;">
                                <i class="fas fa-save me-2"></i> ACTUALIZAR
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
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.3s ease;
    }
    
    .btn:hover {
        transform: translateY(-2px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    input, textarea {
        width: 100% !important;
        padding: 0.75rem !important;
        font-size: 1.2rem !important;
    }
    
    textarea {
        min-height: 100px;
    }
    
    /* Validación íconos */
    .is-valid {
        border-color: #28a745 !important;
    }
    .is-invalid {
        border-color: #dc3545 !important;
    }
    .validation-icon {
        color: transparent;
    }
    .is-valid + .validation-icon::after {
        content: "\f00c"; /* FontAwesome check */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #28a745;
    }
    .is-invalid + .validation-icon::after {
        content: "\f00d"; /* FontAwesome times (X) */
        font-family: "Font Awesome 5 Free";
        font-weight: 900;
        color: #dc3545;
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
        
        label {
            font-size: 1.2rem !important;
        }
        
        input, textarea {
            font-size: 1.1rem !important;
            padding: 0.6rem !important;
        }
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('centerForm');
    const fields = document.querySelectorAll('.validate-field');

    // Guardamos valores iniciales para detectar cambios
    const initialValues = {};
    fields.forEach(field => {
        initialValues[field.id] = field.value || '';
    });

    function updateCount(field) {
        const max = field.dataset.max;
        const countId = 'count-' + field.id;
        const countElem = document.getElementById(countId);
        if (!countElem) return;

        countElem.textContent = `${field.value.length} / ${max} caracteres`;
    }

    function updateValidationIcon(field) {
        const icon = document.getElementById('icon-' + field.id);
        if (!icon) return;

        if (field.classList.contains('is-valid')) {
            icon.style.color = '#28a745'; // verde
            icon.textContent = '✔'; // check
        } else if (field.classList.contains('is-invalid')) {
            icon.style.color = '#dc3545'; // rojo
            icon.textContent = '✖'; // x
        } else {
            icon.style.color = 'transparent';
            icon.textContent = '';
        }
    }

    fields.forEach(field => {
        updateCount(field);

        // Validar en input
        field.addEventListener('input', function() {
            if (this.id === 'phone') {
                this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
            }
            updateCount(this);

            if (this.id === 'address') {
                if (this.value.trim().length < 5 || this.value.length > this.dataset.max) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            } else if (this.id === 'phone') {
                if (this.value.length !== 10) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            } else if ((this.id === 'opening_time' || this.id === 'closing_time')) {
                if (this.value.length > 0 && this.value.length !== 5) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else if (this.value.length === 5 || this.value.length === 0) {
                    this.classList.remove('is-invalid');
                    if(this.value.length === 5) {
                        this.classList.add('is-valid');
                    } else {
                        this.classList.remove('is-valid');
                    }
                }
            } else if (this.value.trim() === '' || this.value.length > this.dataset.max) {
                this.classList.remove('is-valid');
                this.classList.add('is-invalid');
            } else {
                this.classList.remove('is-invalid');
                this.classList.add('is-valid');
            }

            updateValidationIcon(this);
        });

        // Actualizar icono al cargar la página
        updateValidationIcon(field);
    });

    form.addEventListener('submit', function(e) {
        let valid = true;
        fields.forEach(field => {
            if (field.id === 'map_embed') {
                if (!field.value.includes('<iframe') || field.value.trim().length < 100) {
                    valid = false;
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            } else if (field.id === 'phone') {
                if (field.value.trim() === '' || field.value.length !== 10) {
                    valid = false;
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            } else if (field.id === 'address') {
                if (field.value.trim().length < 5 || field.value.length > field.dataset.max) {
                    valid = false;
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            } else if ((field.id === 'opening_time' || field.id === 'closing_time')) {
                if (field.value.length > 0 && field.value.length !== 5) {
                    valid = false;
                    field.classList.remove('is-valid');
                    field.classList.add('is-invalid');
                }
            } else if (field.value.trim() === '' || field.value.length > field.dataset.max) {
                valid = false;
                field.classList.remove('is-valid');
                field.classList.add('is-invalid');
            }
        });

        if (!valid) {
            e.preventDefault();
            Swal.fire({
                icon: 'warning',
                title: 'Campos incompletos',
                text: 'Por favor completa todos los campos obligatorios antes de continuar.',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#1A365D',
                background: '#FFFFFF',
                iconColor: '#FF6B35',
                color: '#1A365D'
            });
            return;
        }

        // Verificamos si hubo cambios reales
        let changed = false;
        fields.forEach(field => {
            if((field.value || '') !== (initialValues[field.id] || '')) {
                changed = true;
            }
        });

        if (!changed) {
            e.preventDefault();
            Swal.fire({
                icon: 'info',
                title: 'Sin cambios',
                text: 'No se detectaron cambios para actualizar.',
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#1A365D',
                background: '#FFFFFF',
                iconColor: '#1A365D',
                color: '#1A365D'
            });
            return;
        }

        // Si todo bien, se envía el formulario normalmente
    });
});

document.addEventListener('DOMContentLoaded', function() {
        const openingInput = document.getElementById('opening_time');
        const closingInput = document.getElementById('closing_time');

        // Al hacer clic en el campo, forzamos el enfoque y mostramos el selector
        openingInput.addEventListener('click', function() {
            this.showPicker?.(); // showPicker es soportado por algunos navegadores modernos
        });

        closingInput.addEventListener('click', function() {
            this.showPicker?.();
        });
    });
</script>
@endsection
