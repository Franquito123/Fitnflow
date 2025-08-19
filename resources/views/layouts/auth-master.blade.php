<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Aplicación de Login</title>
        <!-- Flatpickr CSS y JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="stylesheet" href="{{ url('assets/css/bootstrap.min.css') }}">

    <style>
        body{
            width: 100%;
            height: 100vh;

            display: flex;
            align-items: center;
            justify-content: center;
        }

        .form-container {
    max-width: 800px; /* más ancho, para que el formulario pueda usar flex fila */
    width: 90vw; /* ancho flexible en móviles */
}

    </style>
</head>
<body>
    
    <main class="form-container">
        @yield('content')
        
    </main>


<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>

    <script src="{{ url('assets/js/bootstrap.bundle.min.js') }}"></script>
</body>
</html>
