<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú de Usuario - FITNFLOW</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Librería Animate.css para la animación zoomInDown -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<style>
    /* Paleta de colores FITNFLOW */
    :root {
        --azul-marino: #1A365D;
        --naranja-brillante: #FF6B35;
        --verde-esmeralda: #2EC4B6;
        --blanco: #FFFFFF;
        --azul-oscuro: #0f2a4a;
        --neon-glow: #2EC4B6;
    }

    /* Estilos Base */
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Poppins', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    }

    html {
        font-size: 62.5%;
        overflow-x: hidden;
    }

    body {
        background: linear-gradient(135deg, #f5f7fa 0%, #e4edf5 100%);
        min-height: 100vh;
        padding-top: 100px;
    }

    /* Header Principal */
    .main-header {
        position: fixed;
        top: 0;
        width: 100%;
        height: 100px;
        background: var(--azul-marino);
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 20px;
        z-index: 1000;
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        border-bottom: 3px solid var(--naranja-brillante);
        overflow: hidden;
    }

    /* Contenedor de partículas para el navbar */
    .particles-nav {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .particle-nav {
        position: absolute;
        background: rgba(255, 255, 255, 0.25);
        border-radius: 50%;
        animation: float-nav 20s infinite linear;
    }

    @keyframes float-nav {
        0% {
            transform: translateY(0) translateX(0) rotate(0deg);
            opacity: 0.7;
        }
        100% {
            transform: translateY(100px) translateX(100px) rotate(360deg);
            opacity: 0;
        }
    }

    /* Contenedor Logo */
    .logo-container {
        display: flex;
        align-items: center;
        height: 100%;
        flex: 1;
        min-width: 0;
        max-width: 70%;
        position: relative;
        z-index: 2;
    }

    /* Logo con efecto neón */
    .logo-wrapper {
        position: relative;
        width: 100px;
        height: 100px;
        display: flex;
        justify-content: center;
        align-items: center;
    }

    .logo {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid var(--verde-esmeralda);
        background: var(--azul-marino);
        position: relative;
        z-index: 2;
        padding: 3px;
        box-shadow: 
            0 0 10px var(--neon-glow),
            0 0 20px var(--neon-glow),
            0 0 30px var(--neon-glow),
            inset 0 0 10px rgba(46, 196, 182, 0.5);
        animation: neon-glow 1.5s ease-in-out infinite alternate;
    }

    @keyframes neon-glow {
        0% {
            box-shadow: 
                0 0 5px var(--neon-glow),
                0 0 10px var(--neon-glow),
                0 0 15px var(--neon-glow),
                inset 0 0 5px rgba(46, 196, 182, 0.3);
        }
        100% {
            box-shadow: 
                0 0 15px var(--neon-glow),
                0 0 25px var(--neon-glow),
                0 0 40px var(--neon-glow),
                inset 0 0 15px rgba(46, 196, 182, 0.7);
        }
    }

    /* Texto SVG animado */
    .svg-brand {
        margin-left: 20px;
        height: 60px;
        min-width: 220px;
        overflow: visible;
        position: relative;
        z-index: 2;
    }

    .svg-brand text {
        font-family: 'Poppins', sans-serif;
        font-weight: 700;
        text-shadow: 0 0 5px var(--neon-glow);
        animation: text-glow 1.5s ease-in-out infinite alternate;
    }

    @keyframes text-glow {
        from {
            text-shadow: 0 0 5px var(--neon-glow), 0 0 10px var(--neon-glow);
        }
        to {
            text-shadow: 0 0 10px var(--neon-glow), 0 0 20px var(--neon-glow), 0 0 30px var(--neon-glow);
        }
    }

    /* Controles Derecha */
    .header-controls {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-left: auto;
        position: relative;
        z-index: 2;
    }

    /* Botón Logout */
    .logout-button {
        background: var(--naranja-brillante);
        color: var(--blanco);
        border: none;
        padding: 12px 20px;
        border-radius: 30px;
        cursor: pointer;
        transition: all 0.3s ease;
        font-size: 1.4rem;
        font-weight: 600;
        white-space: nowrap;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        overflow: hidden;
    }

    .logout-button:hover {
        background: #e05a2c;
        transform: translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
    }

    .logout-button::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: linear-gradient(
            45deg,
            rgba(255, 255, 255, 0.2) 0%,
            rgba(255, 255, 255, 0.1) 100%
        );
        z-index: 1;
    }

    /* Botón Hamburguesa */
    .hamburger-btn {
        cursor: pointer;
        padding: 10px;
        background: rgba(255, 255, 255, 0.1);
        border-radius: 10px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        width: 50px;
        height: 50px;
        flex-shrink: 0;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        position: relative;
        z-index: 2;
    }

    .hamburger-btn:hover {
        background: rgba(255, 255, 255, 0.2);
        transform: translateY(-2px);
    }

    .hamburger-bar {
        width: 25px;
        height: 3px;
        background: var(--blanco);
        margin: 4px 0;
        transition: all 0.3s ease;
        border-radius: 2px;
    }

    .active .hamburger-bar:first-child {
        transform: rotate(45deg) translate(6px, 6px);
    }

    .active .hamburger-bar:nth-child(2) {
        opacity: 0;
    }

    .active .hamburger-bar:last-child {
        transform: rotate(-45deg) translate(6px, -6px);
    }

    /* Menú Overlay */
    .overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background: rgba(26, 54, 93, 0.98);
        transform: translateX(-100%);
        transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        z-index: 1001;
        padding: 2rem;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow-y: auto;
    }

    .overlay-active {
        transform: translateX(0) !important;
    }

    /* Botón de cierre para móviles */
    .close-menu-btn {
        position: fixed;
        top: 20px;
        right: 20px;
        width: 40px;
        height: 40px;
        background: var(--naranja-brillante);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        cursor: pointer;
        z-index: 1002;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
        transition: all 0.3s ease;
        opacity: 0;
        visibility: hidden;
        transform: translateY(-20px);
    }

    .overlay-active .close-menu-btn {
        opacity: 1;
        visibility: visible;
        transform: translateY(0);
    }

    .close-menu-btn:hover {
        background: #e05a2c;
        transform: scale(1.1) translateY(0);
    }

    .close-menu-btn::before,
    .close-menu-btn::after {
        content: '';
        position: absolute;
        width: 20px;
        height: 2px;
        background: var(--blanco);
    }

    .close-menu-btn::before {
        transform: rotate(45deg);
    }

    .close-menu-btn::after {
        transform: rotate(-45deg);
    }

    /* === Botón flotante de cerrar sesión === */
    #logoutButton {
        position: fixed;
        bottom: 20px;
        left: 50%;
        transform: translateX(-50%);
        width: 90%;
        max-width: 300px;
        height: auto;
        display: flex;
        flex-direction: row;
        align-items: center;
        justify-content: center;
        background: rgba(255, 107, 53, 0.9);
        border: none !important;
        outline: none !important;
        border-radius: 30px;
        padding: 12px 20px;
        cursor: pointer;
        z-index: 1002;
        opacity: 1;
        visibility: visible;
        transition: all 0.3s ease;
        color: var(--blanco);
        font-weight: 600;
        text-transform: uppercase;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        text-decoration: none !important;
    }

    #logoutButton:hover {
        background: rgba(224, 90, 44, 0.9);
        transform: translateX(-50%) translateY(-2px);
        box-shadow: 0 6px 12px rgba(0, 0, 0, 0.25);
    }

    #logoutButton i {
        font-size: 20px;
        color: var(--blanco);
        margin-right: 8px;
        transition: all 0.3s ease;
        text-decoration: none !important;
        border-bottom: none !important;
    }

    #logoutButton .menu-label {
        color: var(--blanco);
        font-size: 1.4rem;
        font-weight: 600;
        text-transform: uppercase;
        text-shadow: 0 1px 3px rgba(0, 0, 0, 0.5);
        text-decoration: none !important;
        border-bottom: none !important;
    }

    #logoutButton:hover i {
        color: var(--blanco);
        transform: scale(1.1);
    }

    /* Efecto de partículas en el overlay */
    .particles-overlay {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        overflow: hidden;
        z-index: 1;
    }

    .particle-overlay {
        position: absolute;
        background: rgba(255, 255, 255, 0.5);
        border-radius: 50%;
        animation: float 15s infinite linear;
    }

    @keyframes float {
        0% {
            transform: translateY(0) translateX(0) rotate(0deg);
            opacity: 1;
        }
        100% {
            transform: translateY(-1000px) translateX(500px) rotate(720deg);
            opacity: 0;
        }
    }

    /* Tarjetas del Menú con iconos circulares */
    .menu-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(120px, 1fr));
        gap: 3rem;
        width: 100%;
        max-width: 1200px;
        padding: 2rem;
        position: relative;
        z-index: 2;
        justify-items: center;
        margin-bottom: 80px; /* Espacio para el botón de logout */
    }

    .menu-card {
        background: transparent;
        border: none;
        width: 120px;
        height: 120px;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        text-decoration: none;
        position: relative;
        opacity: 0;
        transform: translateY(50px);
        transition: all 0.3s ease;
    }

    .menu-card.animate__zoomInDown {
        opacity: 1;
        transform: translateY(0);
    }

    .menu-card i {
        font-size: 5.5rem;
        color: var(--blanco);
        transition: all 0.3s ease;
        text-shadow: 0 2px 10px rgba(0, 0, 0, 0.5);
        background: var(--verde-esmeralda);
        width: 100px;
        height: 100px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: 50%;
        border: 3px solid var(--azul-marino);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.3);
        margin-bottom: 10px;
    }

    .menu-card:hover i {
        transform: scale(1.1);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.4);
    }

    .menu-card .menu-label {
        color: var(--blanco);
        font-size: 1.4rem;
        font-weight: 600;
        text-transform: uppercase;
        white-space: nowrap;
        text-shadow: 0 2px 3px rgba(0, 0, 0, 0.5);
        margin-top: 10px;
        text-align: center;
    }

    /* Colores específicos para cada icono */
    .menu-card:nth-child(1) i { background: var(--azul-marino); }
    .menu-card:nth-child(2) i { background: var(--naranja-brillante); }
    .menu-card:nth-child(3) i { background: var(--verde-esmeralda); }
    .menu-card:nth-child(4) i { background: #1c5c9e; }
    .menu-card:nth-child(5) i { background: #e05a2c; }
    .menu-card:nth-child(6) i { background: #26d8cf; }
    .menu-card:nth-child(7) i { background: var(--azul-oscuro); }
    .menu-card:nth-child(8) i { background: #9b59b6; }
    .menu-card:nth-child(9) i { background: var(--azul-marino); }
    .menu-card:nth-child(10) i { background: #e05a2c; }
    .menu-card:nth-child(11) i { background: #1c5c9e; }

    /* Estilos para el alert de cerrar sesión */
    .swal2-popup.logout-alert {
        border: 3px solid #1A365D;
        font-size: 1.4rem;
        border-radius: 12px;
        padding: 1.5rem;
    }

    .swal2-title.logout-title {
        font-size: 1.6rem !important;
        color: #1A365D !important;
    }

    .swal2-html-container.logout-message {
        font-size: 1.4rem !important;
        color: #1A365D !important;
    }

    /* CONTENEDOR DE BOTONES */
    .swal2-actions.logout-actions {
        gap: 1.5rem !important;
        margin: 1.5rem 0 0 0 !important;
        padding: 0 !important;
        justify-content: center !important;
    }

    /* ESTILOS BASE PARA AMBOS BOTONES (SIMPLIFICADO) */
    .swal2-confirm.logout-confirm,
    .swal2-cancel.logout-cancel {
        font-size: 1.3rem !important;
        padding: 0.9rem 0.9rem !important;
        border-radius: 5px !important;
        margin: 0 5px !important;
        min-width: 100px !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
        border: none !important;
        text-transform: uppercase;
        letter-spacing: 0.5px;
        flex: none !important;
    }

    /* BOTÓN CONFIRMAR (NARANJA) */
    .swal2-confirm.logout-confirm {
        background: #FF6B35 !important;
        color: white !important;
    }

    /* BOTÓN CANCELAR (VERDE) */
    .swal2-cancel.logout-cancel {
        background: #2EC4B6 !important;
        color: white !important;
    }

    /* EFECTOS HOVER */
    .swal2-confirm.logout-confirm:hover,
    .swal2-cancel.logout-cancel:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0,0,0,0.2) !important;
        opacity: 0.9;
    }

    /* EFECTO CLICK */
    .swal2-confirm.logout-confirm:active,
    .swal2-cancel.logout-cancel:active {
        transform: translateY(0);
        box-shadow: 0 2px 3px rgba(0,0,0,0.1) !important;
    }

    /* Responsive */
    @media (max-width: 1200px) {
        .menu-grid {
            grid-template-columns: repeat(auto-fit, minmax(110px, 1fr));
            gap: 2.5rem;
        }
        
        .menu-card {
            width: 110px;
            height: 110px;
        }
        
        .menu-card i {
            width: 90px;
            height: 90px;
            font-size: 5rem;
        }
    }

    /* Media queries específicas para iPad (768px-1024px) */
    @media (min-width: 768px) and (max-width: 1024px) {
        body {
            padding-top: 90px;
        }
        
        .main-header {
            height: 90px;
        }
        
        .logo-wrapper {
            width: 80px;
            height: 80px;
        }
        
        .logo {
            width: 70px;
            height: 70px;
        }
        
        .svg-brand {
            height: 50px;
            min-width: 200px;
        }
        
        /* Ajustes para orientación horizontal en iPad */
        @media (orientation: landscape) {
            .menu-grid {
                grid-template-columns: repeat(5, 1fr);
                gap: 2rem;
            }
            
            #logoutButton {
                max-width: 250px;
                padding: 10px 15px;
            }
        }
        
        /* Ajustes para orientación vertical en iPad */
        @media (orientation: portrait) {
            .menu-grid {
                grid-template-columns: repeat(4, 1fr);
                gap: 2.5rem;
            }
        }
    }

    @media (max-width: 992px) {
        .main-header {
            padding: 0 15px;
        }
        
        .logout-button {
            padding: 10px 16px;
            font-size: 1.3rem;
        }
        
        #logoutButton {
            padding: 10px 15px;
            font-size: 1.3rem;
        }
    }

    @media (max-width: 768px) {
        body {
            padding-top: 90px;
        }
        
        .main-header {
            height: 90px;
        }
        
        .logo-wrapper {
            width: 70px;
            height: 70px;
        }
        
        .logo {
            width: 60px;
            height: 60px;
        }
        
        .svg-brand {
            height: 50px;
            min-width: 180px;
        }
        
        .hamburger-btn {
            width: 45px;
            height: 45px;
            padding: 8px;
        }
        
        .hamburger-bar {
            width: 22px;
            height: 3px;
        }
        
        .menu-grid {
            grid-template-columns: repeat(auto-fit, minmax(100px, 1fr));
            gap: 2.5rem;
        }
        
        .menu-card {
            width: 100px;
            height: 100px;
        }
        
        .menu-card i {
            font-size: 4.5rem;
            width: 80px;
            height: 80px;
        }
        
        .menu-card .menu-label {
            font-size: 1.2rem;
        }
        
        #logoutButton {
            padding: 10px 15px;
            font-size: 1.2rem;
        }
        
        #logoutButton i {
            font-size: 18px;
        }
    }

    @media (max-width: 576px) {
        .main-header {
            height: 85px;
            padding: 0 10px;
        }
        
        .logo-wrapper {
            width: 60px;
            height: 60px;
        }
        
        .logo {
            width: 50px;
            height: 50px;
        }
        
        .svg-brand {
            height: 40px;
            min-width: 150px;
        }
        
        .logout-button {
            padding: 8px 12px;
            font-size: 1.2rem;
        }
        
        .header-controls {
            gap: 10px;
        }
        
        .menu-grid {
            grid-template-columns: repeat(auto-fit, minmax(90px, 1fr));
            gap: 2rem;
        }
        
        .menu-card {
            width: 90px;
            height: 90px;
        }
        
        .menu-card i {
            font-size: 4rem;
            width: 70px;
            height: 70px;
        }
        
        .menu-card .menu-label {
            font-size: 1.1rem;
        }
        
        #logoutButton {
            padding: 8px 12px;
            font-size: 1.1rem;
        }
        
        #logoutButton i {
            font-size: 16px;
        }
    }

    @media (max-width: 480px) {
        .svg-brand {
            min-width: 120px;
        }
        
        .logo-container {
            max-width: 60%;
        }
        
        .logout-button {
            padding: 7px 10px;
            font-size: 1.1rem;
        }
        
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.8rem;
        }

        /* Mostrar el botón de cerrar solo en móviles */
        .close-menu-btn {
            display: flex;
        }
        
        #logoutButton {
            padding: 8px 12px;
            font-size: 1rem;
        }
        
        #logoutButton i {
            font-size: 15px;
        }
    }

    @media (max-width: 360px) {
        .svg-brand {
            display: none;
        }
        
        .logout-button {
            padding: 6px 9px;
            font-size: 1rem;
        }
        
        .hamburger-btn {
            width: 40px;
            height: 40px;
            padding: 6px;
        }
        
        .menu-card i {
            font-size: 3.5rem;
            width: 60px;
            height: 60px;
        }
        
        .menu-card .menu-label {
            font-size: 1rem;
        }
        
        .menu-grid {
            grid-template-columns: repeat(3, 1fr);
            gap: 1.5rem;
        }
        
        #logoutButton {
            padding: 7px 10px;
            font-size: 0.9rem;
        }
        
        #logoutButton i {
            font-size: 14px;
        }
    }

    /* Pantallas muy pequeñas (menos de 320px) */
    @media (max-width: 320px) {
        #logoutButton {
            padding: 6px 8px;
            font-size: 0.8rem;
        }
        
        #logoutButton i {
            font-size: 12px;
            margin-right: 5px;
        }
        
        .menu-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: 1.2rem;
        }
    }
</style>
</head>
<body>
    <!-- Navbar Superior -->
    <header class="main-header">
        <!-- Contenedor de partículas para el navbar -->
        <div class="particles-nav" id="particlesNav"></div>
        
        <div class="logo-container">
            <!-- Logo con efecto neón -->
            <div class="logo-wrapper">
                <img src="/images/logo.png" alt="FITNFLOW" class="logo">
            </div>
            
            <!-- Texto SVG animado -->
            <svg viewBox="0 0 800 100" xmlns="http://www.w3.org/2000/svg" class="svg-brand" style="max-width: 100%; height: 80px;">
                <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                    font-family="Poppins, sans-serif" font-size="60" fill="none"
                    stroke="#2EC4B6" stroke-width="2">
                    FITNFLOW
                    <animate attributeName="stroke-dasharray" from="0, 1000" to="600, 0" dur="3s" repeatCount="indefinite" />
                    <animate attributeName="stroke-dashoffset" from="0" to="-600" dur="3s" repeatCount="indefinite" />
                </text>
            </svg>
        </div>
        
        <div class="header-controls">
            <div class="hamburger-btn" id="hamburgerBtn">
                <div class="hamburger-bar"></div>
                <div class="hamburger-bar"></div>
                <div class="hamburger-bar"></div>
            </div>
        </div>
    </header>
    
    <div class="overlay" id="menuOverlay">
    <!-- Botón de cierre para móviles -->
    <div class="close-menu-btn" id="closeMenuBtn"></div>
    
    <!-- Botón Cerrar Sesión ahora dentro del header del overlay -->
    <a href="#" class="logout-button" id="logoutButton">
        <i class="fas fa-sign-out-alt"></i>
        <span class="menu-label" style="font-size: 1.3rem">Cerrar Sesión</span>
    </a>
    
    <!-- Contenedor de partículas para el overlay -->
    <div class="particles-overlay" id="particlesOverlay"></div>
    
    <div class="menu-grid">
        <a href="{{ route('user.dashboard') }}" class="menu-card">
            <i class="fas fa-home"></i>
            <span class="menu-label">Inicio</span>
        </a>
        <a href="{{ route('user.memberships.index') }}" class="menu-card">
            <i class="fas fa-id-card"></i>
            <span class="menu-label">Membresías</span>
        </a>
        <a href="{{ route('user.payments.index') }}" class="menu-card">
            <i class="fas fa-file-invoice-dollar"></i>
            <span class="menu-label">Historial de Pagos</span>
        </a>
        @if ($hasApprovedMembership)
        <a href="{{ route('user.classes.index') }}" class="menu-card">
            <i class="fas fa-calendar-check"></i>
            <span class="menu-label">Reserva tus Clases</span>
        </a>
        <a href="{{ route('user.classes.history') }}" class="menu-card">
            <i class="fas fa-history"></i>
            <span class="menu-label">Historial de Clases</span>
        </a>
        @endif
    </div>
</div>

<form method="POST" action="{{ route('logout') }}" id="logout-form" style="display: none;">
    @csrf
</form>

<script>
    const hamburgerBtn = document.getElementById('hamburgerBtn');
    const closeMenuBtn = document.getElementById('closeMenuBtn');
    const menuOverlay = document.getElementById('menuOverlay');
    const particlesOverlay = document.getElementById('particlesOverlay');
    const particlesNav = document.getElementById('particlesNav');
    const logoutButton = document.getElementById('logoutButton');
    const logoutForm = document.getElementById('logout-form');
    const menuCards = document.querySelectorAll('.menu-card');

    // Función para mostrar el alert de confirmación de cierre de sesión
    function showLogoutConfirmation() {
        Swal.fire({
            title: '¿Estás seguro?',
            html: '¿Deseas cerrar tu sesión en FITNFLOW?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Sí, cerrar sesión',
            cancelButtonText: 'Cancelar',
            customClass: {
                popup: 'logout-alert',
                title: 'logout-title',
                htmlContainer: 'logout-message',
                confirmButton: 'logout-confirm',
                cancelButton: 'logout-cancel',
                actions: 'logout-actions'
            },
            buttonsStyling: false,
            reverseButtons: true,
            focusCancel: true,
            background: '#FFFFFF',
            iconColor: '#FF6B35',
            confirmButtonColor: '#1A365D',
            cancelButtonColor: '#FF6B35',
            showClass: {
                popup: 'swal2-noanimation',
                backdrop: 'swal2-noanimation'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                logoutForm.submit();
            }
        });
    }

    // Event listener para el botón de logout
    logoutButton.addEventListener('click', function(e) {
        e.preventDefault();
        showLogoutConfirmation();
    });

    function toggleMenu() {
        hamburgerBtn.classList.toggle('active');
        menuOverlay.classList.toggle('overlay-active');
        document.body.style.overflow = menuOverlay.classList.contains('overlay-active') ? 'hidden' : 'auto';
        
        // Si se abre el menú, generamos las partículas y aplicamos la animación a las tarjetas
        if (menuOverlay.classList.contains('overlay-active')) {
            createOverlayParticles();
            applyZoomInAnimation();
        }
    }

    // Función para aplicar la animación zoomInDown a las tarjetas
    function applyZoomInAnimation() {
        // Primero quitamos cualquier animación previa
        menuCards.forEach(card => {
            card.classList.remove('animate__zoomInDown', 'animate__animated');
        });
        
        // Luego aplicamos la animación a cada tarjeta con un pequeño retraso escalonado
        menuCards.forEach((card, index) => {
            // Forzamos un reflow para reiniciar la animación
            void card.offsetWidth;
            
            card.classList.add('animate__animated', 'animate__zoomInDown');
            card.style.animationDelay = `${index * 0.1}s`;
        });
    }

    // Event listeners
    hamburgerBtn.addEventListener('click', toggleMenu);
    closeMenuBtn.addEventListener('click', toggleMenu);
    
    // Evento para las tarjetas del menú
    document.querySelectorAll('.menu-card').forEach(card => {
        if (!card.id || card.id !== 'logoutButton') {
            card.addEventListener('click', function(e) {
                // Solo prevenimos el comportamiento por defecto si no es el botón de logout
                if (!this.id || this.id !== 'logoutButton') {
                    e.preventDefault();
                    toggleMenu();
                    
                    // Simulamos la navegación después de un pequeño retraso
                    setTimeout(() => {
                        window.location.href = this.href;
                    }, 500);
                }
            });
        }
    });

    menuOverlay.addEventListener('click', (e) => {
        if(e.target === menuOverlay) toggleMenu();
    });

    document.addEventListener('keydown', (e) => {
        if(e.key === 'Escape' && menuOverlay.classList.contains('overlay-active')) {
            toggleMenu();
        }
    });

    // Crear efecto de partículas en el navbar
    function createNavbarParticles() {
        const particleCount = 12;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle-nav');
            
            // Tamaño más pequeño (1-2px)
            const size = Math.random() * 1 + 1;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            // Posición aleatoria en el navbar
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            
            // Duración de animación aleatoria
            const duration = Math.random() * 15 + 15;
            particle.style.animationDuration = `${duration}s`;
            
            // Retraso inicial aleatorio
            particle.style.animationDelay = `${Math.random() * 5}s`;
            
            particlesNav.appendChild(particle);
        }
    }

    // Crear efecto de partículas en el overlay
    function createOverlayParticles() {
        // Limpiamos partículas existentes
        particlesOverlay.innerHTML = '';
        
        const particleCount = 25;
        
        for (let i = 0; i < particleCount; i++) {
            const particle = document.createElement('div');
            particle.classList.add('particle-overlay');
            
            // Tamaño aleatorio entre 1px y 3px
            const size = Math.random() * 2 + 1;
            particle.style.width = `${size}px`;
            particle.style.height = `${size}px`;
            
            // Posición aleatoria en el overlay
            particle.style.left = `${Math.random() * 100}%`;
            particle.style.top = `${Math.random() * 100}%`;
            
            // Duración de animación aleatoria
            const duration = Math.random() * 15 + 15;
            particle.style.animationDuration = `${duration}s`;
            
            // Retraso inicial aleatorio
            particle.style.animationDelay = `${Math.random() * 5}s`;
            
            particlesOverlay.appendChild(particle);
        }
    }

    // Inicializar partículas
    document.addEventListener('DOMContentLoaded', function() {
        createNavbarParticles();
    });

    // Ajustar altura del overlay al cambiar tamaño de pantalla
    function adjustOverlayHeight() {
        if (menuOverlay.classList.contains('overlay-active')) {
            document.body.style.overflow = 'hidden';
        }
    }
</script>
</body>
</html>