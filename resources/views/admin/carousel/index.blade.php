@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5 mb-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <!-- Card Principal -->
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <!-- Header con título y botón -->
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex justify-content-between align-items-center">
                        <h2 class="mb-0" style="font-weight: 700; font-size: 2.0rem;">
                            <i class="fas fa-images me-3"></i>GESTIÓN DEL CARRUSEL
                        </h2>
                        <a href="{{ route('admin.carousel.create') }}" class="btn py-2 px-4" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                            <i class="fas fa-plus-circle me-2"></i> NUEVO SLIDE
                        </a>
                    </div>
                </div>

                <!-- Cuerpo del Card -->
                <div class="card-body p-0">
                    <!-- Mensajes de éxito/error -->
                    @if (session('success'))
                        <div class="alert alert-dismissible fade show m-4 auto-dismiss-alert" role="alert" 
                            style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 fs-4"></i>
                                <strong class="fs-5">{{ session('success') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    @if (session('deleted'))
                        <div class="alert alert-dismissible fade show m-4 auto-dismiss-alert" role="alert" 
                            style="background-color: #FF6B35; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.3rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-trash-alt me-3 fs-4"></i>
                                <strong class="fs-5">{{ session('deleted') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <!-- Tabla de Slides -->
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0" style="border-top: none; width: 100%;">
                            <thead>
                                <tr style="background-color: #1A365D; color: #FFFFFF;">
                                    <th class="ps-4 py-3" style="font-weight: 600; font-size: 1.4rem;"><i class="fas fa-image me-2"></i>Imagen</th>
                                    <th class="py-3" style="font-weight: 600; font-size: 1.4rem;"><i class="fas fa-align-left me-2"></i>Descripción</th>
                                    <th class="py-3" style="font-weight: 600; font-size: 1.4rem;"><i class="fas fa-link me-2"></i>Enlace</th>
                                    <th class="py-3" style="font-weight: 600; font-size: 1.4rem;"><i class="fas fa-sort-numeric-up me-2"></i>Orden</th>
                                    <th class="py-3" style="font-weight: 600; font-size: 1.4rem;"><i class="fas fa-power-off me-2"></i>Activo</th>
                                    <th class="pe-4 py-3 text-center" style="font-weight: 600; font-size: 1.4rem; width: 20%;"><i class="fas fa-cogs me-2"></i>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($slides as $slide)
                                <tr style="border-bottom: 2px solid #F4F4F4;">
                                    <td class="ps-4">
                                        <img src="{{ asset('storage/' . $slide->image_path) }}" width="120" class="rounded shadow" style="max-height: 80px; object-fit: cover;" />
                                    </td>
                                    <td class="wrap-text" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                        <i class="fas fa-comment-alt me-2"></i>{{ $slide->description }}
                                    </td>
                                    <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                        @if($slide->link_url)
                                            <a href="{{ $slide->link_url }}" target="_blank" class="text-blue-600 hover:underline">
                                                <i class="fas fa-external-link-alt me-2"></i>{{ Str::limit($slide->link_url, 20) }}
                                            </a>
                                        @else
                                            <span class="text-muted"><i class="fas fa-unlink me-2"></i>Sin enlace</span>
                                        @endif
                                    </td>
                                    <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                        <i class="fas fa-hashtag me-2"></i>{{ $slide->display_order }}
                                    </td>
                                    <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                        @if($slide->is_active)
                                            <span class="badge bg-success"><i class="fas fa-check-circle me-1"></i>Sí</span>
                                        @else
                                            <span class="badge bg-secondary"><i class="fas fa-times-circle me-1"></i>No</span>
                                        @endif
                                    </td>
                                    <td class="pe-4 text-center">
                                        <div class="d-flex justify-content-center">
                                            <a href="{{ route('admin.carousel.edit', $slide) }}" class="btn py-1 px-2 mx-1" 
                                            style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.3rem; font-weight: 500;">
                                                <i class="fas fa-edit me-1"></i>EDITAR
                                            </a>
                                            <form action="{{ route('admin.carousel.destroy', $slide) }}" method="POST" class="d-inline">
                                                @csrf
                                                @method('DELETE')
                                                <button type="button" class="btn py-1 px-2 mx-1 btn-delete" 
                                                        style="background-color: #FF6B35; color: #FFFFFF; font-size: 1.3rem; font-weight: 500;">
                                                    <i class="fas fa-trash-alt me-1"></i>ELIMINAR
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="6" class="text-center py-4">
                                        <div class="text-muted">
                                            <i class="fas fa-images fs-1" style="color: #1A365D; font-size: 3rem;"></i>
                                            <p class="mt-2 fs-5" style="font-size: 1.4rem; font-weight: 600;">No hay slides registrados</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    <!-- Paginación -->
                    @if($slides->hasPages())
                    <div class="d-flex justify-content-center mt-4 mb-4">
                        <nav aria-label="Page navigation">
                            <ul class="pagination pagination-lg">
                                {{-- Previous Page Link --}}
                                @if($slides->onFirstPage())
                                    <li class="page-item disabled">
                                        <span class="page-link" style="color: #6c757d; font-size: 1.3rem;">&laquo;</span>
                                    </li>
                                @else
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $slides->previousPageUrl() }}" style="color: #1A365D; font-size: 1.3rem;">&laquo;</a>
                                    </li>
                                @endif

                                {{-- Pagination Elements --}}
                                @foreach($slides->getUrlRange(1, $slides->lastPage()) as $page => $url)
                                    @if($page == $slides->currentPage())
                                        <li class="page-item active">
                                            <span class="page-link" style="background-color: #1A365D; border-color: #1A365D; font-size: 1.3rem;">{{ $page }}</span>
                                        </li>
                                    @else
                                        <li class="page-item">
                                            <a class="page-link" href="{{ $url }}" style="color: #1A365D; font-size: 1.3rem;">{{ $page }}</a>
                                        </li>
                                    @endif
                                @endforeach

                                {{-- Next Page Link --}}
                                @if($slides->hasMorePages())
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $slides->nextPageUrl() }}" style="color: #1A365D; font-size: 1.3rem;">&raquo;</a>
                                    </li>
                                @else
                                    <li class="page-item disabled">
                                        <span class="page-link" style="color: #6c757d; font-size: 1.3rem;">&raquo;</span>
                                    </li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                    @endif

                    <!-- Configuración del Carrusel -->
                    <div class="p-4" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                        <h3 class="mb-4" style="font-size: 1.8rem; font-weight: 700; color: #1A365D;">
                            <i class="fas fa-cog me-2"></i>CONFIGURACIÓN DEL CARRUSEL
                        </h3>
                        
                        <form action="{{ route('admin.carousel.updateSettings') }}" method="POST" class="space-y-4 bg-white p-6 rounded shadow">
                            @csrf

                            <div class="row">
                                <div class="col-md-6">
                                    <label for="style" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                        <i class="fas fa-shapes me-2"></i>Topología:
                                    </label>
                                    <select name="style" id="style" class="form-select" style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D;">
                                        <option value="ring" {{ $settings?->style === 'ring' ? 'selected' : '' }}><i class="fas fa-circle-notch me-2"></i>Anillo</option>
                                        <option value="flat" {{ $settings?->style === 'flat' ? 'selected' : '' }}><i class="fas fa-square me-2"></i>Plano</option>
                                        <option value="stacked" {{ $settings?->style === 'stacked' ? 'selected' : '' }}><i class="fas fa-layer-group me-2"></i>Stacked</option>
                                    </select>
                                </div>
                                
                                <div class="col-md-6">
                                    <label for="radius" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                        <i class="fas fa-ruler-combined me-2"></i>Radio (px):
                                    </label>
                                    <input type="number" name="radius" id="radius" value="{{ $settings?->radius ?? 300 }}" 
                                        class="form-control" style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D;" 
                                        min="100" max="1000">
                                </div>
                            </div>

                            <div class="row mt-3">
                                <div class="col-md-6">
                                    <label for="duration" class="form-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D;">
                                        <i class="fas fa-clock me-2"></i>Duración del giro (s):
                                    </label>
                                    <input type="number" name="duration" id="duration" value="{{ $settings?->duration ?? 20 }}" 
                                        class="form-control" style="font-size: 1.3rem; padding: 0.8rem; border: 2px solid #1A365D;" 
                                        min="5" max="60">
                                </div>
                                
                                <div class="col-md-6 d-flex align-items-center">
                                    <div class="holo-toggle-container">
                                        <span class="holo-toggle-label" style="font-size: 1.4rem; font-weight: 600; color: #1A365D; margin-right: 15px;">
                                            <i class="fas fa-sparkles me-2"></i>Animación de brillo:
                                        </span>
                                        <div class="toggle-container" style="transform: scale(0.8); transform-origin: left center;">
                                            <div class="toggle-wrap">
                                                <input class="toggle-input" id="brightness_animation" name="brightness_animation" type="checkbox" {{ $settings?->brightness_animation ? 'checked' : '' }}>
                                                <label class="toggle-track" for="brightness_animation">
                                                    <div class="track-lines">
                                                        <div class="track-line"></div>
                                                    </div>
                                                    <div class="toggle-thumb">
                                                        <div class="thumb-core"></div>
                                                        <div class="thumb-inner"></div>
                                                        <div class="thumb-scan"></div>
                                                        <div class="thumb-particles">
                                                            <div class="thumb-particle"></div>
                                                            <div class="thumb-particle"></div>
                                                            <div class="thumb-particle"></div>
                                                            <div class="thumb-particle"></div>
                                                            <div class="thumb-particle"></div>
                                                        </div>
                                                    </div>
                                                    <div class="toggle-data">
                                                        <div class="data-text off">No</div>
                                                        <div class="data-text on">Si</div>
                                                        <div class="status-indicator off"></div>
                                                        <div class="status-indicator on"></div>
                                                    </div>
                                                    <div class="energy-rings">
                                                        <div class="energy-ring"></div>
                                                        <div class="energy-ring"></div>
                                                        <div class="energy-ring"></div>
                                                    </div>
                                                    <div class="interface-lines">
                                                        <div class="interface-line"></div>
                                                        <div class="interface-line"></div>
                                                        <div class="interface-line"></div>
                                                        <div class="interface-line"></div>
                                                        <div class="interface-line"></div>
                                                        <div class="interface-line"></div>
                                                    </div>
                                                    <div class="toggle-reflection"></div>
                                                    <div class="holo-glow"></div>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="text-end mt-4">
                                <button type="submit" class="btn py-2 px-4" 
                                    style="background-color: #1A365D; color: #FFFFFF; font-weight: 600; font-size: 1.3rem;">
                                    <i class="fas fa-save me-2"></i> GUARDAR CONFIGURACIÓN
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        padding: 12px 8px;
    }
    
    .table td {
        padding: 12px 8px;
        vertical-align: middle;
    }
    
    .btn {
        padding: 0.5rem 1rem;
        border-radius: 6px;
        transition: all 0.2s ease;
        white-space: nowrap;
    }
    
    .table-hover tbody tr:hover {
        background-color: rgba(46, 196, 182, 0.08);
        transform: translateY(-1px);
    }
    
    .alert {
        border-radius: 6px;
    }

    .wrap-text {
        white-space: normal;
        word-break: break-word;
    }

    /* Estilo del alert de confirmación */
    .swal2-actions {
        gap: 1.5rem !important;
        margin-top: 1.5rem !important;
    }
    
    .swal2-confirm, .swal2-cancel {
        padding: 0.6rem 1.5rem !important;
        margin: 0 !important;
    }

    .swal2-popup { 
        border-radius: 10px !important;
        border: 2px solid #1A365D !important;
        font-size: 1.3rem !important;
    }
    
    .swal2-title {
        color: #1A365D !important;
        font-size: 1.7rem !important;
        font-weight: 700 !important;
    }

    .swal2-icon.swal2-warning {
        color: #FF6B35 !important;
        border-color: #FF6B35 !important;
    }

    .swal2-confirm {
        background-color: #FF6B35 !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
    }

    .swal2-cancel {
        background-color: #2EC4B6 !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
    }

    .badge {
        font-size: 1.2rem;
        padding: 0.4rem 0.8rem;
        border-radius: 0.5rem;
    }

    .bg-success {
        background-color: #2EC4B6 !important;
    }

    /* Ajustes para móviles */
    @media (max-width: 992px) {
        .table-responsive {
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table th, .table td {
            white-space: nowrap;
            font-size: 1.0rem !important;
            padding: 10px 6px !important;
        }
        
        .btn {
            padding: 0.4rem 0.8rem !important;
            font-size: 1.0rem !important;
            min-width: auto !important;
        }
        
        .card-header h2 {
            font-size: 1.4rem !important;
        }
        
        .card-header .btn {
            font-size: 1.0rem !important;
            padding: 0.4rem 0.8rem !important;
        }
    }

    .btn-delete {
        transition: all 0.3s ease !important;
    }
    
    .btn-delete:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
    }

    /* Holographic Toggle Switch - Versión más pequeña con tu paleta de colores */
    .toggle-container {
        position: relative;
        width: 100px;
        display: flex;
        flex-direction: column;
        align-items: center;
        perspective: 800px;
        z-index: 5;
    }

    .toggle-wrap {
        position: relative;
        width: 100%;
        height: 40px;
        transform-style: preserve-3d;
    }

    .toggle-input {
        position: absolute;
        opacity: 0;
        width: 0;
        height: 0;
    }

    .toggle-track {
        position: absolute;
        width: 100%;
        height: 100%;
        background: rgba(26, 54, 93, 0.4); /* Azul oscuro */
        border-radius: 20px;
        cursor: pointer;
        box-shadow: 0 0 10px rgba(255, 107, 53, 0.2), inset 0 0 8px rgba(0, 0, 0, 0.8);
        overflow: hidden;
        backdrop-filter: blur(4px);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        border: 1px solid rgba(255, 107, 53, 0.3); /* Naranja */
    }

    .toggle-track::before {
        content: "";
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: radial-gradient(ellipse at center, rgba(255, 107, 53, 0.1) 0%, rgba(0, 0, 0, 0) 70%),
                    linear-gradient(90deg, rgba(26, 54, 93, 0.1) 0%, rgba(13, 27, 46, 0.2) 100%);
        opacity: 0.6;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .toggle-track::after {
        content: "";
        position: absolute;
        top: 2px;
        left: 2px;
        right: 2px;
        height: 8px;
        background: linear-gradient(90deg, rgba(255, 107, 53, 0.3) 0%, rgba(200, 80, 20, 0.1) 100%);
        border-radius: 20px 20px 0 0;
        opacity: 0.7;
        filter: blur(1px);
    }

    .track-lines {
        position: absolute;
        top: 50%;
        left: 0;
        width: 100%;
        height: 1px;
        transform: translateY(-50%);
        overflow: hidden;
    }

    .track-line {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: repeating-linear-gradient(90deg, rgba(255, 107, 53, 0.3) 0px, rgba(255, 107, 53, 0.3) 4px, transparent 4px, transparent 12px);
        animation: track-line-move 2.5s linear infinite;
    }

    @keyframes track-line-move {
        0% { transform: translateX(0); }
        100% { transform: translateX(16px); }
    }

    .toggle-thumb {
        position: absolute;
        width: 34px;
        height: 34px;
        left: 3px;
        top: 3px;
        background: radial-gradient(circle, rgba(13, 27, 46, 0.9) 0%, rgba(6, 13, 23, 0.8) 100%);
        border-radius: 50%;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5), inset 0 0 10px rgba(255, 107, 53, 0.5);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        z-index: 2;
        border: 1px solid rgba(255, 107, 53, 0.6);
        overflow: hidden;
        transform-style: preserve-3d;
    }

    .thumb-core {
        position: absolute;
        width: 26px;
        height: 26px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle, rgba(255, 107, 53, 0.6) 0%, rgba(150, 50, 20, 0.2) 100%);
        border-radius: 50%;
        box-shadow: 0 0 15px rgba(255, 107, 53, 0.5);
        opacity: 0.9;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .thumb-inner {
        position: absolute;
        width: 16px;
        height: 16px;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(255, 150, 100, 0.5) 100%);
        border-radius: 50%;
        box-shadow: 0 0 8px rgba(255, 150, 100, 0.7);
        opacity: 0.7;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        animation: pulse 1.8s infinite alternate;
    }

    @keyframes pulse {
        0% { opacity: 0.5; transform: translate(-50%, -50%) scale(0.9); }
        100% { opacity: 0.8; transform: translate(-50%, -50%) scale(1.1); }
    }

    .thumb-scan {
        position: absolute;
        width: 100%;
        height: 4px;
        background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(255, 107, 53, 0.5) 20%, rgba(255, 255, 255, 0.8) 50%, rgba(255, 107, 53, 0.5) 80%, rgba(0, 0, 0, 0) 100%);
        top: 0;
        left: 0;
        filter: blur(1px);
        animation: thumb-scan 1.8s linear infinite;
        opacity: 0.7;
    }

    @keyframes thumb-scan {
        0% { top: -5px; opacity: 0; }
        20% { opacity: 0.7; }
        80% { opacity: 0.7; }
        100% { top: 34px; opacity: 0; }
    }

    .thumb-particles {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        overflow: hidden;
    }

    .thumb-particle {
        position: absolute;
        width: 2px;
        height: 2px;
        background: rgba(255, 150, 100, 0.8);
        border-radius: 50%;
        box-shadow: 0 0 4px rgba(255, 150, 100, 0.8);
        animation: thumb-particle-float 2.5s infinite ease-out;
        opacity: 0;
    }

    .thumb-particle:nth-child(1) { top: 70%; left: 30%; animation-delay: 0.2s; }
    .thumb-particle:nth-child(2) { top: 60%; left: 60%; animation-delay: 0.6s; }
    .thumb-particle:nth-child(3) { top: 50%; left: 40%; animation-delay: 1s; }
    .thumb-particle:nth-child(4) { top: 40%; left: 70%; animation-delay: 1.4s; }
    .thumb-particle:nth-child(5) { top: 80%; left: 50%; animation-delay: 1.8s; }

    @keyframes thumb-particle-float {
        0% { transform: translateY(0) scale(1); opacity: 0; }
        20% { opacity: 0.8; }
        100% { transform: translateY(-20px) scale(0); opacity: 0; }
    }

    .toggle-data {
        position: absolute;
        width: 100%;
        height: 100%;
        z-index: 1;
    }

    .data-text {
        position: absolute;
        font-size: 20px;
        font-weight: 500;
        letter-spacing: 1px;
        text-transform: uppercase;
        transition: all 0.4s ease;
    }

    .data-text.off {
        right: 10px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 1;
        color: rgba(13, 27, 46, 0.2); /* Naranja */
        text-shadow: 0 0 4px rgba(255, 80, 20, 0.4);
    }

    .data-text.on {
        left: 12px;
        top: 50%;
        transform: translateY(-50%);
        opacity: 0;
        color: rgba(13, 27, 46, 0.2); /* Turquesa */
        text-shadow: 0 0 4px rgba(0, 200, 150, 0.4);
    }

    .status-indicator {
        position: absolute;
        width: 8px;
        height: 8px;
        border-radius: 50%;
        background: radial-gradient(circle, rgba(255, 107, 53, 0.8) 0%, rgba(200, 50, 20, 0.4) 100%);
        box-shadow: 0 0 8px rgba(255, 107, 53, 0.5);
        animation: blink 1.8s infinite alternate;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .status-indicator.off {
        top: 16px;
        right: 12px;
    }

    .status-indicator.on {
        top: 16px;
        left: 12px;
        opacity: 0;
        background: radial-gradient(circle, rgba(46, 196, 182, 0.8) 0%, rgba(0, 150, 120, 0.4) 100%);
        box-shadow: 0 0 8px rgba(46, 196, 182, 0.5);
    }

    @keyframes blink {
        0%, 100% { opacity: 0.5; transform: scale(0.9); }
        50% { opacity: 1; transform: scale(1.1); }
    }

    .energy-rings {
        position: absolute;
        width: 34px;
        height: 34px;
        left: 3px;
        top: 3px;
        pointer-events: none;
        z-index: 1;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .energy-ring {
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        border-radius: 50%;
        border: 1px solid transparent;
        opacity: 0;
    }

    .energy-ring:nth-child(1) {
        width: 32px;
        height: 32px;
        border-top-color: rgba(255, 107, 53, 0.5);
        border-right-color: rgba(255, 107, 53, 0.3);
        animation: spin 2.5s linear infinite;
    }

    .energy-ring:nth-child(2) {
        width: 26px;
        height: 26px;
        border-bottom-color: rgba(255, 107, 53, 0.5);
        border-left-color: rgba(255, 107, 53, 0.3);
        animation: spin 1.8s linear infinite reverse;
    }

    .energy-ring:nth-child(3) {
        width: 20px;
        height: 20px;
        border-left-color: rgba(255, 107, 53, 0.5);
        border-top-color: rgba(255, 107, 53, 0.3);
        animation: spin 1.2s linear infinite;
    }

    @keyframes spin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }

    .interface-lines {
        position: absolute;
        width: 100%;
        height: 100%;
        pointer-events: none;
    }

    .interface-line {
        position: absolute;
        background: rgba(255, 107, 53, 0.3);
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
    }

    .interface-line:nth-child(1) { width: 12px; height: 1px; bottom: -4px; left: 15px; }
    .interface-line:nth-child(2) { width: 1px; height: 6px; bottom: -10px; left: 27px; }
    .interface-line:nth-child(3) { width: 20px; height: 1px; bottom: -10px; left: 27px; }
    .interface-line:nth-child(4) { width: 12px; height: 1px; bottom: -4px; right: 15px; }
    .interface-line:nth-child(5) { width: 1px; height: 6px; bottom: -10px; right: 27px; }
    .interface-line:nth-child(6) { width: 20px; height: 1px; bottom: -10px; right: 8px; }

    .toggle-reflection {
        position: absolute;
        width: 100%;
        height: 100%;
        top: 0;
        left: 0;
        background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0) 40%);
        border-radius: 20px;
        pointer-events: none;
    }

    .holo-glow {
        position: absolute;
        width: 100%;
        height: 100%;
        border-radius: 20px;
        background: radial-gradient(ellipse at center, rgba(255, 107, 53, 0.2) 0%, rgba(0, 0, 0, 0) 70%);
        filter: blur(8px);
        opacity: 0.5;
        transition: all 0.5s cubic-bezier(0.23, 1, 0.32, 1);
        z-index: 0;
    }

    /* Estados activos */
    .toggle-input:checked + .toggle-track {
        background: rgba(13, 46, 40, 0.4);
        border-color: rgba(46, 196, 182, 0.3); /* Turquesa */
        box-shadow: 0 0 10px rgba(46, 196, 182, 0.2), inset 0 0 8px rgba(0, 0, 0, 0.8);
    }

    .toggle-input:checked + .toggle-track::before {
        background: radial-gradient(ellipse at center, rgba(46, 196, 182, 0.1) 0%, rgba(0, 0, 0, 0) 70%),
                    linear-gradient(90deg, rgba(0, 120, 100, 0.1) 0%, rgba(0, 60, 50, 0.2) 100%);
    }

    .toggle-input:checked + .toggle-track::after {
        background: linear-gradient(90deg, rgba(46, 196, 182, 0.3) 0%, rgba(0, 160, 120, 0.1) 100%);
    }

    .toggle-input:checked + .toggle-track .track-line {
        background: repeating-linear-gradient(90deg, rgba(46, 196, 182, 0.3) 0px, rgba(46, 196, 182, 0.3) 4px, transparent 4px, transparent 12px);
        animation-direction: reverse;
    }

    .toggle-input:checked + .toggle-track .toggle-thumb {
        left: calc(100% - 37px);
        background: radial-gradient(circle, rgba(10, 90, 70, 0.9) 0%, rgba(0, 50, 40, 0.8) 100%);
        border-color: rgba(46, 196, 182, 0.6);
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.5), inset 0 0 10px rgba(46, 196, 182, 0.5);
    }

    .toggle-input:checked + .toggle-track .thumb-core {
        background: radial-gradient(circle, rgba(46, 196, 182, 0.6) 0%, rgba(0, 120, 100, 0.2) 100%);
        box-shadow: 0 0 15px rgba(46, 196, 182, 0.5);
    }

    .toggle-input:checked + .toggle-track .thumb-inner {
        background: radial-gradient(circle, rgba(255, 255, 255, 0.8) 0%, rgba(100, 255, 220, 0.5) 100%);
        box-shadow: 0 0 8px rgba(100, 255, 220, 0.7);
    }

    .toggle-input:checked + .toggle-track .thumb-scan {
        background: linear-gradient(90deg, rgba(0, 0, 0, 0) 0%, rgba(46, 196, 182, 0.5) 20%, rgba(255, 255, 255, 0.8) 50%, rgba(46, 196, 182, 0.5) 80%, rgba(0, 0, 0, 0) 100%);
    }

    .toggle-input:checked + .toggle-track .thumb-particle {
        background: rgba(100, 255, 220, 0.8);
        box-shadow: 0 0 4px rgba(100, 255, 220, 0.8);
    }

    .toggle-input:checked + .toggle-track .data-text.off { opacity: 0; }
    .toggle-input:checked + .toggle-track .data-text.on { opacity: 1; }
    .toggle-input:checked + .toggle-track .status-indicator.off { opacity: 0; }
    .toggle-input:checked + .toggle-track .status-indicator.on { opacity: 1; }
    .toggle-input:checked + .toggle-track .energy-rings { left: calc(100% - 37px); }
    .toggle-input:checked + .toggle-track .energy-ring { opacity: 1; }
    .toggle-input:checked + .toggle-track .energy-ring:nth-child(1) { border-top-color: rgba(46, 196, 182, 0.5); border-right-color: rgba(46, 196, 182, 0.3); }
    .toggle-input:checked + .toggle-track .energy-ring:nth-child(2) { border-bottom-color: rgba(46, 196, 182, 0.5); border-left-color: rgba(46, 196, 182, 0.3); }
    .toggle-input:checked + .toggle-track .energy-ring:nth-child(3) { border-left-color: rgba(46, 196, 182, 0.5); border-top-color: rgba(46, 196, 182, 0.3); }
    .toggle-input:checked + .toggle-track .interface-line { background: rgba(46, 196, 182, 0.3); }
    .toggle-input:checked + .toggle-track .holo-glow { background: radial-gradient(ellipse at center, rgba(46, 196, 182, 0.2) 0%, rgba(0, 0, 0, 0) 70%); }

    /* Hover effects */
    .toggle-input:hover + .toggle-track {
        box-shadow: 0 0 15px rgba(255, 107, 53, 0.3), inset 0 0 8px rgba(0, 0, 0, 0.8);
    }

    .toggle-input:checked:hover + .toggle-track {
        box-shadow: 0 0 15px rgba(46, 196, 182, 0.3), inset 0 0 8px rgba(0, 0, 0, 0.8);
    }

    /* Container adjustments */
    .holo-toggle-container {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .holo-toggle-label {
        font-size: 1.4rem;
        font-weight: 600;
        color: #1A365D;
        margin-bottom: 0;
    }
</style>

@section('scripts')
<script>
    // Auto-dismiss alerts after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        // Auto-dismiss alerts
        const alerts = document.querySelectorAll('.auto-dismiss-alert');
        alerts.forEach(alert => {
            setTimeout(() => {
                const bsAlert = new bootstrap.Alert(alert);
                bsAlert.close();
            }, 3000);
        });

        // Confirmación para eliminar
        document.querySelectorAll('.btn-delete').forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                const form = this.closest('form');
                
                Swal.fire({
                    title: '¿Eliminar Slide?',
                    html: `<div style="text-align: center;">
                            <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                            <p>¿Está seguro que desea eliminar este slide permanentemente?</p>
                            <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                        </div>`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Eliminar',
                    cancelButtonText: '<i class="fas fa-times me-2"></i> Cancelar',
                    buttonsStyling: false,
                    customClass: {
                        confirmButton: 'btn btn-delete',
                        cancelButton: 'btn',
                        popup: 'swal2-popup-custom'
                    }
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    });
</script>
@endsection
@endsection