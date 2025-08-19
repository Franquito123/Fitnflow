@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                            <i class="fas fa-edit me-3"></i>EDITAR SERVICIO
                        </h2>
                    </div>
                </div>

                <div class="card-body p-4" style="background-color: #F4F4F4;">
                    <form action="{{ route('admin.service.update', $service->id) }}" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate id="serviceFormEdit">
                        @csrf
                        @method('PUT')
                        <div class="row">
                            <!-- Columna izquierda -->
                            <div class="col-md-8">
                                <div class="mb-4 position-relative">
                                    <label for="name" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-tag me-2"></i>Nombre del Servicio
                                    </label>
                                    <input type="text" name="name" id="name" value="{{ old('name', $service->name) }}"
                                        class="form-control w-full p-3 border-2 rounded-lg @error('name') is-invalid @enderror"
                                        style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                        maxlength="15"
                                        placeholder="Escribe el nombre del servicio" required>
                                    <div class="text-end mt-1">
                                        <small id="name-counter" style="font-size: 1.1rem; color: #1A365D;">0 / 15</small>
                                    </div>
                                    @error('name')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4 position-relative">
                                    <label for="description" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-align-left me-2"></i>Descripción
                                    </label>
                                    <textarea name="description" id="description" rows="5"
                                        class="form-control w-full p-3 border-2 rounded-lg @error('description') is-invalid @enderror"
                                        style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%; min-height: 150px; resize: vertical;"
                                        maxlength="400"
                                        placeholder="Describe el servicio de manera clara y concisa" required>{{ old('description', $service->description) }}</textarea>
                                    <div class="text-end mt-1">
                                        <small id="description-counter" style="font-size: 1.1rem; color: #1A365D;">0 / 400</small>
                                    </div>
                                    @error('description')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <div class="mb-4">
                                    <label for="image_url" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-image me-2"></i>Nueva Imagen
                                    </label>
                                    <input type="file" name="image_url" id="image_url"
                                        class="form-control w-full p-3 border-2 rounded-lg @error('image_url') is-invalid @enderror"
                                        style="border-color: #1A365D; font-size: 1.3rem; width: 100%;">
                                    @error('image_url')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Columna derecha - Visualización de imagen actual -->
                            <div class="col-md-4">
                                @if($service->image_url)
                                <div class="sticky-top" style="top: 20px;">
                                    <div class="card shadow-sm mb-4" style="border: 2px solid #1A365D;">
                                        <div class="card-header py-2" style="background-color: #1A365D; color: #FFFFFF;">
                                            <h3 class="mb-0 text-center" style="font-weight: 600; font-size: 1.4rem;">
                                                <i class="fas fa-eye me-2"></i>IMAGEN ACTUAL
                                            </h3>
                                        </div>
                                        <div class="card-body text-center p-3">
                                            @if(Storage::disk('public')->exists($service->image_url))
                                            <img src="{{ asset('storage/'.$service->image_url) }}"
                                                class="img-fluid rounded-lg shadow"
                                                style="max-height: 300px; width: auto; border: 2px solid #F4F4F4;"
                                                onerror="this.onerror=null;this.src='{{ asset('images/default-service.jpg') }}';">
                                            <div class="mt-3">
                                                <a href="{{ asset('storage/'.$service->image_url) }}" target="_blank"
                                                    class="btn py-1 px-3"
                                                    style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.2rem;">
                                                    <i class="fas fa-expand me-1"></i> Ver Completa
                                                </a>
                                            </div>
                                            @else
                                            <div class="alert alert-warning" style="font-size: 1.2rem;">
                                                <i class="fas fa-exclamation-triangle me-2"></i>
                                                La imagen no se encuentra en el almacenamiento
                                            </div>
                                            <p class="text-muted mt-2" style="font-size: 1.1rem;">
                                                Ruta: storage/{{ $service->image_url }}
                                            </p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                @endif
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.service.index') }}" class="btn py-2 px-4 me-3"
                                style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-times me-2"></i> CANCELAR
                            </a>
                            <button type="submit" id="submitBtnEdit" class="btn py-2 px-4"
                                style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-2"></i> GUARDAR CAMBIOS
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    /* Validaciones para inputs */
    .is-valid {
        border-color: #28a745!important;
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
</style>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('serviceFormEdit');
    const nameInput = document.getElementById('name');
    const descriptionInput = document.getElementById('description');
    const nameCounter = document.getElementById('name-counter');
    const descriptionCounter = document.getElementById('description-counter');
    const maxName = 15;
    const maxDescription = 400;
    const validRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]+$/;

    function countLetters(text) {
        const lettersOnly = text.match(/\p{L}/gu) || [];
        return lettersOnly.length;
    }

    function updateCounter(input, counter, max) {
        const length = countLetters(input.value);
        counter.textContent = `${length} / ${max}`;
        counter.style.color = (length > max * 0.9) ? '#FF6B35' : '#1A365D';
    }

    function validateInput(input) {
        input.classList.remove('is-valid', 'is-invalid');

        if (input.value.trim() === '') {
            input.classList.add('is-invalid');
            return false;
        }

        if (validRegex.test(input.value)) {
            input.classList.add('is-valid');
            return true;
        } else {
            input.classList.add('is-invalid');
            return false;
        }
    }

    function filterText(input) {
        input.value = input.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s\-]/g, '');
    }

    nameInput.addEventListener('input', () => {
        filterText(nameInput);
        updateCounter(nameInput, nameCounter, maxName);
        validateInput(nameInput);
    });

    descriptionInput.addEventListener('input', () => {
        filterText(descriptionInput);
        updateCounter(descriptionInput, descriptionCounter, maxDescription);
        validateInput(descriptionInput);
    });

    // Inicialización al cargar
    updateCounter(nameInput, nameCounter, maxName);
    updateCounter(descriptionInput, descriptionCounter, maxDescription);
    validateInput(nameInput);
    validateInput(descriptionInput);

    // Submit del formulario
    form.addEventListener('submit', function (event) {
        const nameValid = validateInput(nameInput);
        const descValid = validateInput(descriptionInput);

        if (!nameValid || !descValid) {
            event.preventDefault();
            event.stopPropagation();

            let errorMsg = '';
            if (!nameValid) {
                errorMsg += 'El campo nombre no puede estar vacío ni contener caracteres inválidos.<br>';
            }
            if (!descValid) {
                errorMsg += 'El campo descripción no puede estar vacío ni contener caracteres inválidos.';
            }

            Swal.fire({
                icon: 'warning',
                title: '¡Error!',
                html: errorMsg,
                confirmButtonText: 'Aceptar',
                confirmButtonColor: '#1A365D',
                background: '#FFFFFF',
                iconColor: '#FF6B35',
                color: '#1A365D',
                width: 400
            });

            form.classList.add('was-validated');
        }
    });

    // Validar imagen
    const imageInput = document.getElementById('image_url');
    imageInput.addEventListener('change', function () {
        const file = this.files[0];
        const allowedTypes = ['image/jpeg', 'image/png', 'image/jpg'];
        const maxSize = 2 * 1024 * 1024; // 2MB

        this.classList.remove('is-valid', 'is-invalid');
        if (file) {
            if (!allowedTypes.includes(file.type)) {
                this.classList.add('is-invalid');
                Swal.fire({
                    icon: 'error',
                    title: 'Formato no válido',
                    text: 'Solo se permiten imágenes JPEG, PNG o JPG.',
                    confirmButtonColor: '#1A365D'
                });
                this.value = '';
            } else if (file.size > maxSize) {
                this.classList.add('is-invalid');
                Swal.fire({
                    icon: 'error',
                    title: 'Archivo muy grande',
                    text: 'El tamaño máximo permitido es 2MB.',
                    confirmButtonColor: '#1A365D'
                });
                this.value = '';
            } else {
                this.classList.add('is-valid');
            }
        }
    });
});
</script>
@endpush
@endsection
