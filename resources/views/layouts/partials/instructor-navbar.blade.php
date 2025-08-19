<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú Interactivo FITNFLOW</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            overflow: hidden; /* Para contener partículas */
        }

        /* Contenedor de partículas para el navbar */
        .particles-nav {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1; /* Detrás del contenido */
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
            z-index: 2; /* Encima de las partículas */
        }

        /* Logo con efecto neón animado */
        .logo {
            width: 90px;
            height: 90px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            color: var(--verde-esmeralda);
            font-weight: bold;
            font-size: 1.8rem;
            background: var(--azul-marino);
            position: relative;
            overflow: hidden;
            box-shadow: 
                0 0 10px var(--neon-glow),
                0 0 20px var(--neon-glow),
                0 0 30px var(--neon-glow),
                inset 0 0 10px rgba(46, 196, 182, 0.5);
            animation: neon-glow 1.5s ease-in-out infinite alternate;
            border: 3px solid var(--verde-esmeralda);
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
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
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
            display: flex;
            align-items: center;
            gap: 8px;
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
            gap: 1.5rem !important;       /* Espacio entre botones */
            margin: 1.5rem 0 0 0 !important;
            padding: 0 !important;
            justify-content: center !important;
        }

        /* ESTILOS BASE PARA AMBOS BOTONES (SIMPLIFICADO) */
        .swal2-confirm.logout-confirm,
        .swal2-cancel.logout-cancel {
            font-size: 1.3rem !important;       /* Texto más pequeño */
            padding: 0.9rem 0.9rem !important;   /* Tamaño compacto */
            border-radius: 5px !important;
            margin: 0 5px !important;            /* Espacio horizontal entre botones */
            min-width: 100px !important;           /* Ancho mínimo reducido */
            transition: all 0.3s ease !important;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1) !important;
            border: none !important;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            flex: none !important;               /* Evita que se estiren */
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
        @media (max-width: 992px) {
            .main-header {
                padding: 0 15px;
            }
            
            .brand-name {
                font-size: 2rem;
                margin-left: 15px;
            }
            
            .logout-button {
                padding: 10px 16px;
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
            
            .logo {
                width: 70px;
                height: 70px;
            }
            
            .svg-brand {
                height: 50px;
                min-width: 180px;
            }
        }

        @media (max-width: 576px) {
            .main-header {
                height: 85px;
                padding: 0 10px;
            }
            
            .logo {
                width: 60px;
                height: 60px;
                font-size: 1.5rem;
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
        }

        @media (max-width: 360px) {
            .svg-brand {
                display: none;
            }
            
            .logo {
                margin-left: 0;
            }
            
            .logout-button {
                padding: 6px 9px;
                font-size: 1rem;
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
            <form method="POST" action="{{ route('logout') }}" id="logout-form">
                @csrf
                <button type="button" class="logout-button" id="logoutButton">
                    <i class="fas fa-sign-out-alt"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </header>
    
    <script>
        // Crear efecto de partículas en el navbar
        function createNavbarParticles() {
            const particlesNav = document.getElementById('particlesNav');
            const particleCount = 12; // Cantidad reducida para navbar
            
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
                    document.getElementById('logout-form').submit();
                }
            });
        }

        // Inicializar partículas y eventos
        document.addEventListener('DOMContentLoaded', function() {
            createNavbarParticles();
            
            // Animación adicional para el logo
            const logo = document.querySelector('.logo');
            logo.style.animation = 'neon-glow 1.5s ease-in-out infinite alternate';
            
            // Animación adicional para el texto SVG
            const svgText = document.querySelector('.svg-brand text');
            svgText.style.animation = 'text-glow 1.5s ease-in-out infinite alternate';
            
            // Event listener para el botón de logout
            document.getElementById('logoutButton').addEventListener('click', function(e) {
                e.preventDefault();
                showLogoutConfirmation();
            });
        });
    </script>
</body>
</html>