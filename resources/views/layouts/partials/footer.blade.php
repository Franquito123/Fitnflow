<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fit & Flow - Pie de página profesional</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .professional-footer {
            background: linear-gradient(to right, #0f2a4a, #1A365D);
            color: white;
            padding: 40px 0 20px; /* Reducido de 60px 0 30px */
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            border-top-left-radius: 20px;
            border-top-right-radius: 20px;
        }

        .footer-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 0 20px;
        }

        .footer-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(240px, 1fr));
            gap: 20px; /* Reducido de 30px */
            margin-bottom: 25px; /* Reducido de 40px */
        }

        .footer-brand {
            display: flex;
            flex-direction: column;
        }

        .footer-logo {
            font-size: 24px; /* Reducido de 28px */
            font-weight: 700;
            margin-bottom: 15px; /* Reducido de 20px */
            color: white;
            display: flex;
            align-items: center;
        }

        .footer-logo .highlight {
            color: #FF6B35;
        }

        .logo-icon-footer {
            font-size: 28px; /* Reducido de 32px */
            margin-right: 8px; /* Reducido de 10px */
            color: #FF6B35;
        }

        .footer-description {
            color: rgba(255, 255, 255, 0.8);
            line-height: 1.6; /* Reducido de 1.7 */
            margin-bottom: 20px; /* Reducido de 25px */
            max-width: 300px;
            font-size: 0.9em; /* Reducción de tamaño de fuente */
        }

        .footer-contact {
            display: flex;
            flex-direction: column;
            gap: 10px; /* Reducido de 12px */
            margin-bottom: 20px; /* Reducido de 25px */
        }

        .contact-item {
            display: flex;
            align-items: flex-start;
            gap: 10px; /* Reducido de 12px */
            color: rgba(255, 255, 255, 0.9);
            font-size: 0.9em; /* Reducción de tamaño de fuente */
        }

        .contact-icon {
            color: #FF6B35;
            font-size: 16px; /* Reducido de 18px */
            min-width: 20px; /* Reducido de 24px */
            margin-top: 3px;
        }

        .social-links {
            display: flex;
            gap: 12px; /* Reducido de 15px */
            margin-top: 12px; /* Reducido de 15px */
        }

        .social-link {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px; /* Reducido de 40px */
            height: 36px; /* Reducido de 40px */
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            color: white;
            font-size: 16px; /* Reducido de 18px */
            transition: all 0.3s ease;
        }

        .social-link:hover {
            background: #FF6B35;
            transform: translateY(-3px);
        }

        .footer-section h3 {
            font-size: 16px; /* Reducido de 18px */
            margin-bottom: 15px; /* Reducido de 20px */
            padding-bottom: 8px; /* Reducido de 10px */
            border-bottom: 2px solid #FF6B35;
            display: inline-block;
            color: #FF6B35;
        }

        .footer-links {
            list-style: none;
            display: flex;
            flex-direction: column;
            gap: 10px; /* Reducido de 12px */
            padding: 0;
            margin: 0;
        }

        .footer-links li a {
            color: rgba(255, 255, 255, 0.85);
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 6px; /* Reducido de 8px */
            transition: all 0.3s ease;
            font-size: 0.9em; /* Reducción de tamaño de fuente */
        }

        .footer-links li a:hover {
            color: #FF6B35;
            transform: translateX(5px);
        }

        .footer-links li a i {
            font-size: 10px; /* Reducido de 12px */
            color: #FF6B35;
        }

        .schedule-table {
            width: 100%;
            border-collapse: collapse;
        }

        .schedule-table td {
            padding: 6px 0; /* Reducido de 8px 0 */
            color: rgba(255, 255, 255, 0.85);
            border-bottom: 1px solid rgba(255, 255, 255, 0.1);
            font-size: 0.9em; /* Reducción de tamaño de fuente */
        }

        .schedule-table tr:last-child td {
            border-bottom: none;
        }

        .schedule-table tr td:first-child {
            font-weight: 500;
        }

        .schedule-table tr td:last-child {
            text-align: right;
        }

        .footer-bottom {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px; /* Reducido de 20px */
            padding-top: 20px; /* Reducido de 30px */
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        .copyright {
            color: rgba(255, 255, 255, 0.7);
            font-size: 13px; /* Reducido de 15px */
        }

        .legal-links {
            display: flex;
            gap: 15px; /* Reducido de 20px */
        }

        .legal-links a {
            color: rgba(255, 255, 255, 0.7);
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
            font-size: 13px; /* Reducido de 15px */
        }

        .legal-links a:after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #FF6B35;
            transition: all 0.3s ease;
        }

        .legal-links a:hover {
            color: white;
        }

        .legal-links a:hover:after {
            width: 100%;
        }

        .newsletter-form {
            display: flex;
            margin-top: 12px; /* Reducido de 15px */
        }

        .newsletter-input {
            flex: 1;
            padding: 10px 12px; /* Reducido de 12px 15px */
            border: none;
            border-radius: 4px 0 0 4px;
            font-size: 13px; /* Reducido de 14px */
            background: rgba(255, 255, 255, 0.1);
            color: white;
        }

        .newsletter-input::placeholder {
            color: rgba(255, 255, 255, 0.6);
            font-size: 13px; /* Reducido de 14px */
        }

        .newsletter-btn {
            background: #FF6B35;
            color: white;
            border: none;
            padding: 0 18px; /* Reducido de 0 20px */
            border-radius: 0 4px 4px 0;
            cursor: pointer;
            transition: all 0.3s ease;
            font-weight: 600;
            font-size: 13px; /* Reducido de 14px */
        }

        .newsletter-btn:hover {
            background: #FF9D71;
        }

        .newsletter-title {
            margin-top: 20px; /* Reducido de 25px */
        }

        @media (max-width: 768px) {
            .footer-grid {
                grid-template-columns: 1fr;
                gap: 30px; /* Reducido de 40px */
            }
            
            .footer-bottom {
                flex-direction: column;
                text-align: center;
            }
            
            .legal-links {
                justify-content: center;
            }
            
            .footer-logo {
                justify-content: center;
            }
            
            .footer-description {
                max-width: 100%;
                text-align: center;
            }
            
            .social-links {
                justify-content: center;
            }
            
            .schedule-table tr td:last-child {
                text-align: left;
            }
        }
    </style>
</head>
<body>
<footer class="professional-footer">
    <div class="footer-container">
        <div class="footer-grid">
            <div class="footer-brand">
                <div style="max-width: 1300px; margin: 0 auto; display: flex; flex-wrap: wrap; gap: 50px; justify-content: space-between;">

                    {{-- LOGO Y DESCRIPCIÓN --}}
                    <div style="flex: 1 1 280px; min-width: 250px;">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 16px;">
                            <i class="fas fa-dumbbell" style="font-size: 32px; color: #ff6b35;"></i>
                            <span style="font-size: 26px; font-weight: bold;">Fit & <span style="color: #ff6b35;">Flow</span></span>
                        </div>
                        <p style="font-size: 15px; color: #cbd5e1; line-height: 1.7;">
                            Transformamos vidas a través del fitness, ofreciendo instalaciones de primera clase y programas personalizados para alcanzar tus metas.
                        </p>
                        {{-- REDES SOCIALES --}}
                        <div style="margin-top: 20px; display: flex; gap: 16px;">
                            <a href="#" style="color: #cbd5e1; font-size: 18px;"><i class="fab fa-facebook-f"></i></a>
                            <a href="#" style="color: #cbd5e1; font-size: 18px;"><i class="fab fa-instagram"></i></a>
                            <a href="#" style="color: #cbd5e1; font-size: 18px;"><i class="fab fa-twitter"></i></a>
                            <a href="#" style="color: #cbd5e1; font-size: 18px;"><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>

                    {{-- CONTACTO --}}
                    <div style="flex: 1 1 250px; min-width: 220px;">
                        <h3 style="font-size: 18px; margin-bottom: 16px; font-weight: bold;">Contacto</h3>
                        <div style="margin-bottom: 12px; display: flex; align-items: start; gap: 10px;">
                            <i class="fas fa-map-marker-alt" style="color: #ff6b35; margin-top: 3px;"></i>
                            <p style="margin: 0; font-size: 14px; line-height: 1.6;">{{ $centerInfo->address ?? 'No disponible' }}</p>
                        </div>
                        <div style="margin-bottom: 12px; display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-phone-alt" style="color: #ff6b35;"></i>
                            <p style="margin: 0; font-size: 14px;">{{ $centerInfo->phone ?? 'No disponible' }}</p>
                        </div>
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <i class="fas fa-envelope" style="color: #ff6b35;"></i>
                            <p style="margin: 0; font-size: 14px;">{{ $centerInfo->email ?? 'No disponible' }}</p>
                        </div>
                    </div>

                    {{-- SERVICIOS EN COLUMNAS --}}
                    <div style="flex: 1 1 300px; min-width: 260px;">
                        <h3 style="font-size: 18px; margin-bottom: 16px; font-weight: bold;">Servicios</h3>
                        @php
                            $columns = $services->take(12)->chunk(6); // 2 columnas de 6
                        @endphp
                        <div style="display: flex; gap: 30px;">
                            @foreach($columns as $column)
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    @foreach($column as $service)
                                        <li style="margin-bottom: 10px;">
                                            <a href="#service-{{ $service->id }}" style="text-decoration: none; color: #cbd5e1; font-size: 14px;">
                                                <i class="fas fa-chevron-right" style="margin-right: 6px; color: #ff6b35;"></i>
                                                {{ $service->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    </div>

                    {{-- HORARIO DE ATENCIÓN --}}
                    <div style="flex: 1 1 320px; min-width: 260px;">
                        <h3 style="font-size: 18px; margin-bottom: 16px; font-weight: bold;">
                            <i class="fas fa-clock" style="margin-right: 8px; color: #ff6b35;"></i>
                            Horario de Atención
                        </h3>
                        @if (!empty($centerInfo))
                            <div style="background-color: #143a66; border-radius: 8px; padding: 20px; color: #e2e8f0; font-size: 14px;">
                                @if (!empty($centerInfo->opening_time) || !empty($centerInfo->closing_time))
                                    <div style="margin-bottom: 16px;">
                                        @if ($centerInfo->opening_time)
                                            <p style="margin: 4px 0;">
                                                <strong>Apertura:</strong>
                                                {{ \Carbon\Carbon::parse($centerInfo->opening_time)->format('h:i A') }}
                                            </p>
                                        @endif
                                        @if ($centerInfo->closing_time)
                                            <p style="margin: 4px 0;">
                                                <strong>Cierre:</strong>
                                                {{ \Carbon\Carbon::parse($centerInfo->closing_time)->format('h:i A') }}
                                            </p>
                                        @endif
                                    </div>
                                @else
                                    <p style="color: #94a3b8;">Horario no disponible.</p>
                                @endif

                                @if (!empty($centerInfo->days))
                                    <h5 style="margin-bottom: 8px; font-weight: bold;">Días laborales</h5>
                                    <p style="margin: 0;">{{ $centerInfo->days }}</p>
                                @endif
                            </div>
                        @else
                            <p style="color: #94a3b8; font-size: 14px;">Información del centro no disponible.</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        {{-- COPYRIGHT --}}
        <div style="border-top: 1px solid #1e2f43; margin-top: 40px; padding-top: 20px; text-align: center; color: #94a3b8; font-size: 13px;">
            © 2025 Fit & Flow. Todos los derechos reservados.
        </div>
    </div>
</footer>

<style>
    @media (max-width: 768px) {
        .footer-grid > div > div {
            flex-direction: column !important;
            gap: 40px !important;
        }
    }
</style>

</body>
</html>