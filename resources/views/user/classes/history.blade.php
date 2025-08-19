@extends('layouts.app-master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div class="container-fluid py-4">
    <!-- Welcome Message -->
    <div class="mb-4 text-center p-4 rounded-3">
        <i class="fas fa-history fa-5x mb-3" style="color: #1A365D;"></i>
        <h2 class="fw-bold" style="font-size: 1.8rem; color: #1A365D; margin-bottom: 0.5rem;">
            ¡Historial de Clases!
        </h2>
        <p style="font-size: 1.6rem; color: #1A365D; opacity: 0.8; margin-bottom: 1.8rem;">
            Revisa todas las clases que has tomado
        </p>
    </div>

    <!-- Main Content -->
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-calendar-check me-2"></i>Mis Clases</h5>
        </div>
        <div class="card-body">
            @forelse($reservas as $registro)
                @php
                    $class = $registro->class;
                    $statusName = $class->status?->name ? strtolower(trim($class->status->name)) : null;
                    $isCanceled = $statusName === 'cancelada';
                    $classDateTime = \Carbon\Carbon::parse($class->date->Format('Y-m-d') . ' ' . $class->time);
                    $isPastClass = $classDateTime->isPast();
                @endphp

                <div class="class-card p-4 rounded-3 mb-4" style="border-left: 4px solid #1A365D; background-color: #FFFFFF;">
                    <div class="d-flex justify-content-between align-items-start mb-3">
                        <h3 class="fw-bold" style="color: #1A365D; font-size: 1.4rem;">
                            {{ $class->service->name ?? 'Servicio no disponible' }}
                        </h3>
                        @if($isCanceled)
                            <span class="badge" style="background-color: #FFD166; color: white; font-size: 1.4rem;">
                                Cancelada
                            </span>
                        @elseif($isPastClass)
                            <span class="badge" style="background-color: #2EC4B6; color: white; font-size: 1.4rem;">
                                Realizada
                            </span>
                        @else
                            <span class="badge" style="background-color: #1A365D; color: white; font-size: 1.4rem;">
                                Próxima
                            </span>
                        @endif
                    </div>
                    
                    <p class="mb-2" style="font-size: 1.4rem; color: #333;">
                        <i class="fas fa-info-circle me-2" style="color: #1A365D;"></i>
                        {{ $class->description ?? 'Sin descripción disponible' }}
                    </p>
                    
                    <div class="mb-3">
                        <p class="mb-1" style="font-size: 1.4rem; color: #333;">
                            <i class="fas fa-user-tie me-2" style="color: #1A365D;"></i>
                            Instructor: {{ $class->instructor->names ?? 'N/A' }} {{ $class->instructor->last_name ?? '' }}
                        </p>
                        <p class="mb-1" style="font-size: 1.4rem; color: #333;">
                            <i class="fas fa-calendar-day me-2" style="color: #1A365D;"></i>
                            Fecha: {{ \Carbon\Carbon::parse($class->date)->translatedFormat('d \d\e F \d\e Y') }}
                        </p>
                        <p class="mb-1" style="font-size: 1.4rem; color: #333;">
                            <i class="fas fa-clock me-2" style="color: #1A365D;"></i>
                            Hora: {{ \Carbon\Carbon::parse($class->time)->format('h:i A') }}
                        </p>
                        <p class="mb-1" style="font-size: 1.4rem; color: #333;">
                            <i class="fas fa-users me-2" style="color: #1A365D;"></i>
                            Cupo: {{ $class->registrations_count ?? $class->registrations->count() }}/{{ $class->max_capacity ?? 'N/A' }}
                        </p>
                    </div>
                    
                    @if($isCanceled && !empty($class->comment))
                        <div class="mb-3">
                            <p class="fw-bold mb-2" style="font-size: 1.4rem; color: #FF6B35;">
                                <i class="fas fa-exclamation-triangle me-2"></i>Motivo de cancelación:
                            </p>
                            <p style="font-size: 1.4rem; color: #333;">{{ $class->comment }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center p-4">
                    <p style="font-size: 1.4rem; color: #666;">No tienes historial de clases aún.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<style>
    .payment-card {
        border: 2px solid #1A365D;
        border-radius: 8px;
        box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        overflow: hidden;
    }
    
    .payment-card-header {
        background-color: #1A365D;
        color: #FFFFFF;
        border-bottom: 5px solid #FF6B35;
        padding: 1rem 1.5rem;
    }
    
    .payment-card-header h5 {
        margin: 0;
        display: flex;
        align-items: center;
        font-size: 1.5rem;
    }
    
    .class-card {
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        border: 1px solid #1A365D;
        box-shadow: 0 2px 4px rgba(0,0,0,0.05);
    }

    .class-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 6px 12px rgba(0,0,0,0.1);
    }
    
    .badge {
        padding: 0.5em 0.8em;
        border-radius: 4px;
        font-weight: 600;
    }
    
    @media (max-width: 768px) {
        .payment-card-header h5 {
            font-size: 1.4rem;
        }
        
        .class-card {
            padding: 1.5rem;
        }
    }
</style>
@endsection