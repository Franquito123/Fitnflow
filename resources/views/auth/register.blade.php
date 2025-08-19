<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro - Fitnflow</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <style>
        :root {
            --azul-marino: #1A365D;
            --naranja-brillante: #FF6B35;
            --verde-esmeralda: #2EC4B6;
            --blanco: #FFFFFF;
            --gris-claro: #F4F4F4;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, var(--azul-marino) 0%, #0f2a4a 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .login-wrapper {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 100%;
            max-width: 800px;
        }

        .login-form-container {
            background: var(--blanco);
            border-radius: 12px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.3);
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.05);
            width: 100%;
        }

        /* ENCABEZADO ANIMADO */
        .login-header {
            background: linear-gradient(135deg, var(--azul-marino) 0%, #0f2a4a 100%);
            color: var(--blanco);
            padding: 2.5rem 2rem;
            text-align: center;
            position: relative;
            overflow: hidden;
            border-bottom: 4px solid var(--naranja-brillante);
            box-shadow: 0 10px 30px rgba(26, 54, 93, 0.3);
            transform-style: preserve-3d;
            perspective: 1000px;
        }

        .login-header::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--naranja-brillante), var(--verde-esmeralda));
            transform: translateZ(20px);
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
            transform: translateZ(30px);
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
            transition: all 0.4s ease;
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

        /* CUERPO DEL FORMULARIO CON INPUTS ORDENADOS */
        .login-body {
            padding: 2rem;
        }

        .form-horizontal-container {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            justify-content: space-between;
        }

        .form-column {
            flex: 1 1 45%;
            min-width: 280px;
        }

        .input-group {
            margin-bottom: 1.5rem;
        }

        .input-group label {
            display: block;
            color: var(--azul-marino);
            font-size: 0.9rem;
            font-weight: 500;
            margin-bottom: 0.5rem;
        }

        .input-field {
            width: 100%;
            padding: 0.7rem;
            border: 1px solid #E5E7EB;
            border-radius: 8px;
            background-color: var(--gris-claro);
            font-family: 'Poppins', sans-serif;
        }

        .input-field:focus {
            outline: none;
            border-color: var(--verde-esmeralda);
            box-shadow: 0 0 0 2px rgba(46, 196, 182, 0.2);
        }

        .input-field.is-invalid {
            border-color: #dc3545;
        }

        .name-inputs-container {
            display: flex;
            gap: 1rem;
        }

        .submit-container {
            width: 100%;
            display: flex;
            justify-content: center;
            margin-top: 1rem;
        }

        .submit-btn {
            background-color: var(--naranja-brillante);
            color: var(--blanco);
            border: none;
            border-radius: 6px;
            padding: 0.8rem 2rem;
            font-weight: 500;
            font-size: 0.95rem;
            cursor: pointer;
            transition: background-color 0.3s;
            width: auto;
            min-width: 200px;
        }

        .submit-btn:hover {
            background-color: #E55C2B;
        }

        .register-link {
            display: block;
            text-align: center;
            margin-top: 2rem;
            color: var(--naranja-brillante);
            font-weight: 500;
            text-decoration: none;
        }

        .register-link:hover {
            text-decoration: underline;
        }

        .invalid-feedback {
            color: #dc3545;
            font-size: 0.8rem;
            margin-top: 0.25rem;
            display: block;
        }

        @media (max-width: 767px) {
            .form-column {
                flex: 1 1 100%;
            }
            
            .name-inputs-container {
                flex-direction: column;
                gap: 0.75rem;
            }
            
            .login-header {
                padding: 1.5rem 1rem;
            }
            
            .circular-logo {
                width: 100px;
                height: 100px;
            }
            
            .brand-name {
                font-size: 1.5rem;
            }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-form-container">
            <!-- ENCABEZADO ANIMADO -->
            <div class="login-header">
                <div class="particles" id="particles-js"></div>
                
                <div class="logo-container">
                    <img src="{{ asset('images/logo.png') }}" alt="Fitnflow" class="circular-logo">
                    <svg viewBox="0 0 800 100" xmlns="http://www.w3.org/2000/svg" class="svg-logo" style="max-width: 100%; height: auto;">
                        <text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle"
                            font-family="Poppins, sans-serif" font-size="60" fill="none"
                            stroke="#2EC4B6" stroke-width="2">
                            Fitnflow
                            <animate attributeName="stroke-dasharray" from="0, 1000" to="600, 0" dur="3s" repeatCount="indefinite" />
                            <animate attributeName="stroke-dashoffset" from="0" to="-600" dur="3s" repeatCount="indefinite" />
                        </text>
                    </svg>
                    <p class="tagline">Regístrate para empezar tu viaje fitness</p>
                </div>
            </div>

            <!-- CUERPO DEL FORMULARIO -->
            <div class="login-body">
                <form method="POST" action="{{ route('register') }}">
                    @csrf

                    <div class="form-horizontal-container">
                        <!-- Columna izquierda -->
                        <div class="form-column">
                            <!-- 1. Nombre completo -->
                            <div class="input-group">
                                <label>1. Nombre completo</label>
                                <div class="name-inputs-container">
                                    <input id="names" type="text" name="names" placeholder="Nombres" 
                                           value="{{ old('names') }}" required autofocus
                                           class="input-field @error('names') is-invalid @enderror">
                                    <input id="last_name" type="text" name="last_name" placeholder="Apellidos" 
                                           value="{{ old('last_name') }}" required
                                           class="input-field @error('last_name') is-invalid @enderror">
                                </div>
                                @error('names')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                                @error('last_name')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- 2. Email -->
                            <div class="input-group">
                                <label>2. Correo electrónico</label>
                                <input id="email" type="email" name="email" placeholder="ejemplo@correo.com" 
                                       value="{{ old('email') }}" required
                                       class="input-field @error('email') is-invalid @enderror">
                                @error('email')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- 3. Fecha de nacimiento -->
                            <div class="input-group">
                                <label>3. Fecha de nacimiento</label>
                                <input type="text" id="birth_date" name="birth_date" 
                                       placeholder="Haz clic para seleccionar" readonly required
                                       value="{{ old('birth_date') }}"
                                       class="input-field @error('birth_date') is-invalid @enderror">
                                @error('birth_date')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="form-column">
                            <!-- 4. Género -->
                            <div class="input-group">
                                <label>4. Género</label>
                                <select name="gender" required class="input-field @error('gender') is-invalid @enderror">
                                    <option value="" disabled {{ old('gender') ? '' : 'selected' }}>Seleccione...</option>
                                    <option value="Masculino" {{ old('gender') == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                                    <option value="Femenino" {{ old('gender') == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                                </select>
                                @error('gender')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- 5. Contraseña -->
                            <div class="input-group">
                                <label>5. Contraseña</label>
                                <input id="password" type="password" name="password" placeholder="Mínimo 8 caracteres" 
                                       required minlength="8"
                                       class="input-field @error('password') is-invalid @enderror">
                                @error('password')
                                    <span class="invalid-feedback">{{ $message }}</span>
                                @enderror
                            </div>

                            <!-- 6. Confirmar contraseña -->
                            <div class="input-group">
                                <label>6. Confirmar contraseña</label>
                                <input id="password-confirm" type="password" name="password_confirmation" 
                                       placeholder="Repita su contraseña" required
                                       class="input-field">
                            </div>
                        </div>
                    </div>

                    <!-- Botón de submit centrado -->
                    <div class="submit-container">
                        <button type="submit" class="submit-btn">
                            Completar Registro
                        </button>
                    </div>

                    <!-- Enlace login -->
                    <a href="{{ route('login') }}" class="register-link">
                        ¿Ya tienes una cuenta? <strong>Inicia sesión</strong>
                    </a>
                </form>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/es.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Configuración para mayores de 18 años
            flatpickr("#birth_date", {
                dateFormat: "Y-m-d",
                locale: "es",
                disableMobile: true,
                maxDate: new Date(new Date().setFullYear(new Date().getFullYear() - 18)), // Máximo: 18 años atrás desde hoy
                altInput: true,
                altFormat: "d/m/Y",  // Formato visual día/mes/año
                ariaDateFormat: "d/m/Y",
                onChange: function(selectedDates, dateStr, instance) {
                    instance.close();
                }
            });

            // Efecto de partículas
            const particlesContainer = document.getElementById('particles-js');
            if (particlesContainer) {
                const particleCount = 20;
                
                for (let i = 0; i < particleCount; i++) {
                    const particle = document.createElement('div');
                    particle.classList.add('particle');
                    
                    const size = Math.random() * 2 + 1;
                    particle.style.width = `${size}px`;
                    particle.style.height = `${size}px`;
                    
                    particle.style.left = `${Math.random() * 100}%`;
                    particle.style.top = `${Math.random() * 100}%`;
                    
                    const duration = Math.random() * 10 + 10;
                    particle.style.animationDuration = `${duration}s`;
                    
                    particle.style.animationDelay = `${Math.random() * 5}s`;
                    
                    particlesContainer.appendChild(particle);
                }
            }
        });
    </script>
</body>
</html>