<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Acceso - Fitnflow</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --azul-marino: #1A365D;
            --naranja-brillante: #FF6B35;
            --verde-esmeralda: #2EC4B6;
            --blanco: #FFFFFF;
            --gris-claro: #F4F4F4;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            background-color: var(--gris-claro);
        }

        .login-wrapper {
            display: flex;
            min-height: 100vh;
        }

        .login-form-container {
            flex: 1;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            background-color: var(--blanco);
        }

        .login-image-container {
            flex: 1;
            background-image: url("{{ asset('images/image.png') }}");
            background-size: cover;
            background-position: center;
            display: none;
            position: relative;
        }

        .image-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(26, 54, 93, 0.8) 0%, rgba(46, 196, 182, 0.6) 100%);
        }

        .login-container {
            width: 100%;
            max-width: 450px;
        }

        .login-card {
            background: var(--blanco);
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
        }

        .login-header {
            background: linear-gradient(135deg, var(--azul-marino) 0%, #0f2a4a 100%);
            color: var(--blanco);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom: 4px solid var(--naranja-brillante);
            box-shadow: 0 10px 30px rgba(26, 54, 93, 0.3);
        }

        .login-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--naranja-brillante), var(--verde-esmeralda));
        }

        .login-header::after {
            content: "";
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%) rotate(45deg);
            width: 30px;
            height: 30px;
            background: var(--naranja-brillante);
            z-index: 1;
        }

        .logo-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            margin-bottom: 1rem;
            position: relative;
            z-index: 2;
        }
        
        .circular-logo {
            width: 130px;
            height: 130px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid var(--verde-esmeralda);
            box-shadow: 
                0 0 0 4px var(--azul-marino),
                0 10px 25px rgba(0, 0, 0, 0.3),
                inset 0 0 15px rgba(46, 196, 182, 0.4);
            margin-bottom: 1.5rem;
            background: var(--azul-marino);
            position: relative;
            overflow: hidden;
        }

        .circular-logo::before {
            content: "";
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(
                to bottom right,
                rgba(255, 255, 255, 0.3) 0%,
                rgba(255, 255, 255, 0) 60%
            );
            transform: rotate(30deg);
        }
        
        .brand-name {
            font-size: 1.8rem;
            font-weight: 700;
            color: var(--blanco);
            margin-top: 0.5rem;
            text-shadow: 0 2px 5px rgba(0, 0, 0, 0.3);
            letter-spacing: 1px;
            position: relative;
        }

        .brand-name::after {
            content: "";
            position: absolute;
            bottom: -8px;
            left: 50%;
            transform: translateX(-50%);
            width: 50px;
            height: 3px;
            background: var(--verde-esmeralda);
            border-radius: 3px;
        }

        .tagline {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 0;
            margin-top: 1rem;
            position: relative;
            display: inline-block;
            padding: 0.3rem 0.8rem;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .particles {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: 1;
        }

        .particle {
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

        .login-body {
            padding: 2rem;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
        }

        .invalid-feedback i {
            margin-right: 0.25rem;
        }

        /* Estilo para el contenedor de opciones */
        .options__container {
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Estilo para cada item de opción */
        .option__item {
            position: relative;
        }

        .option__checkbox {
            position: absolute;
            opacity: 0;
        }

        .option__label {
            display: flex;
            align-items: center;
            cursor: pointer;
            position: relative;
            padding-left: 28px;
            color: var(--azul-marino);
            font-size: 0.9rem;
        }

        .option__label:hover {
            color: var(--naranja-brillante);
        }

        .option__icon {
            position: absolute;
            left: 0;
            width: 20px;
            height: 20px;
            border: 2px solid var(--verde-esmeralda);
            background: var(--blanco);
            border-radius: 4px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .option__checkbox:checked + .option__label .option__icon {
            background: var(--verde-esmeralda);
            border-color: var(--azul-marino);
        }

        .option__checkbox:checked + .option__label .option__icon svg path {
            fill: var(--blanco);
        }

        .option__icon svg path {
            fill: transparent;
        }

        .option__checkbox:checked + .option__label .option__text {
            font-weight: 600;
        }

        /* Estilo para el enlace de recuperación */
        .option__link {
            display: flex;
            align-items: center;
            gap: 8px;
            color: var(--naranja-brillante);
            font-size: 0.9rem;
            text-decoration: none;
        }

        .option__link:hover {
            color: var(--azul-marino);
        }

        .option__link .option__icon {
            position: relative;
            left: auto;
            background: var(--naranja-brillante);
            border-color: var(--azul-marino);
        }

        .option__link .option__icon svg path {
            fill: var(--blanco);
        }

        /* Estilo para el contenedor de registro */
        .register__container {
            margin-top: 2rem;
        }

        .register__divider {
            display: flex;
            align-items: center;
            margin-bottom: 1.5rem;
        }

        .register__line {
            flex: 1;
            height: 2px;
            background: linear-gradient(to right, transparent, var(--verde-esmeralda), transparent);
            opacity: 0.5;
        }

        .register__text {
            padding: 0 12px;
            color: var(--azul-marino);
            font-weight: 600;
            text-transform: uppercase;
            font-size: 0.8rem;
        }

        .register__link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            color: var(--azul-marino);
            text-decoration: none;
            padding: 10px 20px;
            border-radius: 8px;
            background: rgba(255, 255, 255, 0.7);
            border: 1px solid rgba(46, 196, 182, 0.3);
        }

        .register__link:hover {
            background: var(--verde-esmeralda);
            color: var(--blanco);
        }

        .register__link strong {
            font-weight: 700;
            color: var(--naranja-brillante);
        }

        .register__link:hover strong {
            color: var(--blanco);
        }

        .register__icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 24px;
            height: 24px;
            background: var(--naranja-brillante);
            border-radius: 50%;
            padding: 3px;
        }

        .register__icon svg path {
            fill: var(--blanco);
        }

        .input-group-icon {
            position: relative;
        }

        .form-control {
            height: 3rem;
            border-radius: 8px;
            border: 1px solid #ddd;
            padding-left: 3rem;
            background-color: var(--gris-claro);
            width: 100%;
        }

        .form-control:focus {
            border-color: var(--verde-esmeralda);
            box-shadow: 0 0 0 0.2rem rgba(46, 196, 182, 0.15);
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--azul-marino);
            z-index: 5;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }

        .btn-login {
        background: var(--naranja-brillante);
        border: none;
        color: var(--blanco);
        height: 3rem;
        border-radius: 8px;
        font-weight: 600;
        width: 100%;
        letter-spacing: 0.5px;
        }

        .btn-login:hover {
        background: var(--naranja-brillante);
        color: var(--blanco);
        transform: none;
        box-shadow: none;
        }

        .password-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--azul-marino);
            cursor: pointer;
            z-index: 5;
            opacity: 0.7;
        }

        .password-toggle:hover {
            opacity: 1;
            color: var(--verde-esmeralda);
        }

        .form-check-input:checked {
            background-color: var(--verde-esmeralda);
            border-color: var(--verde-esmeralda);
        }

        .btn-recovery {
            background: transparent;
            border: none;
            color: var(--naranja-brillante);
            font-weight: 500;
            padding: 0;
            font-size: 0.85rem;
            text-decoration: underline;
        }

        .btn-recovery:hover {
            color: var(--azul-marino);
        }

        .login-footer {
            text-align: center;
            padding: 0 2rem 1.5rem;
        }

        .login-footer a {
            color: var(--verde-esmeralda);
            text-decoration: none;
            font-weight: 500;
        }

        .image-overlay {
            position: absolute;
            bottom: 0;
            left: 0;
            right: 0;
            padding: 2rem;
            background: linear-gradient(transparent, rgba(26, 54, 93, 0.8));
            color: var(--blanco);
        }

        .image-text {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .alert-danger {
            background-color: rgba(220, 53, 69, 0.1);
            border-color: rgba(220, 53, 69, 0.2);
            color: #dc3545;
            border-radius: 8px;
        }

        @media (min-width: 992px) {
            .login-image-container {
                display: block;
            }
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .login-container {
            animation: fadeIn 0.6s ease-out;
        }

        .svg-logo text {
            filter: drop-shadow(0 0 5px #2EC4B6) drop-shadow(0 0 10px #2EC4B6);
            stroke-linecap: round;
            stroke-linejoin: round;
        } 

    </style>
</head>
<body>
   <div class="login-wrapper">
    <!-- Columna del formulario -->
    <div class="login-form-container">
        <div class="login-container">
            <div class="login-card">
                <div class="login-header">
                    <!-- Efecto de partículas -->
                    <div class="particles" id="particles-js"></div>
                    <div class="logo-container">
                        <img src="{{ asset('images/logo.png') }}" alt="Fitnflow" class="circular-logo">
                        <!-- 🔥 Texto SVG animado tipo luz -->
                        <svg viewBox="0 0 800 100" xmlns="http://www.w3.org/2000/svg" class="svg-logo" style="max-width: 100%; height: auto;">
                            <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                                font-family="Poppins, sans-serif" font-size="80" fill="none"
                                stroke="#2EC4B6" stroke-width="2">
                                Fitnflow
                                <animate attributeName="stroke-dasharray" from="0, 1000" to="600, 0" dur="3s" repeatCount="indefinite" />
                                <animate attributeName="stroke-dashoffset" from="0" to="-600" dur="3s" repeatCount="indefinite" />
                            </text>
                        </svg>
                        <p class="tagline" style="font-size: 1rem">Accede a tu cuenta para reservar clases</p>
                    </div>
                </div>

                    
                    <div class="login-body">
                        @if($errors->any())
                            <div class="alert alert-danger mb-4">
                                <i class="bi bi-exclamation-circle me-2"></i>
                                @foreach ($errors->all() as $error)
                                    {{ $error }}
                                @endforeach
                            </div>
                        @endif

                        <form method="POST" action="{{ route('login') }}">
                            @csrf
                            
                           <div class="mb-4">
                                <label for="email" class="form-label">Correo electrónico</label>
                                <div class="input-group-icon">
                                    <i class="bi bi-envelope input-icon"></i>
                                    <input type="email" 
                                           name="email" 
                                           id="email"
                                           class="form-control @error('email') is-invalid @enderror" 
                                           required 
                                           autofocus
                                           placeholder="ejemplo@correo.com">
                                </div>
                                @error('email')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="mb-4">
                                <label for="password" class="form-label">Contraseña</label>
                                <div class="input-group-icon">
                                    <i class="bi bi-lock input-icon"></i>
                                    <input type="password" 
                                           name="password" 
                                           id="password" 
                                           class="form-control @error('password') is-invalid @enderror" 
                                           required>
                                    <button type="button" 
                                            class="password-toggle" 
                                            onclick="togglePassword()">
                                        <i class="bi bi-eye" id="toggleIcon"></i>
                                    </button>
                                </div>
                                @error('password')
                                    <div class="invalid-feedback d-block">
                                        <i class="bi bi-exclamation-circle me-1"></i>{{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="d-flex justify-content-between align-items-center mb-4">
                                <div class="form-check">
                                    <input type="checkbox" 
                                        class="form-check-input" 
                                        name="remember" 
                                        id="remember">
                                    <label class="form-check-label" for="remember">Recordar sesión</label>
                                </div>
                                <button type="button" 
                                        class="btn-recovery" 
                                        onclick="window.location.href='{{ route('password.request') }}'">
                                    ¿Olvidaste tu contraseña?
                                </button>
                            </div>

                            <button type="submit" class="btn btn-login mb-3">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar sesión
                            </button>

                            <div class="register__container">
                                <div class="register__divider">
                                    <span class="register__line"></span>
                                    <span class="register__text">O</span>
                                    <span class="register__line"></span>
                                </div>
                                @if(Route::has('register'))
                                <a href="{{ route('register') }}" class="register__link">
                                    <span class="register__icon">
                                        <svg viewBox="0 0 24 24" width="18" height="18">
                                            <path d="M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z"></path>
                                        </svg>
                                    </span>
                                    <span>¿No tienes una cuenta? <strong>Regístrate</strong></span>
                                </a>
                                @endif
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Columna de la imagen -->
        <div class="login-image-container">
            <div class="image-overlay"></div>
        </div>
    </div>
  <script>
    // Esperar a que el DOM esté completamente cargado
    document.addEventListener('DOMContentLoaded', function() {
        // Seleccionar todas las alertas
        const alerts = document.querySelectorAll('.alert');
        
        // Configurar el tiempo de desaparición (3000ms = 3 segundos)
        const fadeTime = 3000;
        
        // Aplicar a cada alerta
        alerts.forEach(alert => {
            setTimeout(() => {
                // Agregar clase para animación de desvanecimiento
                alert.style.transition = 'opacity 0.5s ease-out';
                alert.style.opacity = '0';
                
                // Eliminar el elemento después de la animación
                setTimeout(() => {
                    alert.remove();
                }, 500); // 0.5s para coincidir con la duración de la transición
            }, fadeTime);
        });
    });
</script>
    <script>
        // Función para mostrar/ocultar contraseña
        function togglePassword() {
            const password = document.getElementById('password');
            const toggleIcon = document.getElementById('toggleIcon');
            
            if (password.type === 'password') {
                password.type = 'text';
                toggleIcon.classList.remove('bi-eye');
                toggleIcon.classList.add('bi-eye-slash');
            } else {
                password.type = 'password';
                toggleIcon.classList.remove('bi-eye-slash');
                toggleIcon.classList.add('bi-eye');
            }
        }

        // Limpiar campos al cargar (opcional)
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('email').value = '';
            document.getElementById('password').value = '';
            
            // Crear efecto de partículas
            const particlesContainer = document.getElementById('particles-js');
            if (particlesContainer) {
                const particleCount = 20;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    // Tamaño aleatorio entre 1px y 3px
                    const size = Math.random() * 2 + 1;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    
                    // Posición inicial aleatoria
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.top = `${Math.random() * 100}%`;
                    
                    // Animación con duración aleatoria
                    const duration = Math.random() * 10 + 10;
                    particle.style.animationDuration = `${duration}s`;
                    
                    // Retraso inicial aleatorio
                    particle.style.animationDelay = `${Math.random() * 5}s`;
                    
                    particlesContainer.appendChild(particle);
                }
            }
        });
    </script>
</body>
</html>