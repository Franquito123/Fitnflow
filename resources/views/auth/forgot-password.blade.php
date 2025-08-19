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

    .recover-container {
        max-width: min(600px, 90%);
        margin: clamp(1rem, 5vh, 3rem) auto;
        padding: clamp(1rem, 3vw, 2rem);
        background-color: var(--white);
        border: 4px solid var(--primary-dark);
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .recover-container h2 {
        text-align: center;
        color: var(--primary-dark);
        margin-bottom: clamp(1rem, 3vh, 1.5rem);
        font-size: clamp(1.4rem, 4vw, 1.8rem);
        font-weight: 700;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
    }

    .recover-container form label {
        display: block;
        font-weight: 600;
        margin-bottom: 0.4rem;
        color: var(--primary-dark);
        font-size: clamp(1.1rem, 3vw, 1.4rem);
    }

    .recover-container form input[type="email"] {
        width: 100%;
        padding: clamp(0.7rem, 2vw, 0.9rem);
        margin-bottom: 1rem;
        border: 1px solid var(--primary-dark);
        border-radius: 6px;
        font-size: clamp(1rem, 3vw, 1.3rem);
        background-color: var(--light-gray);
    }

    .recover-container form input:focus {
        outline: none;
        border-color: var(--primary-light);
        background-color: var(--white);
        box-shadow: 0 0 0 2px rgba(46, 196, 182, 0.2);
    }

    .recover-container .error-message {
        color: var(--accent-red);
        font-size: clamp(1rem, 3vw, 1.3rem);
        margin-bottom: 1rem;
    }

    .alert-success {
        background-color: var(--primary-light);
        color: var(--white);
        padding: clamp(0.8rem, 2vw, 1rem);
        margin-bottom: clamp(1rem, 3vh, 1.5rem);
        border-radius: 6px;
        border: 1px solid var(--primary-dark);
        font-size: clamp(1.1rem, 3vw, 1.5rem);
        display: flex;
        align-items: center;
        gap: 0.8rem;
    }

    .recover-container button {
        background-color: var(--primary-dark);
        color: var(--white);
        padding: clamp(0.7rem, 2vw, 0.9rem) 1.5rem;
        border: none;
        border-radius: 8px;
        font-size: clamp(1.1rem, 3vw, 1.3rem);
        font-weight: 600;
        cursor: pointer;
        transition: all 0.3s ease;
        width: 100%;
    }

    .recover-container button:hover {
        background-color: #142a4a;
        transform: translateY(-1px);
    }

    .recover-container button:active {
        transform: translateY(0);
    }

    /* Espaciado responsivo */
    .recover-spacing {
        height: clamp(2rem, 8vh, 4rem);
    }

    @media (max-width: 400px) {
        .recover-container h2 {
            flex-direction: column;
            gap: 0.3rem;
        }
        
        .alert-success {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }
    }
</style>

<div class="recover-spacing"></div>
<div class="recover-container">
    <h2><i class="fas fa-unlock-alt"></i>Recuperar Contraseña</h2>

    @if (session('status'))
        <div class="alert alert-success">
            <i class="fas fa-check-circle"></i> {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}">
        @csrf
        <div>
            <label for="email">Correo electrónico</label>
            <input type="email" name="email" required autofocus>
            @error('email')
                <div class="error-message">{{ $message }}</div>
            @enderror
        </div>
        <button type="submit">Enviar enlace</button>
    </form>
</div>
<div class="recover-spacing"></div>
@endsection