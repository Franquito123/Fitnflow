<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Bienvenido')</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">

    <style>
        :root {
            --navbar-height: 70px;
            --footer-height: 60px;
        }

        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* Garantiza que el body ocupe al menos toda la altura visible */
            position: relative;
        }

        /* Navbar fijo en la parte superior */
        .navbar {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 1000;
            height: var(--navbar-height);
        }

        /* Contenedor principal ajustado */
        .main-wrapper {
            flex: 1 0 auto; /* Permite que crezca pero no que se encoja */
            width: 100%;
            padding-top: calc(var(--navbar-height) + 20px); /* Espacio para el navbar */
            padding-bottom: 10px; /* Espacio antes del footer */
            min-height: calc(90vh - var(--navbar-height) - var(--footer-height)); /* Altura total menos navbar y footer */
        }

        /* Footer siempre abajo */
        .footer {
            flex-shrink: 0; /* Evita que el footer se encoja */
            height: var(--footer-height);
            width: 100%;
        }

        /* Ajustes para móviles */
        @media (max-width: 768px) {
            :root {
                --navbar-height: 10px;
                --footer-height: auto; /* Altura flexible en móviles */
            }
            
            .main-wrapper {
                padding-top: calc(var(--navbar-height) + 15px);
                min-height: calc(80vh - var(--navbar-height) - 100px); /* Aproximación para footer móvil */
            }
            
            .footer {
                padding: 20px 0;
            }
        }

        /* Para dispositivos muy pequeños */
        @media (max-width: 480px) {
            :root {
                --navbar-height: 56px;
            }
            
            .main-wrapper {
                padding-top: calc(var(--navbar-height) + 10px);
            }
        }
    </style>

    @yield('styles')
</head>
<body>
    <!-- Navbar fijo -->
    @include('layouts.partials.instructor-navbar')

    <!-- Contenido principal -->
    <div class="main-wrapper">
        @yield('content')
    </div>

    <!-- Footer -->
    @include('layouts.partials.footer')

    @yield('scripts')
</body>
</html>