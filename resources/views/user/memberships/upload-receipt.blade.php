@extends('layouts.app-master')

@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary-dark: #1A365D;
    --primary-light: #2EC4B6;
    --accent-orange: #FF6B35;
    --white: #FFFFFF;
    --light-gray: #f8f9fa;
    --medium-gray: #e9ecef;
}

/* Contenedor principal */
.content-container {
    display: flex;
    flex-direction: column;
    align-items: center;
    padding: 2rem 1rem;
}

/* Tarjeta */
.upload-container {
    width: 100%;
    max-width: 800px;
    background-color: var(--white);
    border-radius: 8px;
    padding: 2.5rem;
    border: 2px solid var(--primary-dark);
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
}

.upload-title {
    font-size: 1.8rem;
    color: var(--primary-dark);
    margin-bottom: 2rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.upload-form {
    margin-top: 1rem;
}

.form-label {
    font-size: 1.3rem;
    color: var(--primary-dark);
    font-weight: 600;
    margin-bottom: 0.8rem;
    display: block;
}

.form-control {
    width: 100%;
    padding: 0.8rem 1rem;
    font-size: 1.3rem;
    border: 2px solid var(--primary-dark);
    border-radius: 6px;
    margin-bottom: 1.5rem;
    transition: all 0.3s ease;
}

.form-control:focus {
    border-color: var(--primary-light);
    box-shadow: 0 0 0 3px rgba(46, 196, 182, 0.3);
    outline: none;
}

.file-input-wrapper {
    position: relative;
    overflow: hidden;
    width: 100%;
}

.file-input-label {
    display: flex;
    align-items: center;
    justify-content: space-between;
    padding: 0.8rem 1rem;
    background-color: var(--light-gray);
    border: 2px dashed var(--primary-dark);
    border-radius: 6px;
    font-size: 1.3rem;
    color: var(--primary-dark);
    cursor: pointer;
    transition: all 0.3s ease;
}

.file-input-wrapper input[type="file"] {
    position: absolute;
    top: 0;
    left: 0;
    opacity: 0;
    height: 100%;
    width: 100%;
    cursor: pointer;
}

.file-input-label:hover {
    background-color: var(--medium-gray);
}

.file-input-icon {
    color: var(--primary-light);
    font-size: 1.5rem;
}

.submit-btn {
    background-color: var(--primary-dark);
    color: var(--white);
    border: none;
    border-radius: 6px;
    padding: 0.8rem 1.5rem;
    font-size: 1.3rem;
    font-weight: 600;
    cursor: pointer;
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    transition: all 0.3s ease;
}

.submit-btn:hover {
    background-color: #122a4a;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

.back-btn-container {
    width: 100%;
    max-width: 800px;
    margin-top: 1.5rem;
    display: flex;
    justify-content: flex-start;
    padding-left: 0.5rem;
}


.back-btn {
    display: inline-flex;
    align-items: center;
    justify-content: center;
    gap: 0.5rem;
    padding: 0.8rem 1.5rem;
    background-color: var(--accent-orange);
    color: var(--white);
    border: none;
    border-radius: 6px;
    font-size: 1.3rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
}

.back-btn:hover {
    background-color: #d95a2c;
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

/* Responsive */
@media (max-width: 768px) {
    .submit-btn,
    .back-btn {
        width: 100%;
        font-size: 1.2rem;
        justify-content: center;
    }
}
</style>

<div class="content-container">

    <!-- Contenedor principal -->
    <div class="upload-container">
        <h2 class="upload-title">
            <i class="fas fa-file-upload"></i> Subir Comprobante de Pago
        </h2>

        <form action="{{ route('user.payments.store') }}" method="POST" enctype="multipart/form-data" class="upload-form">
            @csrf

            <input type="hidden" name="membership_id" value="{{ $membership->id }}">
            <input type="hidden" name="price" value="{{ $membership->price }}">

            <label for="receipt" class="form-label">Comprobante de pago (PDF, JPG, PNG)</label>
            <div class="file-input-wrapper">
                <label class="file-input-label" for="receipt">
                    <span id="file-name">Seleccionar archivo...</span>
                    <i class="fas fa-paperclip file-input-icon"></i>
                </label>
                <input type="file" id="receipt" class="form-control" name="receipt" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>

            <div class="mt-4">
                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i> Enviar comprobante
                </button>
            </div>
        </form>
    </div>

    <!-- Botón regresar FUERA del contenedor -->
    <div class="back-btn-container">
        <a href="{{ route('user.memberships.pay', $membership->id) }}" class="back-btn">
            <i class="fas fa-arrow-left"></i> Regresar
        </a>
    </div>
</div>

<script>
document.getElementById('receipt').addEventListener('change', function(e) {
    const fileName = e.target.files[0] ? e.target.files[0].name : 'Seleccionar archivo...';
    document.getElementById('file-name').textContent = fileName;
});
</script>
@endsection
