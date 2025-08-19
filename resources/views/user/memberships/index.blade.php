@extends('layouts.app-master')

@section('content')
<style>
    /* Paleta de colores FITNFLOW */
    :root {
        --azul-marino: #1A365D;
        --naranja-brillante: #FF6B35;
        --verde-esmeralda: #2EC4B6;
        --blanco: #FFFFFF;
        --azul-oscuro: #0f2a4a;
        --neon-glow: #2EC4B6;
        --sombra-verde: rgba(46, 196, 182, 0.3);
        --sombra-naranja: rgba(255, 107, 53, 0.4);
        --black: #000000; /* Añade esta línea */

    }

    /* Estilos generales */
    body {
        background-color: var(--azul-oscuro);
        color: var(--blanco);
        cursor: default;
    }

    .container h1 {
        color: var(--azul-marino);
        text-align: center;
        margin: 2rem 0;
        font-weight: 700;
        font-size: 2.5rem;
        text-shadow: 0 4px 10px rgba(0, 0, 0, 0.4);
        line-height: 1.3;
        letter-spacing: 1px;
    }

    .container h1::after {
        content: '';
        display: block;
        width: 120px;
        height: 4px;
        margin: 1rem auto 0;
        border-radius: 4px;
        background: linear-gradient(
            90deg,
            var(--azul-marino),
            var(--azul-oscuro),
            var(--verde-esmeralda),
            var(--naranja-brillante),
            var(--blanco)
        );
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.3);
    }

    /* Tarjetas compactas */
    .e-card {
        margin: 20px auto;
        background: rgba(255, 255, 255, 0.05);
        box-shadow: 0px 8px 28px -9px rgba(0,0,0,0.45);
        position: relative;
        width: 100%;
        max-width: 280px;
        height: auto;
        min-height: 420px;
        border-radius: 16px;
        overflow: hidden;
        backdrop-filter: blur(10px);
        border: 1px solid rgba(255, 255, 255, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
        display: flex;
        flex-direction: column;
    }

    .e-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 12px 30px var(--sombra-verde);
    }

    .wave {
        position: absolute;
        width: 540px;
        height: 700px;
        opacity: 0.6;
        left: 0;
        top: 0;
        margin-left: -50%;
        margin-top: -70%;
        background: linear-gradient(744deg, var(--azul-marino), var(--verde-esmeralda) 60%, var(--naranja-brillante));
        border-radius: 40%;
        animation: wave 55s infinite linear;
    }

    .wave:nth-child(2) {
        top: 210px;
        animation-duration: 50s;
        background: linear-gradient(744deg, var(--verde-esmeralda), var(--naranja-brillante) 60%, var(--azul-marino));
    }

    .wave:nth-child(3) {
        top: 210px;
        animation-duration: 45s;
        background: linear-gradient(744deg, var(--naranja-brillante), var(--azul-marino) 60%, var(--verde-esmeralda));
    }

    @keyframes wave {
        0% { transform: rotate(0deg); }
        10% { transform: rotate(360deg); }
    }

    /* Contenido de la tarjeta */
    .card-content {
        padding: 20px;
        position: relative;
        z-index: 1;
        display: flex;
        flex-direction: column;
        height: 100%;
    }

    .icon-container {
        display: flex;
        justify-content: center;
        margin-bottom: 10px;
    }

    /* Icono más grande */
    .icon {
    width: 3.5em;
    color: var(--azul-marino); /* Color para el icono */
    filter: drop-shadow(0 0 5px var(--sombra-verde));
    }

    /* Título más grande (1.6rem) */
    .membership-name {
        color: var(--azul-marino); /Color para el titulo/
        font-size: 1.6rem;
        font-weight: 700;
        margin-bottom: 5px;
        text-align: center;
    }

    .price-container {
        margin: 10px 0;
        text-align: center;
    }

    .price {
        font-size: 2.2rem;
        font-weight: 700;
        color: var(--naranja-brillante);
        line-height: 1;
    }

    .duration {
        font-size: 1.4rem;
        color: var(--blanco);
        opacity: 0.8;
    }

    .description-container {
        margin: 10px 0;
        flex-grow: 1;
        position: relative;
        font-size: 1.4rem;
    }

    /* Texto de descripción */
    .description-text {
        transition: max-height 0.5s ease-out;
        overflow: hidden;
    }
    
    .description-text.collapsed {
        max-height: 80px;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        display: -webkit-box;
    }
    
    .description-text.expanded {
        max-height: 1000px; /* Valor suficientemente grande */
        display: block;
    }

    .description-text.collapsed::after {
        content: '';
        position: absolute;
        bottom: 0;
        left: 0;
        right: 0;
        height: 40px;
        background: linear-gradient(to bottom, transparent, rgba(15, 42, 74, 0.8));
    }

    .toggle-description {
        background: none;
        border: none;
        color: var(--naranja-brillante);
        font-size: 1.1rem;
        font-weight: 600;
        cursor: pointer;
        margin: 8px auto;
        display: block;
        text-align: center;
        padding: 5px;
    }

    .toggle-description:hover {
        color: var(--blanco);
    }

    /* Botón Comenzar */
    .btn-start {
        background-color: var(--verde-esmeralda);
        color: var(--azul-marino);
        border: none;
        padding: 12px 25px;
        font-size: 1.2rem;
        border-radius: 50px;
        font-weight: 700;
        transition: all 0.3s ease;
        margin-top: 15px;
        box-shadow: 0 4px 15px var(--sombra-verde);
        width: 100%;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    .btn-start:hover {
        background-color: var(--naranja-brillante);
        color: var(--blanco);
        transform: translateY(-2px);
        box-shadow: 0 6px 20px var(--sombra-naranja);
    }

    /* Responsive */
    @media (max-width: 768px) {
        .e-card {
            max-width: 100%;
            min-height: 400px;
        }
        
        .price {
            font-size: 2rem;
        }
        
        /* Ajustes para móviles */
        .icon {
            width: 3em;
        }
        
        .membership-name {
            font-size: 1.5rem;
        }
        
        .description-text {
            font-size: 1.4rem;
        }
        
        .description-text.collapsed {
            max-height: 70px;
            -webkit-line-clamp: 2;
        }
        
        .toggle-description {
            font-size: 1rem;
        }
        
        .btn-start {
            font-size: 1.1rem;
        }
    }
</style>

<div class="container">
    <h1 class="mb-4">Membresías Disponibles</h1>

    <div class="row justify-content-center">
        @foreach($memberships as $membership)
            <div class="col-md-4 col-sm-6 d-flex justify-content-center">
                <div class="e-card playing">
                    <div class="wave"></div>
                    <div class="wave"></div>
                    <div class="wave"></div>

                    <div class="card-content">
                        <div class="icon-container">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="icon">
                                <path fill="currentColor" d="M19.4133 4.89862L14.5863 2.17544C12.9911 1.27485 11.0089 1.27485 9.41368 2.17544L4.58674
                                4.89862C2.99153 5.7992 2 7.47596 2 9.2763V14.7235C2 16.5238 2.99153 18.2014 4.58674 19.1012L9.41368
                                21.8252C10.2079 22.2734 11.105 22.5 12.0046 22.5C12.6952 22.5 13.3874 22.3657 14.0349 22.0954C14.2204
                                22.018 14.4059 21.9273 14.5872 21.8252L19.4141 19.1012C19.9765 18.7831 20.4655 18.3728 20.8651
                                17.8825C21.597 16.9894 22 15.8671 22 14.7243V9.27713C22 7.47678 21.0085 5.7992 19.4133 4.89862ZM4.10784
                                14.7235V9.2763C4.10784 8.20928 4.6955 7.21559 5.64066 6.68166L10.4676 3.95848C10.9398 3.69152 11.4701
                                3.55804 11.9996 3.55804C12.5291 3.55804 13.0594 3.69152 13.5324 3.95848L18.3593 6.68166C19.3045 7.21476
                                19.8922 8.20928 19.8922 9.2763V9.75997C19.1426 9.60836 18.377 9.53091 17.6022 9.53091C14.7929 9.53091
                                12.1041 10.5501 10.0309 12.3999C8.36735 13.8847 7.21142 15.8012 6.68783 17.9081L5.63981 17.3165C4.69466
                                16.7834 4.10699 15.7897 4.10699 14.7235H4.10784ZM10.4676 20.0413L8.60933 18.9924C8.94996 17.0479 9.94402
                                15.2665 11.4515 13.921C13.1353 12.4181 15.3198 11.5908 17.6022 11.5908C18.3804 11.5908 19.1477 11.6864
                                19.8922 11.8742V14.7235C19.8922 15.2278 19.7589 15.7254 19.5119 16.1662C18.7615 15.3596 17.6806 14.8528
                                16.4783 14.8528C14.2136 14.8528 12.3781 16.6466 12.3781 18.8598C12.3781 19.3937 12.4861 19.9021 12.68
                                20.3676C11.9347 20.5316 11.1396 20.4203 10.4684 20.0413H10.4676Z"></path>
                            </svg>
                        </div>
                        
                        <div class="membership-name">{{ $membership->name }}</div>
                        
                        <div class="price-container">
                            <div class="price">${{ number_format($membership->price, 2) }}</div>
                            <div class="duration">{{ $membership->readable_duration }}</div>
                        </div>
                        
                        <div class="description-container">
                            <div class="description-text collapsed" id="desc-{{ $membership->id }}">
                                {{ $membership->description }}
                            </div>
                            @if(strlen($membership->description) > 100)
                                <button class="toggle-description" data-target="desc-{{ $membership->id }}">
                                    Ver más <i class="fas fa-chevron-down"></i>
                                </button>
                            @endif
                        </div>
                        
                        <a href="{{ route('user.memberships.pay', $membership->id) }}" class="btn btn-start">Comenzar</a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Seleccionar todos los botones de toggle
    const toggleButtons = document.querySelectorAll('.toggle-description');
    
    toggleButtons.forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('data-target');
            const description = document.getElementById(targetId);
            
            // Verificar si está expandido o colapsado
            const isExpanded = description.classList.contains('expanded');
            
            // Alternar clases
            description.classList.toggle('expanded');
            description.classList.toggle('collapsed');
            
            // Cambiar el texto e ícono del botón
            if (isExpanded) {
                this.innerHTML = 'Ver más <i class="fas fa-chevron-down"></i>';
            } else {
                this.innerHTML = 'Ver menos <i class="fas fa-chevron-up"></i>';
            }
        });
    });
    
    // Verificación inicial para ocultar/mostrar botones
    document.querySelectorAll('.description-text').forEach(desc => {
        const container = desc.parentElement;
        const button = container.querySelector('.toggle-description');
        
        // Si el contenido no es lo suficientemente largo, ocultar el botón
        if (desc.scrollHeight <= desc.clientHeight && button) {
            button.style.display = 'none';
        }
    });
});
</script>
<!-- FontAwesome con fallback -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" 
      integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" 
      crossorigin="anonymous" referrerpolicy="no-referrer" />
      
<!-- Fallback si FontAwesome no carga -->
<script>
    if(typeof FontAwesome === 'undefined') {
        document.write('<link href="https://cdn.jsdelivr.net/npm/@fortawesome/fontawesome-free@6/css/all.min.css" rel="stylesheet">');
    }
</script>
@endsection