@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                            <i class="fas fa-user-edit me-3"></i>EDITAR USUARIO
                        </h2>
                    </div>
                </div>

                <div class="card-body p-4" style="background-color: #F4F4F4;">
                    @if($errors->any())
                        <div class="alert alert-dismissible fade show alert-error" role="alert">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-exclamation-circle me-3 alert-icon"></i>
                                <div class="alert-message">
                                    <strong>Error en el formulario:</strong>
                                    <ul class="mb-0 ps-4">
                                        @foreach($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                <button type="button" class="btn-close btn-close-white ms-auto" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif
                    
                    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="needs-validation" novalidate id="userFormEdit">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="redirect_filter" value="{{ $redirectFilter }}">

                        <div class="row">
                            <!-- Columna Izquierda -->
                            <div class="col-md-6">
                                <!-- Nombres -->
                                <div class="mb-4 position-relative">
                                    <label for="names" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-user me-2"></i>Nombres
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control w-full p-3 border-2 rounded-lg @error('names') is-invalid @enderror" 
                                            id="names" name="names" value="{{ old('names', $user->names) }}" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                            maxlength="50"
                                            placeholder="Escribe los nombres del usuario"
                                            pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$"
                                            required>
                                    </div>
                                    <small id="names-counter" style="font-size: 1.1rem; color: #1A365D; display: block; text-align: right;">{{ strlen(old('names', $user->names)) }} / 50</small>
                                    @error('names')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Apellidos -->
                                <div class="mb-4 position-relative">
                                    <label for="last_name" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-user-tag me-2"></i>Apellidos
                                    </label>
                                    <div class="input-group">
                                        <input type="text" class="form-control w-full p-3 border-2 rounded-lg @error('last_name') is-invalid @enderror" 
                                            id="last_name" name="last_name" value="{{ old('last_name', $user->last_name) }}" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                            maxlength="50"
                                            placeholder="Escribe los apellidos del usuario"
                                            pattern="^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$"
                                            required>
                                    </div>
                                    <small id="last_name-counter" style="font-size: 1.1rem; color: #1A365D; display: block; text-align: right;">{{ strlen(old('last_name', $user->last_name)) }} / 50</small>
                                    @error('last_name')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Email -->
                                <div class="mb-4 position-relative">
                                    <label for="email" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-envelope me-2"></i>Email
                                    </label>
                                    <div class="input-group">
                                        <input type="email" class="form-control w-full p-3 border-2 rounded-lg @error('email') is-invalid @enderror" 
                                            id="email" name="email" value="{{ old('email', $user->email) }}" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                            placeholder="Escribe el correo electrónico"
                                            required>
                                    </div>
                                    @error('email')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Contraseña (Opcional) -->
                                <div class="mb-4">
                                    <label for="password" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-lock me-2"></i>Contraseña
                                    </label>
                                    <input type="password" class="form-control w-full p-3 border-2 rounded-lg @error('password') is-invalid @enderror" 
                                        id="password" name="password" 
                                        style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                        placeholder="Dejar en blanco para no cambiar">
                                    @error('password')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Confirmar Contraseña -->
                                <div class="mb-4">
                                    <label for="password_confirmation" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-lock me-2"></i>Confirmar Contraseña
                                    </label>
                                    <input type="password" class="form-control w-full p-3 border-2 rounded-lg" 
                                        id="password_confirmation" name="password_confirmation" 
                                        style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                        placeholder="Confirmar nueva contraseña">
                                </div>
                            </div>

                            <!-- Columna Derecha -->
                            <div class="col-md-6">
                                <!-- Rol -->
                                <div class="mb-4 position-relative">
                                    <label for="rol_id" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-user-tie me-2"></i>Rol
                                    </label>
                                    <div class="input-group">
                                        <select class="form-control w-full p-3 border-2 rounded-lg @error('rol_id') is-invalid @enderror" id="rol_id" name="rol_id" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;" required>
                                            <option value="">Seleccione un rol</option>
                                            @foreach($roles as $role)
                                                <option value="{{ $role->id }}" {{ old('rol_id', $user->rol_id) == $role->id ? 'selected' : '' }}>
                                                    {{ $role->name_rol }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('rol_id')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Estado -->
                                <div class="mb-4 position-relative">
                                    <label for="status_id" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-user-check me-2"></i>Estado
                                    </label>
                                    <div class="input-group">
                                        <select class="form-control w-full p-3 border-2 rounded-lg @error('status_id') is-invalid @enderror" id="status_id" name="status_id" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;" required>
                                            <option value="">Seleccione estado</option>
                                            @foreach ($statuses->where('type', 1)->whereIn('name', ['Activo', 'Inactivo']) as $status)
                                                <option value="{{ $status->id }}" {{ old('status_id', $user->status_id) == $status->id ? 'selected' : '' }}>
                                                    {{ $status->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    @error('status_id')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Fecha Nacimiento -->
                                <div class="mb-4 position-relative">
                                    <label for="birth_date" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-calendar-alt me-2"></i>Fecha Nacimiento
                                    </label>
                                    <div class="input-group">
                                        <input type="date" class="form-control w-full p-3 border-2 rounded-lg @error('birth_date') is-invalid @enderror" 
                                            id="birth_date" name="birth_date" value="{{ old('birth_date', $user->birth_date) }}" 
                                            style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;" required>
                                    </div>
                                    @error('birth_date')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Género -->
                                <div class="mb-4">
                                    <label class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                        <i class="fas fa-venus-mars me-2"></i>Género
                                    </label>
                                    <div class="d-flex gap-4">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="masculino" 
                                                value="Masculino" {{ old('gender', $user->gender) == 'Masculino' ? 'checked' : '' }} 
                                                style="width: 20px; height: 20px; margin-top: 4px;" required>
                                            <label class="form-check-label" for="masculino" style="font-size: 1.3rem; color: #1A365D;">Masculino</label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gender" id="femenino" 
                                                value="Femenino" {{ old('gender', $user->gender) == 'Femenino' ? 'checked' : '' }} 
                                                style="width: 20px; height: 20px; margin-top: 4px;">
                                            <label class="form-check-label" for="femenino" style="font-size: 1.3rem; color: #1A365D;">Femenino</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                            <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                        </div>
                                    @enderror
                                </div>

                                <!-- Sección de Especialidad y Certificación -->
                                <div class="row g-3">
                                    <!-- Especialidad -->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label for="specialty" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                                <i class="fas fa-certificate me-2"></i>Especialidad
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control w-full p-3 border-2 rounded-lg @error('specialty') is-invalid @enderror" 
                                                    id="specialty" name="specialty" value="{{ old('specialty', $user->specialty) }}"
                                                    style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                                    disabled>
                                                <span class="input-group-text validation-icon" style="border-color: #1A365D; display: {{ old('specialty', $user->specialty) ? 'flex' : 'none' }};">
                                                    <i class="fas fa-check-circle text-success valid-icon"></i>
                                                    <i class="fas fa-exclamation-circle text-danger invalid-icon"></i>
                                                </span>
                                            </div>
                                            @error('specialty')
                                                <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>

                                    <!-- Certificación -->
                                    <div class="col-md-6">
                                        <div class="form-group position-relative">
                                            <label for="certification" class="block mb-2" style="font-size: 1.4rem; color: #1A365D; font-weight: 600;">
                                                <i class="fas fa-award me-2"></i>Certificación
                                            </label>
                                            <div class="input-group">
                                                <input type="text" class="form-control w-full p-3 border-2 rounded-lg @error('certification') is-invalid @enderror" 
                                                    id="certification" name="certification" value="{{ old('certification', $user->certification) }}"
                                                    style="border-color: #1A365D; font-size: 1.3rem; color: #1A365D; width: 100%;"
                                                    disabled>
                                                <span class="input-group-text validation-icon" style="border-color: #1A365D; display: {{ old('certification', $user->certification) ? 'flex' : 'none' }};">
                                                    <i class="fas fa-check-circle text-success valid-icon"></i>
                                                    <i class="fas fa-exclamation-circle text-danger invalid-icon"></i>
                                                </span>
                                            </div>
                                            @error('certification')
                                                <div class="invalid-feedback" style="display: block; color: #FF6B35; font-size: 1.2rem;">
                                                    <i class="fas fa-exclamation-circle me-2"></i>{{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="d-flex justify-content-end mt-5">
                            <a href="{{ route('admin.users.index', ['roleFilter' => $redirectFilter]) }}" class="btn py-2 px-4 me-3"
                                style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-times me-2"></i> CANCELAR
                            </a>
                            <button type="submit" id="submitBtnEdit" class="btn py-2 px-4"
                                style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                <i class="fas fa-save me-2"></i> ACTUALIZAR USUARIO
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
        border-color: #28a745 !important;
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
    
    .validation-icon {
        border-left: none !important;
    }
    
    .form-control.is-valid {
        border-right: none !important;
    }
    
    .valid-icon, .invalid-icon {
        display: none;
    }
    
    .is-valid + .input-group-text .valid-icon {
        display: inline;
    }
    
    .is-invalid + .input-group-text .invalid-icon {
        display: inline;
    }
    
    .input-group-text {
        transition: all 0.3s ease;
    }
</style>


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function () {
    const form = document.getElementById('userFormEdit');
    const submitBtn = document.getElementById('submitBtnEdit');
    const namesInput = document.getElementById('names');
    const lastNameInput = document.getElementById('last_name');
    const emailInput = document.getElementById('email');
    const namesCounter = document.getElementById('names-counter');
    const lastNameCounter = document.getElementById('last_name-counter');
    const rolSelect = document.getElementById('rol_id');
    const statusSelect = document.getElementById('status_id');
    const birthDateInput = document.getElementById('birth_date');
    const specialtyInput = document.getElementById('specialty');
    const certificationInput = document.getElementById('certification');
    const genderInputs = document.querySelectorAll('input[name="gender"]');

    const maxNames = 50;
    const maxLastName = 50;
    const nameRegex = /^[a-zA-ZáéíóúÁÉÍÓÚñÑ\s]+$/;

    function toggleValidationIcon(input, valid) {
        const iconContainer = input.parentElement.querySelector('.validation-icon');
        if (!iconContainer) return;

        if (valid) {
            iconContainer.style.display = 'flex';
            iconContainer.querySelector('.valid-icon').style.display = 'inline';
            iconContainer.querySelector('.invalid-icon').style.display = 'none';
        } else {
            iconContainer.style.display = 'flex';
            iconContainer.querySelector('.valid-icon').style.display = 'none';
            iconContainer.querySelector('.invalid-icon').style.display = 'inline';
        }
    }

    function updateCounter(input, counter, max) {
        const length = input.value.length;
        counter.textContent = `${length} / ${max}`;
        counter.style.color = (length > max * 0.9) ? '#FF6B35' : '#1A365D';
    }

    function validateInput(input, regex) {
        const feedbackId = input.id + '-feedback';
        const feedbackElement = document.getElementById(feedbackId);

        input.classList.remove('is-valid', 'is-invalid');

        if (input.value.trim() === '') {
            if (feedbackElement) feedbackElement.style.display = 'none';
            toggleValidationIcon(input, false);
            return false;
        }

        if (regex.test(input.value)) {
            input.classList.add('is-valid');
            if (feedbackElement) feedbackElement.style.display = 'none';
            toggleValidationIcon(input, true);
            return true;
        } else {
            input.classList.add('is-invalid');
            if (feedbackElement) feedbackElement.style.display = 'block';
            toggleValidationIcon(input, false);
            return false;
        }
    }

    function validateEmail(input) {
        const feedbackElement = document.getElementById('email-feedback');
        const value = input.value.trim();

        input.classList.remove('is-valid', 'is-invalid');

        if (value === '') {
            if (feedbackElement) feedbackElement.style.display = 'none';
            toggleValidationIcon(input, false);
            return false;
        }

        const comRegex = /^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.com$/;

        if (comRegex.test(value)) {
            input.classList.add('is-valid');
            if (feedbackElement) feedbackElement.style.display = 'none';
            toggleValidationIcon(input, true);
            return true;
        } else {
            input.classList.add('is-invalid');
            if (feedbackElement) feedbackElement.style.display = 'block';
            toggleValidationIcon(input, false);
            return false;
        }
    }

    function initializeFields() {
        validateInput(namesInput, nameRegex);
        validateInput(lastNameInput, nameRegex);
        validateEmail(emailInput);
        updateCounter(namesInput, namesCounter, maxNames);
        updateCounter(lastNameInput, lastNameCounter, maxLastName);
        toggleValidationIcon(namesInput, namesInput.classList.contains('is-valid'));
        toggleValidationIcon(lastNameInput, lastNameInput.classList.contains('is-valid'));
        toggleValidationIcon(emailInput, emailInput.classList.contains('is-valid'));
        toggleValidationIcon(rolSelect, rolSelect.value.trim() !== '');
        toggleValidationIcon(statusSelect, statusSelect.value.trim() !== '');
        toggleValidationIcon(birthDateInput, birthDateInput.value.trim() !== '');

        // Para especialidad y certificación solo si habilitados
        if (!specialtyInput.disabled) {
            validateInput(specialtyInput, /.*/);
            toggleValidationIcon(specialtyInput, specialtyInput.classList.contains('is-valid'));
        } else {
            clearValidation(specialtyInput);
        }
        if (!certificationInput.disabled) {
            validateInput(certificationInput, /.*/);
            toggleValidationIcon(certificationInput, certificationInput.classList.contains('is-valid'));
        } else {
            clearValidation(certificationInput);
        }
    }

    function clearValidation(input) {
        input.classList.remove('is-valid', 'is-invalid');
        const iconContainer = input.parentElement.querySelector('.validation-icon');
        if (iconContainer) iconContainer.style.display = 'none';
        const feedbackElement = document.getElementById(input.id + '-feedback');
        if (feedbackElement) feedbackElement.style.display = 'none';
    }

    namesInput.addEventListener('input', () => {
        namesInput.value = namesInput.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        updateCounter(namesInput, namesCounter, maxNames);
        validateInput(namesInput, nameRegex);
    });

    lastNameInput.addEventListener('input', () => {
        lastNameInput.value = lastNameInput.value.replace(/[^a-zA-ZáéíóúÁÉÍÓÚñÑ\s]/g, '');
        updateCounter(lastNameInput, lastNameCounter, maxLastName);
        validateInput(lastNameInput, nameRegex);
    });

    emailInput.addEventListener('input', () => {
        emailInput.value = emailInput.value.replace(/[^a-zA-Z0-9@._%+-]/g, '');
        validateEmail(emailInput);
    });

    const birthDatePicker = flatpickr("#birth_date", {
        dateFormat: "Y-m-d",
        locale: "es",
        disableMobile: true,
        maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 18)),
        minDate: new Date(new Date().setFullYear(new Date().getFullYear() - 100)),
        allowInput: false,
        clickOpens: true,
        defaultDate: "{{ old('birth_date', $user->birth_date) }}",
        onChange: function(selectedDates, dateStr, instance) {
            validateInput(birthDateInput, /.*/);
        }
    });

    function checkInstructorFields() {
        const selectedOption = rolSelect.options[rolSelect.selectedIndex];
        const isInstructor = selectedOption.textContent.toLowerCase().includes('instructor');

        specialtyInput.disabled = !isInstructor;
        certificationInput.disabled = !isInstructor;

        if (!isInstructor) {
            specialtyInput.value = '';
            certificationInput.value = '';
            clearValidation(specialtyInput);
            clearValidation(certificationInput);
        } else {
            validateInput(specialtyInput, /.*/);
            validateInput(certificationInput, /.*/);
        }
    }

    rolSelect.addEventListener('change', function() {
        checkInstructorFields();
        validateInput(rolSelect, /.*/);
        toggleValidationIcon(rolSelect, rolSelect.value.trim() !== '');
    });

    statusSelect.addEventListener('change', function() {
        validateInput(statusSelect, /.*/);
        toggleValidationIcon(statusSelect, statusSelect.value.trim() !== '');
    });

    genderInputs.forEach(input => {
        input.addEventListener('change', function() {
            const iconContainer = this.closest('.form-check').querySelector('.validation-icon');
            if (iconContainer) {
                iconContainer.style.display = this.checked ? 'flex' : 'none';
                iconContainer.querySelector('.valid-icon').style.display = 'inline';
                iconContainer.querySelector('.invalid-icon').style.display = 'none';
            }
        });
    });

    initializeFields();
    checkInstructorFields();

    form.addEventListener('submit', function (event) {
        let isValid = true;

        if (!namesInput.value.trim() || namesInput.classList.contains('is-invalid')) {
            namesInput.classList.add('is-invalid');
            toggleValidationIcon(namesInput, false);
            isValid = false;
        }

        if (!lastNameInput.value.trim() || lastNameInput.classList.contains('is-invalid')) {
            lastNameInput.classList.add('is-invalid');
            toggleValidationIcon(lastNameInput, false);
            isValid = false;
        }

        if (!emailInput.value.trim() || emailInput.classList.contains('is-invalid')) {
            emailInput.classList.add('is-invalid');
            toggleValidationIcon(emailInput, false);
            isValid = false;
        }

        if (!rolSelect.value) {
            rolSelect.classList.add('is-invalid');
            toggleValidationIcon(rolSelect, false);
            isValid = false;
        }

        if (!statusSelect.value) {
            statusSelect.classList.add('is-invalid');
            toggleValidationIcon(statusSelect, false);
            isValid = false;
        }

        if (!birthDateInput.value) {
            birthDateInput.classList.add('is-invalid');
            toggleValidationIcon(birthDateInput, false);
            isValid = false;
        }

        // Validar solo si están habilitados
        if (!specialtyInput.disabled && specialtyInput.classList.contains('is-invalid')) {
            isValid = false;
        }

        if (!certificationInput.disabled && certificationInput.classList.contains('is-invalid')) {
            isValid = false;
        }

        if (!document.querySelector('input[name="gender"]:checked')) {
            isValid = false;
            Swal.fire({
                icon: 'warning',
                title: '¡Error!',
                text: 'Por favor seleccione un género',
                confirmButtonColor: '#1A365D'
            });
        }

        const password = document.getElementById('password').value;
        const confirmPassword = document.getElementById('password_confirmation').value;
        if (password && password !== confirmPassword) {
            Swal.fire({
                icon: 'error',
                title: 'Error en contraseña',
                text: 'Las contraseñas no coinciden',
                confirmButtonColor: '#1A365D'
            });
            isValid = false;
        }

        if (!isValid) {
            event.preventDefault();
            event.stopPropagation();

            Swal.fire({
                icon: 'warning',
                title: '¡Error!',
                text: 'Por favor complete todos los campos obligatorios correctamente',
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

    const passwordField = document.getElementById('password');
    const confirmPasswordField = document.getElementById('password_confirmation');

    passwordField.addEventListener('input', function() {
        confirmPasswordField.required = passwordField.value !== '';
    });
});
</script>
@endpush

@endsection