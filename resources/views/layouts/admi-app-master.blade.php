<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>@yield('title', 'Panel de Administración')</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap Icons -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css" rel="stylesheet" />

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.1.1/css/all.min.css" rel="stylesheet" />

    <!-- CSS personalizado -->
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}" />

    <style>
        /* Reset y estructura base para footer fijo sin afectar navbar */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            font-size: 1rem; /* Tamaño base estándar */
        }

        body {
            display: flex;
            flex-direction: column;
            min-height: 100vh; /* fuerza que el body ocupe toda la altura viewport */
        }

        /* Wrapper para contenido entre navbar y footer */
        .content-wrapper {
            flex: 1 0 auto; /* ocupa el espacio disponible */
            padding: 20px; /* padding estándar para separación */
        }

        /* Footer */
        .footer {
            background-color: #1A365D;
            color: white;
            padding: 20px 0;
            flex-shrink: 0; /* para que no se encoja */
            text-align: center;
        }
    </style>

    @yield('styles')
</head>
<body>

    @include('layouts.partials.admi-navbar')

    <main class="content-wrapper">
        @yield('content')
    </main>

    @include('layouts.partials.footer')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('assets/js/script.js') }}"></script>

    @yield('scripts')
    @stack('scripts')
</body>
</html>
