@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-8">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                        <i class="fas fa-plus-circle me-2"></i>AGREGAR INFORMACIÓN DEL CENTRO
                    </h2>
                </div>
                <div class="card-body p-4">
                    <form id="centerForm" action="{{ route('admin.center-information.store') }}" method="POST">
                        @csrf

                        <div class="mb-4">
                            <label for="opening_time" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-clock me-2"></i>Horario de Apertura
                            </label>
                            <input type="time" name="opening_time" id="opening_time" class="form-control validate-field" data-max="5" placeholder="Ejemplo: 08:00">
                            @error('opening_time')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="closing_time" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-clock me-2"></i>Horario de Cierre
                            </label>
                            <input type="time" name="closing_time" id="closing_time" class="form-control validate-field" data-max="5" placeholder="Ejemplo: 18:00">
                            @error('closing_time')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="days" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-calendar-alt me-2"></i>Días de Atención
                            </label>
                            <input type="text" name="days" id="days" class="form-control validate-field" data-max="20" placeholder="Ejemplo: Lunes a Viernes, Sábado">
                            <small id="count-days" class="text-muted"></small>
                            @error('days')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="phone" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-phone me-2"></i>Teléfono
                            </label>
                            <input type="text" name="phone" id="phone" class="form-control validate-field" data-max="10" placeholder="Ejemplo: 9999999999">
                            <small id="count-phone" class="text-muted"></small>
                            @error('phone')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="email" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-envelope me-2"></i>Email
                            </label>
                            <input type="email" name="email" id="email" class="form-control validate-field" data-max="50" placeholder="Ejemplo: correo@ejemplo.com">
                            <small id="count-email" class="text-muted"></small>
                            @error('email')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="address" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-map-marker-alt me-2"></i>Dirección
                            </label>
                            <input type="text" name="address" id="address" class="form-control validate-field" data-max="100" placeholder="Ejemplo: Calle #123, Colonia, Ciudad">
                            <small id="count-address" class="text-muted"></small>
                            @error('address')
                                <p class="mt-1 text-danger">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label for="map_embed" class="block mb-2" style="font-size: 1.3rem; color: #1A365D; font-weight: 600;">
                                <i class="fas fa-map me-2"></i>Mapa (Embed HTML)
                            </label>
                            <textarea name="map_embed" id="map_embed" rows="4" class="form-control validate-field" data-max="1000" placeholder="Pega aquí el código HTML del iframe de Google Maps"></textarea>
                            <small id="count-map" class="text-muted"></small>
                            @error('map_embed')
                                <p class="mt-1 text-danger">{{ $message }}</p>
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

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const form = document.getElementById('centerForm');
        const fields = document.querySelectorAll('.validate-field');

        fields.forEach(field => {
            field.addEventListener('input', function() {
                const max = this.dataset.max;
                const countId = 'count-' + this.id;
                const countElem = document.getElementById(countId);
                if (countElem) countElem.textContent = `${this.value.length} / ${max} caracteres`;

                if (this.id === 'phone') {
    this.value = this.value.replace(/[^0-9]/g, '').slice(0, 10);
}


                if (this.value.trim() === '' || this.value.length > max) {
                    this.classList.remove('is-valid');
                    this.classList.add('is-invalid');
                } else {
                    this.classList.remove('is-invalid');
                    this.classList.add('is-valid');
                }
            });
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
                    if (field.value.trim().length < 5 || field.value.length > 100) {
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
            }
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
