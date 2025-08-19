@extends('layouts.app-master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary-dark: #1A365D;
    --primary-light: #2EC4B6;
    --accent-yellow: #FFD166;
    --accent-orange: #FF6B35;
    --accent-red: #d82c0d;
    --white: #FFFFFF;
    --light-gray: #f8f9fa;
    --medium-gray: #e9ecef;
}

.membership-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 2rem 1rem;
}

.membership-header {
    text-align: center;
    margin-bottom: 3rem;
}

.membership-title {
    font-size: 1.8rem;
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-weight: 700;
}

.membership-subtitle {
    font-size: 1.6rem;
    color: var(--primary-dark);
    opacity: 0.8;
}

.membership-card {
    background-color: var(--white);
    border-radius: 8px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    padding: 2rem;
    margin-bottom: 2rem;
    border: 2px solid var(--primary-dark);
}

.membership-name {
    font-size: 1.6rem;
    color: var(--primary-dark);
    margin-bottom: 1.5rem;
    font-weight: 700;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.membership-name i {
    color: var(--primary-light);
}

.membership-detail {
    font-size: 1.3rem;
    margin-bottom: 1rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.membership-detail i {
    color: var(--primary-dark);
    width: 20px;
    text-align: center;
}

.membership-divider {
    height: 1px;
    background-color: var(--primary-dark);
    margin: 1.5rem 0;
    opacity: 0.2;
}

.instructions-title {
    font-size: 1.5rem;
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-weight: 600;
}

.instructions-list {
    list-style: none;
    padding: 0;
}

.instructions-list li {
    font-size: 1.3rem;
    margin-bottom: 0.8rem;
    display: flex;
    align-items: center;
    gap: 0.8rem;
}

.instructions-list i {
    color: var(--accent-orange);
}

.upload-btn {
    display: inline-flex;
    align-items: center;
    gap: 0.8rem;
    padding: 0.8rem 1.5rem;
    background-color: var(--primary-dark);
    color: var(--white);
    border: none;
    border-radius: 6px;
    font-size: 1.3rem;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    margin-top: 1.5rem;
}

.upload-btn:hover {
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    color: var(--white);
    background-color: #122a4a;
}

/* Responsive Adjustments */
@media (max-width: 1200px) {
    .membership-container {
        max-width: 95%;
    }
}

@media (max-width: 992px) {
    .membership-header {
        margin-bottom: 2.5rem;
    }
    
    .membership-title {
        font-size: 1.7rem;
    }
    
    .membership-subtitle {
        font-size: 1.5rem;
    }
}

@media (max-width: 768px) {
    .membership-header {
        margin-bottom: 2rem;
    }
    
    .membership-title {
        font-size: 1.6rem;
    }
    
    .membership-subtitle {
        font-size: 1.4rem;
    }
    
    .membership-card {
        padding: 1.5rem;
    }
    
    .membership-name {
        font-size: 1.4rem;
    }
    
    .membership-detail,
    .instructions-list li {
        font-size: 1.2rem;
    }
    
    .instructions-title {
        font-size: 1.4rem;
    }
    
    .upload-btn {
        font-size: 1.2rem;
    }
}

@media (max-width: 576px) {
    .membership-container {
        padding: 1.5rem 0.8rem;
    }
    
    .membership-title {
        font-size: 1.5rem;
    }
    
    .membership-subtitle {
        font-size: 1.3rem;
    }
    
    .membership-card {
        padding: 1.2rem;
    }
    
    .membership-name {
        font-size: 1.3rem;
    }
    
    .membership-detail,
    .instructions-list li {
        font-size: 1.1rem;
    }
    
    .instructions-title {
        font-size: 1.3rem;
    }
    
    .upload-btn {
        width: 100%;
        justify-content: center;
    }
}

@media (max-width: 400px) {
    .membership-header i.fa-4x {
        font-size: 3rem;
    }
    
    .membership-title {
        font-size: 1.4rem;
    }
    
    .membership-subtitle {
        font-size: 1.2rem;
    }
    
    .membership-name,
    .membership-detail,
    .instructions-list li {
        flex-direction: column;
        align-items: flex-start;
        gap: 0.5rem;
    }
    
    .membership-detail i,
    .instructions-list i {
        width: auto;
    }
}
</style>

<div class="membership-container">
    <!-- Encabezado -->
    <div class="membership-header">
        <i class="fas fa-id-card-alt fa-4x mb-3" style="color: var(--primary-dark);"></i>
        <h1 class="membership-title" style="font-size: 1.8rem">Detalles de Membresía</h1>
        <p class="membership-subtitle" style="font-size: 1.6rem">Información completa de tu membresía seleccionada</p>
    </div>

    <!-- Tarjeta de Membresía -->
    <div class="membership-card">
        <h3 class="membership-name" style="font-size: 1.6rem">
            <i class="fas fa-crown"></i>
            {{ $membership->name }}
        </h3>
        
        <div class="membership-detail" style="font-size: 1.3rem">
            <i class="far fa-calendar-alt"></i>
            <span><strong>Duración:</strong> {{ $membership->readable_duration }}</span>
        </div>
        
        <div class="membership-detail" style="font-size: 1.3rem">
            <i class="fas fa-dollar-sign"></i>
            <span><strong>Precio actual:</strong> ${{ number_format($membership->price, 2) }}</span>
        </div>
        
        <div class="membership-detail" style="font-size: 1.3rem">
            <i class="fas fa-info-circle"></i>
            <span><strong>Descripción:</strong> {{ $membership->description }}</span>
        </div>

        <div class="membership-divider"></div>

        <h5 class="instructions-title" style="font-size: 1.5rem">
            <i class="fas fa-university me-2"></i>Instrucciones para Transferencia
        </h5>
        
        <ul class="instructions-list">
            <li style="font-size: 1.3rem">
                <i class="fas fa-landmark"></i>
                <span><strong>Banco:</strong> BBVA</span>
            </li>
            <li style="font-size: 1.3rem">
                <i class="fas fa-money-check-alt"></i>
                <span><strong>CLABE:</strong> 012345678901234567</span>
            </li>
            <li style="font-size: 1.3rem">
                <i class="fas fa-user-tag"></i>
                <span><strong>Referencia:</strong> Tu nombre completo</span>
            </li>
        </ul>

        <a href="{{ route('user.payments.upload', $membership->id) }}" class="upload-btn" style="font-size: 1.4rem">
            <i class="fas fa-cloud-upload-alt"></i> Subir Comprobante
        </a>
    </div>

    <div class="mt-4">
        <a href="{{ route('user.memberships.index') }}" class="btn" style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.4rem; font-weight: 600;">
            <i class="fas fa-arrow-left me-1"></i> Volver a la membresia
        </a>
    </div>
</div>
</div>
@endsection