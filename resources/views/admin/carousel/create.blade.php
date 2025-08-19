@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-8">
            <!-- Card Principal -->
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <!-- Header con título -->
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                        <i class="fas fa-plus-circle me-3"></i>AGREGAR NUEVO SLIDE
                    </h2>
                </div>

                <!-- Cuerpo del Card -->
                <div class="card-body p-4">
                    <!-- Mensajes de error -->
                    @if($errors->any())
                        <div class="alert alert-dismissible fade show mb-4" role="alert" 
                            style="background-color: #FF6B35; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-triangle me-3 fs-4"></i>
                                <div>
                                    <strong class="fs-5">Error en el formulario:</strong>
                                    <ul class="mb-0 ps-4">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <!-- Formulario de Creación -->
                    <form action="{{ route('admin.carousel.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5" novalidate>
                        @csrf

                        <!-- Descripción con contador -->
                        <div class="mb-4">
                            <label for="description" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                Descripción <span class="text-muted" style="font-size: 1rem;">(máximo 255 caracteres)</span>
                            </label>
                            <textarea name="description" id="description" maxlength="255"
    placeholder="Escribe una descripción clara y concisa"
    class="form-control {{ $errors->has('description') ? 'is-invalid' : '' }}"
    style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D; min-height: 100px;">{{ old('description') }}</textarea>

                            <div class="mt-1" style="font-size: 1.1rem; color: #1A365D;">
                                Letras usadas: <span id="char-count">{{ strlen(old('description') ?? '') }}</span>/255
                            </div>
                            @error('description')
                                <div class="invalid-feedback" style="font-size: 1.1rem; color: #FF6B35;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Imagen -->
                        <div class="mb-4">
                            <label for="image" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">Imagen <span class="text-danger">*</span></label>
                            <input type="file" name="image" id="image" required
                                class="form-control {{ $errors->has('image') ? 'is-invalid' : '' }}"
                                style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D;">
                            <small class="text-muted" style="font-size: 1.1rem;">Formatos recomendados: JPG, PNG. Tamaño máximo: 5MB</small>
                            @error('image')
                                <div class="invalid-feedback" style="font-size: 1.1rem; color: #FF6B35;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Enlace -->
                        <div class="mb-4">
                            <label for="link_url" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">Enlace (opcional)</label>
                            <input type="url" name="link_url" id="link_url" 
                                class="form-control {{ $errors->has('link_url') ? 'is-invalid' : (old('link_url') ? 'is-valid' : '') }}"
                                style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D;"
                                value="{{ old('link_url') }}" placeholder="https://ejemplo.com">
                            @error('link_url')
                                <div class="invalid-feedback" style="font-size: 1.1rem; color: #FF6B35;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Orden de Aparición -->
                        <div class="mb-4">
                            <label for="display_order" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                <i class=""></i>Orden de aparición
                            </label>
                            <input type="number" name="display_order" id="display_order"
                                   class="form-control {{ $errors->has('display_order') ? 'is-invalid' : '' }}"
                                   style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D; background-color: #e9ecef;"
                                   value="{{ old('display_order', $nextOrder ?? '') }}"
                                   readonly>
                            @error('display_order')
                                <div class="invalid-feedback" style="font-size: 1.1rem; color: #FF6B35;">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                        <!-- Estado (oculto ya que siempre será activo) -->
                        <input type="hidden" name="is_active" value="1">

                        <!-- Botones -->
                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.carousel.index') }}" class="btn py-2 px-4 me-3" 
                                style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.2rem;">
                                <i class="fas fa-times me-2"></i> CANCELAR
                            </a>
                            <button type="submit" class="btn py-2 px-4" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.2rem;">
                                <i class="fas fa-save me-2"></i> GUARDAR
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
    
    .alert {
        border-radius: 6px;
    }

    .form-label {
        margin-bottom: 0.5rem;
        display: block;
    }

    .form-control, .form-select {
        width: 100%;
        border-radius: 6px;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #FF6B35;
        box-shadow: 0 0 0 0.25rem rgba(255, 107, 53, 0.25);
    }

    .text-danger {
        color: #FF6B35;
    }

    /* Estilos para validación */
    .is-valid {
        border-color: #2EC4B6 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 8 8'%3e%3cpath fill='%232EC4B6' d='M2.3 6.73L.6 4.53c-.4-1.04.46-1.4 1.1-.8l1.1 1.4 3.4-3.8c.6-.63 1.6-.27 1.2.7l-4 4.6c-.43.5-.8.4-1.1.1z'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .is-invalid {
        border-color: #FF6B35 !important;
        background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 12 12' width='12' height='12' fill='none' stroke='%23FF6B35'%3e%3ccircle cx='6' cy='6' r='4.5'/%3e%3cpath stroke-linejoin='round' d='M5.8 3.6h.4L6 6.5z'/%3e%3ccircle cx='6' cy='8.2' r='.6' fill='%23FF6B35' stroke='none'/%3e%3c/svg%3e") !important;
        background-repeat: no-repeat;
        background-position: right calc(0.375em + 0.1875rem) center;
        background-size: calc(0.75em + 0.375rem) calc(0.75em + 0.375rem);
    }

    .invalid-feedback {
        display: block;
        color: #FF6B35;
        font-size: 1.1rem;
        margin-top: 0.25rem;
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
        
        .form-label {
            font-size: 1.2rem !important;
        }
        
        .form-control, .form-select {
            font-size: 1.1rem !important;
            padding: 0.6rem !important;
        }
    }
</style>

@section('scripts')
<script>
    const descriptionInput = document.getElementById('description');
    const charCount = document.getElementById('char-count');
    const form = document.querySelector('form[action="{{ route('admin.carousel.store') }}"]');
    const submitBtn = form.querySelector('button[type="submit"]');
    const regex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

    // Inicializar contador si tiene valor viejo
    charCount.textContent = descriptionInput.value.length;

    function validateDescription() {
        let value = descriptionInput.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        descriptionInput.value = value;
        charCount.textContent = value.length;

        // Quitar ambas clases para evitar conflicto
        descriptionInput.classList.remove('is-valid', 'is-invalid');

        if (value.trim() === '' || !regex.test(value)) {
            descriptionInput.classList.add('is-invalid');
            return false;
        } else {
            descriptionInput.classList.add('is-valid');
            return true;
        }
    }

    // Validación en tiempo real al escribir
    descriptionInput.addEventListener('input', validateDescription);

    // Validación al enviar el formulario
    form.addEventListener('submit', function (event) {
        const isDescValid = validateDescription();

        // Validar formulario HTML + nuestra validación personalizada
        if (!form.checkValidity() || !isDescValid) {
            event.preventDefault();
            event.stopPropagation();

            descriptionInput.classList.remove('is-valid');
            descriptionInput.classList.add('is-invalid');

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

        } else {
            descriptionInput.classList.remove('is-invalid');
            descriptionInput.classList.add('is-valid');

            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i> CREANDO...';
            submitBtn.disabled = true;
        }

        form.classList.add('was-validated');
    });

    // Validación de imagen (como la tienes)
    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        if (file) {
            if (file.size > 5 * 1024 * 1024) {
                alert('El archivo es demasiado grande. Máximo permitido 5MB.');
                e.target.value = '';
            }

            const validTypes = ['image/jpeg', 'image/png', 'image/gif'];
            if (!validTypes.includes(file.type)) {
                alert('Formato no válido. Solo JPG, PNG o GIF.');
                e.target.value = '';
            }
        }
    });
</script>
@endsection
@endsection
