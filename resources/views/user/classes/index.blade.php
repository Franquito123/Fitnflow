@extends('layouts.app-master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">

<div class="container-fluid py-4">
    <!-- Welcome Message -->
    <div class="mb-4 text-center p-4 rounded-3">
        <i class="fas fa-dumbbell fa-5x mb-3" style="color: #1A365D;"></i>
        <h2 class="fw-bold" style="font-size: 1.8rem; color: #1A365D; margin-bottom: 0.5rem;">
            ¡Bienvenido a tu Gestión de Clases!
        </h2>
        <p style="font-size: 1.6rem; color: #1A365D; opacity: 0.8; margin-bottom: 1.8rem;">
            Reserva, gestiona y revisa tus clases programadas
        </p>
    </div>

    <!-- Sección 1: Clases Disponibles -->
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-calendar-plus me-2"></i>Clases Disponibles</h5>
        </div>
        <div class="card-body">
            <div class="row">
                @foreach ($classes as $class)
                @php
                    $isRegistered = $class->registrations->contains('user_id', auth()->id());
                    $classDateTime = \Carbon\Carbon::parse($class->date->format('Y-m-d') . ' ' . $class->time);
                    $hasPassed = now()->greaterThan($classDateTime);
                @endphp
                @if(!$isRegistered && $class->registrations_count < $class->max_capacity && !$hasPassed)
                <div class="col-md-6 mb-4">
                    <div class="class-card p-4 rounded-3" style="border-left: 4px solid #1A365D; background-color: #FFFFFF;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="fw-bold" style="color: #1A365D; font-size: 1.4rem;">{{ $class->service->name }}</h3>
                            <span class="badge" style="background-color: #2EC4B6; color: white; font-size: 1.4rem;">
                                {{ $class->registrations_count }}/{{ $class->max_capacity }} cupos
                            </span>
                        </div>
                        
                        <p class="mb-2" style="font-size: 1.4rem; color: #333;"><i class="fas fa-info-circle me-2" style="color: #1A365D;"></i>{{ $class->description }}</p>
                        
                        <div class="mb-3">
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-user-tie me-2" style="color: #1A365D;"></i>Instructor: {{ $class->instructor->names }} {{ $class->instructor->last_name }}</p>
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-calendar-day me-2" style="color: #1A365D;"></i>Fecha: {{ $class->date->format('d/m/Y') }}</p>
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-clock me-2" style="color: #1A365D;"></i>Hora: {{ \Carbon\Carbon::parse($class->time)->format('h:i A') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="fw-bold mb-2" style="font-size: 1.4rem; color: #1A365D;"><i class="fas fa-clipboard-list me-2"></i>Requisitos:</p>
                            <ul class="list-group list-group-flush">
                                @foreach ($class->service->requirements as $requirement)
                                <li class="list-group-item" style="font-size: 1.4rem; background-color: transparent; border-left: none; border-right: none;">• {{ $requirement->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            <form method="POST" action="{{ route('user.classes.register', $class->id) }}" class="d-inline-block">
                                @csrf
                                <button class="btn px-4 py-2" style="background-color: #1A365D; color: white; font-size: 1.4rem; min-width: 100px;">
                                    <i class="fas fa-calendar-plus me-1"></i> Reservar
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>

    <!-- Canceled Classes Section -->
    @if($comments->count())
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-exclamation-triangle me-2"></i>Clases Canceladas</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 payment-table">
                    <thead>
                        <tr>
                            <th style="font-size: 1.4rem;">Clase</th>
                            <th style="font-size: 1.4rem;">Fecha</th>
                            <th style="font-size: 1.4rem;">Motivo</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($comments as $class)
                            @php
                                $isCancelada = $class->status && strtolower($class->status->name) === 'cancelada';
                            @endphp
                            @if($isCancelada)
                            <tr>
                                <td style="font-size: 1.4rem;">{{ $class->service->name }}</td>
                                <td style="font-size: 1.4rem;">{{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }}</td>
                                <td style="font-size: 1.4rem;">{{ $class->comment }}</td>
                            </tr>
                            @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Full Classes Section -->
    @if($clasesLlenas->count())
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-users-slash me-2"></i>Clases con Cupo Lleno</h5>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table align-middle mb-0 payment-table">
                    <thead>
                        <tr>
                            <th style="font-size: 1.4rem;">Clase</th>
                            <th style="font-size: 1.4rem;">Fecha</th>
                            <th style="font-size: 1.4rem;">Hora</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($clasesLlenas as $class)
                        @php
                            $classDateTime = \Carbon\Carbon::parse($class->date->format('Y-m-d') . ' ' . $class->time);
                            $hasPassed = now()->greaterThan($classDateTime);
                        @endphp
                        @if(!$hasPassed)
                        <tr>
                            <td style="font-size: 1.4rem;">{{ $class->service->name }}</td>
                            <td style="font-size: 1.4rem;">{{ \Carbon\Carbon::parse($class->date)->format('d/m/Y') }}</td>
                            <td style="font-size: 1.4rem;">{{ \Carbon\Carbon::parse($class->time)->format('h:i A') }}</td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    @endif

    <!-- Upcoming Classes -->
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-calendar-alt me-2"></i>Mis Próximas Clases</h5>
        </div>
        <div class="card-body p-0">
            @php
                $hasUpcomingClasses = false;
                foreach ($upcomingRegistrations as $registration) {
                    $classDateTime = \Carbon\Carbon::parse($registration->class->date->format('Y-m-d') . ' ' . $registration->class->time);
                    if (!now()->greaterThan($classDateTime)) {
                        $hasUpcomingClasses = true;
                        break;
                    }
                }
            @endphp
            
            @if (!$hasUpcomingClasses)
            <div class="text-center p-4">
                <p style="font-size: 1.4rem; color: #666;">No tienes reservas próximas.</p>
            </div>
            @else
            <div class="table-responsive">
                <table class="table align-middle mb-0 payment-table">
                    <thead>
                        <tr>
                            <th style="font-size: 1.4rem;">Clase</th>
                            <th style="font-size: 1.4rem;">Descripción</th>
                            <th style="font-size: 1.4rem;">Instructor</th>
                            <th style="font-size: 1.4rem;">Fecha</th>
                            <th style="font-size: 1.4rem;">Hora</th>
                            <th style="font-size: 1.4rem;">Requisitos</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($upcomingRegistrations as $registration)
                        @php
                            $classDateTime = \Carbon\Carbon::parse($registration->class->date->format('Y-m-d') . ' ' . $registration->class->time);
                            $hasPassed = now()->greaterThan($classDateTime);
                        @endphp
                        @if(!$hasPassed)
                        <tr>
                            <td style="font-size: 1.4rem;">{{ $registration->class->service->name }}</td>
                            <td style="font-size: 1.4rem;">{{ $registration->class->description }}</td>
                            <td style="font-size: 1.4rem;">{{ $registration->class->instructor->names }} {{ $registration->class->instructor->last_name }}</td>
                            <td style="font-size: 1.4rem;">{{ $registration->class->date->format('d/m/Y') }}</td>
                            <td style="font-size: 1.4rem;">{{ \Carbon\Carbon::parse($registration->class->time)->format('h:i A') }}</td>
                            <td style="font-size: 1.4rem;">
                                <ul class="list-unstyled">
                                    @foreach ($registration->class->service->requirements as $requirement)
                                    <li>• {{ $requirement->name }}</li>
                                    @endforeach
                                </ul>
                            </td>
                        </tr>
                        @endif
                        @endforeach
                    </tbody>
                </table>
            </div>
            @endif
        </div>
    </div>

    <!-- Sección 2: Clases Registradas -->
    @php
        $hasActiveRegistrations = false;
        foreach ($upcomingRegistrations as $registration) {
            $classDateTime = \Carbon\Carbon::parse($registration->class->date->format('Y-m-d') . ' ' . $registration->class->time);
            if (!now()->greaterThan($classDateTime)) {
                $hasActiveRegistrations = true;
                break;
            }
        }
    @endphp

    @if($hasActiveRegistrations)
    <div class="card mb-5 payment-card">
        <div class="card-header payment-card-header">
            <h5 class="mb-0" style="font-size: 1.5rem;"><i class="fas fa-calendar-check me-2"></i>Mis Clases Registradas</h5>
        </div>
        <div class="card-body">
            <div class="row">   
                @foreach ($upcomingRegistrations as $registration)
                @php
                    $class = $registration->class;
                    $classDateTime = \Carbon\Carbon::parse($class->date->format('Y-m-d') . ' ' . $class->time);
                    $canCancel = now()->lessThan($classDateTime->copy()->subHours(2));
                    $registeredUsersCount = $class->registrations->count();
                    $hasPassed = now()->greaterThan($classDateTime);
                @endphp
                @if(!$hasPassed)
                <div class="col-md-6 mb-4">
                    <div class="class-card p-4 rounded-3" style="border-left: 4px solid #1A365D; background-color: #FFFFFF;">
                        <div class="d-flex justify-content-between align-items-start mb-3">
                            <h3 class="fw-bold" style="color: #1A365D; font-size: 1.4rem;">{{ $class->service->name }}</h3>
                            <span class="badge" style="background-color: #2EC4B6; color: white; font-size: 1.4rem;">
                                {{ $registeredUsersCount }}/{{ $class->max_capacity }} cupos
                            </span>
                        </div>
                        
                        <p class="mb-2" style="font-size: 1.4rem; color: #333;"><i class="fas fa-info-circle me-2" style="color: #1A365D;"></i>{{ $class->description }}</p>
                        
                        <div class="mb-3">
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-user-tie me-2" style="color: #1A365D;"></i>Instructor: {{ $class->instructor->names }} {{ $class->instructor->last_name }}</p>
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-calendar-day me-2" style="color: #1A365D;"></i>Fecha: {{ $class->date->format('d/m/Y') }}</p>
                            <p class="mb-1" style="font-size: 1.4rem; color: #333;"><i class="fas fa-clock me-2" style="color: #1A365D;"></i>Hora: {{ \Carbon\Carbon::parse($class->time)->format('h:i A') }}</p>
                        </div>
                        
                        <div class="mb-3">
                            <p class="fw-bold mb-2" style="font-size: 1.4rem; color: #1A365D;"><i class="fas fa-clipboard-list me-2"></i>Requisitos:</p>
                            <ul class="list-group list-group-flush">
                                @foreach ($class->service->requirements as $requirement)
                                <li class="list-group-item" style="font-size: 1.4rem; background-color: transparent; border-left: none; border-right: none;">• {{ $requirement->name }}</li>
                                @endforeach
                            </ul>
                        </div>
                        
                        <div class="d-flex justify-content-end">
                            @if ($canCancel)
                                <form method="POST" action="{{ route('user.classes.cancel', $class->id) }}" class="d-inline-block" id="cancelForm{{$class->id}}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn px-4 py-2" style="background-color: #FF6B35; color: white; font-size: 1.4rem; min-width: 100px;" 
                                        onclick="confirmCancel({{$class->id}}, '{{$class->service->name}}', '{{$class->date->format('d/m/Y')}}')">
                                        <i class="fas fa-times-circle me-1"></i> Cancelar
                                    </button>
                                </form>
                            @else
                                <span class="badge bg-secondary px-4 py-2" style="font-size: 1.4rem; min-width: 100px; line-height: normal;">
                                    No se puede cancelar (menos de 2 horas)
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
                @endif
                @endforeach
            </div>
        </div>
    </div>
    @endif

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
        
        .payment-table {
            border-collapse: collapse;
            width: 100%;
            border: 1px solid #000;
        }
        
        .payment-table th,
        .payment-table td {
            border: 1px solid #000;
            padding: 12px 15px;
            text-align: left;
        }
        
        .payment-table th {
            background-color: #1A365D;
            color: white;
            font-weight: 600;
            font-size: 1.3rem;
        }
        
        .payment-table td {
            font-size: 1.3rem;
        }
        
        .payment-table tbody tr:nth-child(even) {
            background-color: #f8f9fa;
        }
        
        .payment-table tbody tr:hover {
            background-color: #e9ecef;
        }
        
        .class-card {
            transition: transform 0.2s ease, box-shadow 0.2s ease;
            height: 100%;
            margin-bottom: 1.5rem;
            border: 1px solid #1A365D;
            box-shadow: 0 2px 4px rgba(0,0,0,0.05);
        }

        .class-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0,0,0,0.1);
        }
        
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-weight: 500;
            font-size: 1.1rem;
        }
        
        .pendiente {
            background-color: #FFD166;
            color: #1A365D;
        }
        
        .aprobado {
            background-color: #2EC4B6;
            color: white;
        }
        
        .rechazado {
            background-color: #FF6B35;
            color: white;
        }
        
        .vencido {
            background-color: #d82c0d;
            color: white;
        }

        .swal2-popup {
            border: 3px solid #1A365D !important;
            border-radius: 12px !important;
            font-family: inherit !important;
        }

        .swal2-title {
            font-size: 1.6rem !important;
            color: #1A365D !important;
            font-weight: bold !important;
        }

        .swal2-html-container {
            font-size: 1.4rem !important;
            color: #1A365D !important;
        }

        .swal2-confirm, .swal2-cancel {
            font-size: 1.3rem !important;
            padding: 0.6rem 1.4rem !important;
            border-radius: 8px !important;
            font-weight: 500 !important;
        }

        .swal2-confirm {
            background-color: #1A365D !important;
            border: none !important;
        }

        .swal2-cancel {
            background-color: #FF6B35 !important;
            border: none !important;
            color: white !important;
        }

        .swal2-icon.swal2-warning {
            color: #FF6B35 !important;
            border-color: #FF6B35 !important;
        }

        .swal2-icon.swal2-success .swal2-success-ring {
            border-color: rgba(42, 194, 182, 0.3) !important;
        }

        .swal2-icon.swal2-success [class^=swal2-success-line] {
            background-color: #2EC4B6 !important;
        }

        .swal2-icon.swal2-error {
            border-color: #FF6B35 !important;
            color: #FF6B35 !important;
        }

        .swal2-icon.swal2-error [class^=swal2-x-mark-line] {
            background-color: #FF6B35 !important;
        }
        
        @media (max-width: 768px) {
            .payment-table {
                display: block;
                overflow-x: auto;
            }
            
            .payment-table th,
            .payment-table td {
                padding: 8px 10px;
                font-size: 1.1rem;
            }
            
            .payment-card-header h5 {
                font-size: 1.3rem;
            }
            
            .class-card {
                padding: 1.5rem;
            }
            
            .status-badge {
                font-size: 1rem;
            }

            .swal2-popup {
                width: 90% !important;
                max-width: 400px !important;
            }

            .swal2-title {
                font-size: 1.4rem !important;
            }

            .swal2-html-container {
                font-size: 1.2rem !important;
            }

            .swal2-confirm, .swal2-cancel {
                font-size: 1.1rem !important;
                padding: 0.5rem 1.2rem !important;
            }
        }
    </style>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        function confirmCancel(classId, className, classDate) {
            Swal.fire({
                title: '¿Cancelar reserva?',
                html: `¿Estás seguro que deseas cancelar la clase <strong>${className}</strong> del <strong>${classDate}</strong>?`,
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Sí, cancelar',
                cancelButtonText: 'No, mantener',
                reverseButtons: true,
                focusCancel: true,
                customClass: {
                    popup: 'swal2-popup',
                    title: 'swal2-title',
                    htmlContainer: 'swal2-html-container',
                    confirmButton: 'swal2-confirm',
                    cancelButton: 'swal2-cancel'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById(`cancelForm${classId}`).submit();
                }
            });
        }
    </script>
</div>
@endsection