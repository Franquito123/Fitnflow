@extends('layouts.app-master')

@section('content')

@php
    $style = $settings->style ?? 'ring';
    $duration = $settings->duration ?? 20;
    $radius = $settings->radius ?? 300;
    $brightness = $settings->brightness_animation ?? false;
@endphp

<svg class="svg-filters">
    <defs>
        <filter id="glow" x="-20%" y="-20%" width="140%" height="140%">
            <feGaussianBlur stdDeviation="5" result="blur" />
            <feComposite in="SourceGraphic" in2="blur" operator="over" />
        </filter>
    </defs>
</svg>

<div id="imageModal" class="modal">
    <span class="close">&times;</span>
    <img class="modal-content" id="modalImage">
</div>

<div class="header-spacer"></div>

@if(isset($slides) && $slides->count())
    @php
        $count = $slides->count();
        $angle = 360 / $count;
        $dynamicRadius = $count > 8 ? $radius + 50 : $radius;
    @endphp

    <div class="carousel-section">
        <div class="carousel-container-3d">
            <div class="card-3d">
                @foreach($slides as $index => $slide)
                    @php
                        $rotation = $angle * $index;
                        $transform = match($style) {
                            'ring' => "rotateY({$rotation}deg) translateZ({$dynamicRadius}px)",
                            'flat' => "translateX(" . ($index * 240) . "px)",
                            default => ''
                        };
                        $zIndex = $style === 'stacked' ? $count - $index : 1;
                    @endphp
                    <div class="slide-card {{ $style }}"
                         style="
                            transform: {{ $style !== 'stacked' ? 'translate(-50%, -50%) ' . $transform : '' }};
                            z-index: {{ $zIndex }};
                         "
                         onclick="openModal('{{ asset('storage/' . $slide->image_path) }}')">
                        <img src="{{ asset('storage/' . $slide->image_path) }}" alt="Slide Image">
                        @if($slide->description)
                            <div class="slide-description">{{ $slide->description }}</div>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if($style === 'stacked')
        <script>
            document.addEventListener("DOMContentLoaded", function () {
                const cards = Array.from(document.querySelectorAll('.slide-card'));
                let currentIndex = 0;

                function updateStacked() {
                    cards.forEach((card, index) => {
                        card.classList.remove('stacked-current', 'stacked-left', 'stacked-right', 'stacked-hidden');
                        const offset = (index - currentIndex + cards.length) % cards.length;
                        if (offset === 0) {
                            card.classList.add('stacked-current');
                        } else if (offset === 1) {
                            card.classList.add('stacked-right');
                        } else if (offset === cards.length - 1) {
                            card.classList.add('stacked-left');
                        } else {
                            card.classList.add('stacked-hidden');
                        }
                    });
                }

                updateStacked();
                setInterval(() => {
                    currentIndex = (currentIndex + 1) % cards.length;
                    updateStacked();
                }, {{ $duration * 1000 }});
            });
        </script>
    @endif
@endif

<div class="container">
    <div class="content-wrapper">
        <!-- MAPA - A LA IZQUIERDA -->
        <div class="map-section">
            <div class="map-header">
                <h1 style="font-size: 3rem;">Nuestra ubicación</h1>
                <h2 style="font-size: 2.2rem;">
                    Encuéntranos fácilmente en
                    <strong style="font-size: 2.3rem;">
                        {{ $centerInfo->address ?? 'nuestra ubicación' }}
                    </strong>
                </h2>
            </div>
            <div class="map-container">
                @if($centerInfo && $centerInfo->map_embed)
                    <div class="map-embed-wrapper">
                        {!! $centerInfo->map_embed !!}
                    </div>
                @else
                    <iframe
                        class="map-iframe"
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3820.346830757997!2d-93.17619122508016!3d16.759411484024596!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x85ecd9ec7cc2372d%3A0xaa879f1e51acb17a!2sPlaza%20la%20gloria!5e0!3m2!1ses!2smx!4v1749506336739!5m2!1ses!2smx"
                        allowfullscreen
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                @endif
            </div>
            <center>
                <button id="getDirectionsBtn" class="directions-button" style="font-size: 1.8rem; padding: 15px 30px;">
                    Cómo llegar desde tu ubicación
                </button>
            </center>
        </div>

        <!-- SECCIÓN DERECHA CON HORARIOS SOLO Y CONTACTO + SERVICIOS ACOMPAÑADOS -->
        <div class="right-section">
            <!-- HORARIOS SOLO -->
            <div class="info-card solo-card">
                <center><h1 style="font-size: 2.5rem;">Horarios</h1></center>
                @if($centerInfo)
                    <h3 style="font-size: 2rem;">Días laborales: {{ $centerInfo->days ?? 'No especificado' }}</h3>
                    <h3 style="font-size: 2rem;">
                        Apertura: {{ $centerInfo->opening_time ? \Carbon\Carbon::parse($centerInfo->opening_time)->format('h:i A') : 'No especificado' }}
                    </h3>
                    <h3 style="font-size: 2rem;">
                        Cierre: {{ $centerInfo->closing_time ? \Carbon\Carbon::parse($centerInfo->closing_time)->format('h:i A') : 'No especificado' }}
                    </h3>
                    @if($centerInfo->schedule)
                        <div class="mt-2">
                            <strong style="font-size: 2rem;">Observaciones:</strong>
                            <ul class="ps-3" style="font-size: 1.8rem;">
                                @foreach(explode("\n", $centerInfo->schedule) as $line)
                                    @if(trim($line) !== '')
                                        <li>{{ $line }}</li>
                                    @endif
                                @endforeach
                            </ul>
                        </div>
                    @endif
                @else
                    <p style="font-size: 2rem;">No hay información disponible del centro.</p>
                @endif
            </div>

            <!-- CONTACTO Y SERVICIOS ACOMPAÑADOS -->
            <div class="paired-cards">
                <!-- CONTACTO -->
                <div class="info-card">
                    @if($centerInfo)
                        @php
                            $numeroWhatsapp = preg_replace('/\D/', '', $centerInfo->phone);
                            $mensajeWhatsapp = urlencode('Hola, me gustaría recibir más información sobre los servicios.');
                        @endphp

                        <center><h1 style="font-size: 2.5rem;">Contacto</h1></center>

                        <div class="contact-section" style="margin-bottom: 25px;">
                            <h4 style="font-size: 2.1rem;">📞 Teléfono</h4>
                            <a href="tel:+52{{ $numeroWhatsapp }}" style="font-size: 1.8rem;">
                                📱 Llamar: {{ $centerInfo->phone }}
                            </a><br>
                            <a href="https://wa.me/52{{ $numeroWhatsapp }}?text={{ $mensajeWhatsapp }}" target="_blank" style="font-size: 1.8rem; color: #25D366;">
                                💬 WhatsApp
                            </a>
                        </div>

                        <div class="contact-section" style="margin-bottom: 25px;">
    <h4 style="font-size: 2.1rem;">✉ Email</h4>
    <a href="mailto:{{ $centerInfo->email }}" style="font-size: 1.8rem; word-break: break-all;">
        📩 {{ $centerInfo->email }}
    </a><br>
    <a href="https://mail.google.com/mail/?view=cm&to={{ $centerInfo->email }}&su=Consulta%20desde%20el%20sitio&body=Hola,%20me%20gustaría%20recibir%20más%20información." target="_blank" style="font-size: 1.8rem; color: #d93025;">
        📧 Abrir en Gmail
    </a>
</div>

                        <div class="contact-section">
                            <h4 style="font-size: 2.1rem;">📍 Dirección</h4>
                            <div style="font-size: 1.8rem;">
                                {{ $centerInfo->address }}
                            </div>
                        </div>
                    @endif
                </div>

                <!-- NUESTROS SERVICIOS -->
                <div class="info-card">
                    @if(isset($services) && $services->count() > 0)
                        <h3 style="font-size: 2.2rem;">Nuestros Servicios</h3>
                        <div class="three-column-services">
                            @php
                                $chunks = $services->take(12)->chunk(4);
                            @endphp
                            @foreach($chunks as $column)
                                <ul style="font-size: 2rem;">
                                    @foreach($column as $service)
                                        <li>
                                            <a href="#service-{{ $service->id }}" style="font-size: 1.9rem;">
                                                {{ $service->name }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    @if(isset($services) && $services->count() > 0)
        <div class="activities-section">
            @foreach($services as $index => $service)
                <div class="activity" id="service-{{ $service->id }}">
                    <div class="activity-content {{ $index % 2 == 0 ? 'left' : 'right' }}">
                        @if($service->image_url)
                            <img src="{{ asset('storage/' . str_replace('public/', '', $service->image_url)) }}" alt="{{ $service->name }}" onclick="openModal('{{ asset('storage/' . str_replace('public/', '', $service->image_url)) }}')">
                        @endif
                        <div class="description" style="padding: 25px;">
    <h3 style="font-size: 2.8rem;">{{ $service->name }}</h3>
    <p style="font-size: 2rem; word-wrap: break-word; overflow-wrap: break-word; white-space: pre-wrap;">{{ $service->description }}</p>
</div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-center text-gray-500 mt-8" style="font-size: 2.2rem; padding: 20px;">No hay servicios para mostrar.</p>
    @endif
</div>

<style>
    /* Filtro SVG para el efecto de resplandor */
    svg.svg-filters {
        position: absolute;
        width: 0;
        height: 0;
        overflow: hidden;
    }

    /* Paleta de colores profesional */
    :root {
        --azul-marino: #1A365D;
        --naranja-brillante: #FF6B35;
        --verde-esmeralda: #2EC4B6;
        --blanco: #FFFFFF;
        --azul-oscuro: #0f2a4a;
        --neon-glow: #2EC4B6;
        --sombra-azul: rgba(26, 54, 93, 0.2);
        --sombra-naranja: rgba(255, 107, 53, 0.2);
        --degradado-hero: linear-gradient(135deg, var(--azul-marino) 0%, var(--azul-oscuro) 100%);
        --degradado-botones: linear-gradient(to right, var(--naranja-brillante) 0%, var(--verde-esmeralda) 100%);
    }

    /* Estilos generales */
    body {
        min-height: 100vh;
        margin: 0;
        padding: 0;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8fafc;
        color: #333;
        line-height: 1.6;
    }

    /* Header spacer con degradado profesional */
    .header-spacer {
        height: 80px;
        background: var(--degradado-hero);
        box-shadow: 0 4px 12px var(--sombra-azul);
    }

    /* Contenedor principal */
    .container {
        max-width: 1300px;
        margin: 0 auto;
        padding: 15px;
    }

    /* Estilos del carrusel */
    .carousel-section {
        padding: 60px 0 20px;
        margin-bottom: 0;
        background: linear-gradient(
            45deg,
            var(--verde-esmeralda),
            var(--naranja-brillante),
            var(--azul-marino),
            var(--verde-esmeralda)
        );
        background-size: 300% 300%;
        animation: borderGlow 8s linear infinite;
        margin-bottom: 2px;
        overflow: hidden;
    }

    .carousel-container-3d {
        position: relative;
        perspective: 1200px;
        margin: 0 auto;
        height: 500px;
        display: flex;
        justify-content: center;
        align-items: center;
        border-radius: 0;
        z-index: 1;
        filter: url('#glow');
        max-width: 1300px;
        padding: 0 20px;
    }

    .card-3d {
        width: 100%;
        height: 100%;
        position: relative;
        transform-style: preserve-3d;
        @if($style === 'ring')
            animation: autoRotate {{ $duration }}s linear infinite;
        @elseif($style === 'flat')
            animation: slideFlat {{ $duration }}s linear infinite;
        @endif
    }

    /* Tarjetas del carrusel */
    .slide-card {
        position: absolute;
        top: 50%;
        left: 50%;
        width: 240px;
        height: 260px;
        transform-origin: center center;
        border-radius: 12px;
        overflow: hidden;
        background-color: var(--blanco);
        border: 2px solid var(--verde-esmeralda);
        box-shadow: 0 5px 20px rgba(0,0,0,0.25);
        display: flex;
        flex-direction: column;
        justify-content: flex-start;
        transition: transform 0.4s ease, box-shadow 0.4s ease;
        opacity: 1;
        cursor: pointer;
    }

    .slide-card:hover {
        transform: scale(1.05);
        box-shadow: 0 12px 25px rgba(0,0,0,0.3);
    }

    .slide-card img {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background-color: #fff;
        padding: 0;
        max-width: 100%;
        display: block;
        @if($brightness)
            animation: pulseBrightness 4s ease-in-out infinite;
        @endif
    }

    /* Descripción de la tarjeta */
    .slide-description {
        background: var(--naranja-brillante);
        color: var(--blanco);
        text-align: left;
        font-size: 1rem;
        padding: 12px 10px;
        height: 80px;
        display: flex;
        align-items: center;
        justify-content: flex-start;
        font-weight: 600;
        line-height: 1.4;
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }

    /* Animaciones */
    @keyframes autoRotate {
        from { transform: rotateY(0deg); }
        to { transform: rotateY(360deg); }
    }

    @keyframes slideFlat {
        0% { transform: translateX(0); }
        50% { transform: translateX(-50%); }
        100% { transform: translateX(0); }
    }

    @keyframes pulseBrightness {
        0%, 100% { filter: brightness(1); }
        50% { filter: brightness(1.4); }
    }

    @keyframes borderGlow {
        0% { background-position: 0% 50%; }
        100% { background-position: 300% 50%; }
    }

    /* Estilos apilados */
    .slide-card.stacked-current {
        transform: translate(-50%, -50%) scale(1);
        z-index: 5;
        opacity: 1;
    }
    .slide-card.stacked-left {
        transform: translate(-150%, -50%) scale(0.85);
        z-index: 3;
        opacity: 0.8;
    }
    .slide-card.stacked-right {
        transform: translate(50%, -50%) scale(0.85);
        z-index: 2;
        opacity: 0.8;
    }
    .slide-card.stacked-hidden {
        opacity: 0;
        transform: translate(-50%, -50%) scale(0.7);
        z-index: 0;
    }

    /* Estilos para el layout principal */
    .content-wrapper {
        display: flex;
        gap: 30px;
        margin-top: 40px;
    }

    /* Sección del mapa - Diseño mejorado */
    .map-section {
        flex: 1;
        min-width: 45%;
    }

    .map-header {
        margin-bottom: 30px;
        text-align: center;
    }

    .map-header h2 {
        color: var(--azul-marino);
        font-size: 2rem;
        margin-bottom: 10px;
        position: relative;
        display: inline-block;
    }

    .map-header h2::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 50%;
        transform: translateX(-50%);
        width: 80px;
        height: 3px;
        background: var(--naranja-brillante);
    }

    /* Contenedor principal del mapa */
    .map-container {
        width: 100%;
        height: 65vh;
        min-height: 400px;
        max-height: 600px;
        position: relative;
        overflow: hidden;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        margin: 20px 0;
        border: 1px solid rgba(0,0,0,0.1);
    }

    /* Iframe del mapa */
    .map-iframe {
        width: 100%;
        height: 100%;
        border: none;
        filter: grayscale(20%) contrast(110%);
    }

    /* Contenedor para mapas embed personalizados */
    .map-embed-wrapper {
        width: 100%;
        height: 100%;
        overflow: hidden;
    }

    .map-embed-wrapper iframe {
        width: 100%;
        height: 100%;
        border: none;
    }

    /* Botón de direcciones con efecto hover */
    .directions-button {
        display: inline-block;
        background: var(--degradado-botones);
        color: white;
        padding: 14px 28px;
        font-size: 1.1rem;
        font-weight: 600;
        border-radius: 10px;
        cursor: pointer;
        border: none;
        transition: all 0.3s ease;
        box-shadow: 0 5px 15px var(--sombra-naranja);
        text-transform: uppercase;
        letter-spacing: 1px;
        position: relative;
        overflow: hidden;
        margin-top: 20px;
    }

    .directions-button:hover {
        transform: translateY(-3px);
        box-shadow: 0 8px 20px var(--sombra-naranja);
    }

    /* Sección derecha con horarios y contacto + servicios */
    .right-section {
        flex: 1;
        min-width: 50%;
        display: flex;
        flex-direction: column;
        gap: 20px;
    }

    .solo-card {
        width: 100%;
        background-color: white;
        padding: 25px;
        border-radius: 10px;
        border-left: 5px solid var(--naranja-brillante);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .solo-card:hover {
        transform: translateY(-5px);
    }

    .paired-cards {
        display: flex;
        gap: 20px;
    }

    .paired-cards .info-card {
        flex: 1;
        min-width: 0;
        background-color: white;
        padding: 25px;
        border-radius: 10px;
        border-left: 5px solid var(--naranja-brillante);
        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        transition: transform 0.3s ease;
    }

    .paired-cards .info-card:hover {
        transform: translateY(-5px);
    }

    /* Estilos comunes para tarjetas de información */
    .info-card h3 {
        margin-top: 0;
        color: var(--azul-marino);
        font-size: 1.8rem;
        margin-bottom: 15px;
        position: relative;
        padding-bottom: 8px;
    }

    .info-card h3::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        width: 50px;
        height: 2px;
        background: var(--naranja-brillante);
    }

    .info-card h4 {
        margin: 12px 0 5px 0;
        color: var(--azul-oscuro);
        font-size: 1.3rem;
    }

    .info-card p, .info-card a {
        color: #555;
        font-size: 1.1rem;
        line-height: 1.6;
    }

    .info-card a {
        text-decoration: none;
        display: block;
        padding: 8px 0;
        transition: color 0.3s ease;
    }

    .info-card a:hover {
        color: var(--naranja-brillante);
    }

    /* Servicios en tres columnas - Versión mejorada */
    .three-column-services {
        display: flex;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 20px;
    }

    .three-column-services ul {
        flex: 1;
        min-width: 160px;
        list-style-type: none;
        padding: 0;
        margin: 0;
    }

    .three-column-services li {
        margin-bottom: 15px;
        position: relative;
        padding-left: 25px;
        line-height: 1.5;
    }

    .three-column-services li::before {
        content: '•';
        color: var(--verde-esmeralda);
        font-size: 1.8rem;
        position: absolute;
        left: 0;
        top: -7px;
    }

    .three-column-services a {
        color: var(--azul-oscuro);
        text-decoration: none;
        transition: all 0.3s ease;
        display: block;
        padding: 6px 0;
        font-size: 1.1rem;
        font-weight: 500;
    }

    .three-column-services a:hover {
        color: var(--naranja-brillante);
        transform: translateX(8px);
    }

    /* Sección de actividades/servicios con imágenes */
    .activities-section {
        margin-top: 70px;
    }

    .activity {
        margin-bottom: 40px;
    }

    .activity-content {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 40px;
        flex-wrap: wrap;
    }

    .activity-content.left {
        flex-direction: row;
    }

    .activity-content.right {
        flex-direction: row-reverse;
    }

    .activity img {
        width: 50%;
        max-width: 500px;
        height: auto;
        max-height: 350px;
        object-fit: contain;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        margin: 0 auto;
        display: block;
        cursor: pointer;
    }

    .activity img:hover {
        transform: scale(1.02);
        box-shadow: 0 15px 40px rgba(0, 0, 0, 0.2);
    }

    .description {
        width: 45%;
        background-color: white;
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        border-left: 5px solid var(--naranja-brillante);
        transition: transform 0.5s ease;
    }

    .description:hover {
        transform: translateY(-10px);
    }

    .description h3 {
        color: var(--azul-marino);
        font-size: 2.2rem;
        margin-bottom: 20px;
        position: relative;
    }

    .description h3::after {
        content: '';
        position: absolute;
        bottom: -10px;
        left: 0;
        width: 60px;
        height: 3px;
        background: var(--verde-esmeralda);
    }

    .description p {
        font-size: 1.2rem;
        color: #555;
        line-height: 1.8;
        margin-top: 20px;
    }

    /* Modal para imágenes */
    .modal {
        display: none;
        position: fixed;
        z-index: 1000;
        left: 0;
        top: 0;
        width: 100%;
        height: 100%;
        background-color: rgba(0,0,0,0.9);
        overflow: auto;
    }

    .modal-content {
        margin: auto;
        display: block;
        width: 80%;
        max-width: 800px;
        max-height: 80vh;
        object-fit: contain;
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
    }

    .close {
        position: absolute;
        top: 20px;
        right: 35px;
        color: #f1f1f1;
        font-size: 40px;
        font-weight: bold;
        transition: 0.3s;
        cursor: pointer;
    }

    .close:hover {
        color: var(--naranja-brillante);
    }
    

    /* Media queries para responsividad */
    @media (max-width: 1200px) {
        .carousel-container-3d {
            height: 450px;
            max-width: 1100px;
        }
        
        .slide-card {
            width: 200px;
            height: 240px;
        }
        
        .slide-card img {
            height: 160px;
        }
        
        .slide-description {
            font-size: 0.9rem;
            height: 80px;
            -webkit-line-clamp: 3;
        }

        .map-container {
            height: 450px;
        }

        .activity img {
            max-width: 450px;
            max-height: 320px;
        }
    }

    @media (max-width: 992px) {
        .carousel-container-3d {
            height: 400px;
            max-width: 900px;
        }
        
        .slide-card {
            width: 180px;
            height: 220px;
        }
        
        .slide-card img {
            height: 140px;
        }
        
        .slide-description {
            font-size: 0.85rem;
            height: 80px;
            -webkit-line-clamp: 3;
        }

        .content-wrapper {
            flex-direction: column;
        }

        .map-section, .right-section {
            width: 100%;
            min-width: 100%;
        }

        .paired-cards {
            flex-direction: column;
        }

        .map-container {
            height: 400px;
        }

        .activity img {
            max-width: 400px;
            max-height: 280px;
        }

        .description {
            padding: 25px;
        }

        .description h3 {
            font-size: 2rem;
        }
    }

    @media (max-width: 768px) {
        .carousel-container-3d {
            height: 350px;
            max-width: 700px;
        }
        
        .slide-card {
            width: 160px;
            height: 200px;
        }
        
        .slide-card img {
            height: 120px;
        }
        
        .slide-description {
            font-size: 0.8rem;
            height: 80px;
            -webkit-line-clamp: 3;
            padding: 8px;
        }

        .header-spacer {
            height: 60px;
        }

        .map-container {
            height: 350px;
        }

        .activity-content.left,
        .activity-content.right {
            flex-direction: column !important;
            align-items: center;
        }

        .activity img,
        .description {
            width: 100%;
            max-width: 100%;
        }

        .description {
            padding: 20px;
        }

        .description h3 {
            font-size: 1.8rem;
        }

        .description p {
            font-size: 1.1rem;
        }

        .three-column-services {
            flex-direction: column;
        }

        .map-header h2 {
            font-size: 1.6rem;
        }

        .directions-button {
            width: 100%;
            font-size: 1rem;
            padding: 12px;
        }

        .info-card h3 {
            font-size: 1.6rem;
        }

        .info-card p,
        .info-card a {
            font-size: 1rem;
        }
    }

    @media (max-width: 576px) {
        .carousel-container-3d {
            height: 300px;
            max-width: 500px;
        }
        
        .slide-card {
            width: 140px;
            height: 180px;
        }
        
        .slide-card img {
            height: 100px;
        }
        
        .slide-description {
            font-size: 0.7rem;
            height: 80px;
            -webkit-line-clamp: 3;
            padding: 6px;
        }

        .container {
            padding: 20px;
        }

        .map-container {
            height: 300px;
        }

        .description {
            padding: 16px;
        }

        .description h3 {
            font-size: 1.6rem;
        }

        .description p {
            font-size: 1rem;
        }

        .activity img {
            max-height: 250px;
        }

        .map-header h2 {
            font-size: 1.4rem;
        }

        .directions-button {
            padding: 10px;
            font-size: 0.9rem;
        }

        .info-card h3 {
            font-size: 1.4rem;
        }
    }

    @media (max-width: 480px) {
        .carousel-container-3d {
            height: 280px;
            max-width: 400px;
        }
        
        .slide-card {
            width: 120px;
            height: 160px;
        }
        
        .slide-card img {
            height: 80px;
        }
        
        .slide-description {
            font-size: 0.65rem;
            height: 80px;
            -webkit-line-clamp: 3;
            padding: 4px;
        }

        .map-container {
            height: 250px;
        }

        .description h3 {
            font-size: 1.4rem;
        }

        .description p {
            font-size: 0.9rem;
        }

        .info-card {
            padding: 15px;
        }
    }
</style>

<script>
    // DIRECCIONES
    document.getElementById('getDirectionsBtn').addEventListener('click', function () {
        if (navigator.geolocation) {
        navigator.geolocation.getCurrentPosition(
            function (position) {
                const lat = position.coords.latitude;
                const lng = position.coords.longitude;
                const destination = encodeURIComponent(`{{ $centerInfo && $centerInfo->address ? $centerInfo->address : 'Plaza La Gloria, Tuxtla Gutiérrez, Chiapas' }}`);
                const mapsUrl = `https://www.google.com/maps/dir/?api=1&origin=${lat},${lng}&destination=${destination}&travelmode=driving`;
                window.open(mapsUrl, '_blank');
            },
            function () {
                alert('No se pudo obtener tu ubicación. Activa la geolocalización en tu navegador.');
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    } else {
        alert('Tu navegador no soporta geolocalización.');
    }
});

    // SCROLL SUAVE
    document.querySelectorAll('a[href^="#service-"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth'
                });
            }
        });
    });

    // MODAL PARA IMÁGENES
    function openModal(imageSrc) {
        const modal = document.getElementById('imageModal');
        const modalImg = document.getElementById('modalImage');
        modal.style.display = "block";
        modalImg.src = imageSrc;
    }

    document.querySelector('.close').addEventListener('click', function() {
        document.getElementById('imageModal').style.display = "none";
    });

    window.addEventListener('click', function(event) {
        const modal = document.getElementById('imageModal');
        if (event.target == modal) {
            modal.style.display = "none";
        }
    });
</script>
@endsection