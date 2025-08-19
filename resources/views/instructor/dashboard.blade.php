@extends('layouts.instructor-app-master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<style>
:root {
    --primary-dark: #1A365D;
    --primary-light: #2EC4B6;
    --accent-yellow: #FFD166;
    --accent-orange: #FF6B35;
    --accent-red: #d82c0d;
    --white: #FFFFFF;
    --light-gray: #f8f9fa;
    --medium-gray: #e9ecef;
    --dark-shadow: rgba(0, 0, 0, 0.15);
    --transition: all 0.3s ease;
}

body {
    font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
    line-height: 1.6;
    color: #333;
}

.registrations-container {
    max-width: 1400px;
    margin: 0 auto;
    padding: 2rem 1.5rem;
    width: 95%;
}

.registrations-header {
    text-align: center;
    margin-bottom: 3rem;
    position: relative;
    padding-bottom: 1.5rem;
}

.registrations-header::after {
    content: '';
    position: absolute;
    bottom: 0;
    left: 50%;
    transform: translateX(-50%);
    width: 120px;
    height: 4px;
    background: linear-gradient(90deg, var(--primary-dark), var(--primary-light));
    border-radius: 2px;
}

.registrations-title {
    font-size: clamp(1.8rem, 4vw, 2.5rem);
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-weight: 800;
    letter-spacing: -0.5px;
}

.registrations-subtitle {
    font-size: clamp(1rem, 3vw, 1.4rem);
    color: var(--primary-dark);
    opacity: 0.8;
    font-weight: 400;
    max-width: 700px;
    margin: 0 auto;
}

.registrations-card {
    background-color: var(--white);
    border-radius: 12px;
    box-shadow: 0 8px 30px rgba(0, 0, 0, 0.08);
    padding: clamp(1.5rem, 3vw, 2.5rem);
    margin-bottom: 3rem;
    border: none;
    transition: var(--transition);
}

.registrations-card:hover {
    box-shadow: 0 12px 35px rgba(0, 0, 0, 0.12);
}

.alert {
    padding: 1.2rem 1.5rem;
    margin-bottom: 2rem;
    border-radius: 8px;
    font-size: clamp(1rem, 3vw, 1.2rem);
    display: flex;
    align-items: center;
    gap: 1rem;
    border-left: 5px solid;
    box-shadow: 0 3px 10px var(--dark-shadow);
}

.alert i {
    font-size: 1.5rem;
}

.alert-success {
    background-color: rgba(46, 196, 182, 0.15);
    color: var(--primary-dark);
    border-color: var(--primary-light);
}

.alert-danger {
    background-color: rgba(255, 107, 53, 0.15);
    color: var(--primary-dark);
    border-color: var(--accent-orange);
}

/* ESTILOS PARA LA TABLA PRINCIPAL */
.registrations-table {
    width: 100%;
    border-collapse: separate;
    border-spacing: 0;
    margin-top: 1.5rem;
    overflow: hidden;
}

.registrations-table thead {
    background: linear-gradient(135deg, var(--primary-dark), #2a4365);
    color: var(--white);
    position: sticky;
    top: 0;
}

.registrations-table th, 
.registrations-table td {
    padding: clamp(0.8rem, 2vw, 1.2rem);
    text-align: left;
    font-size: clamp(0.95rem, 3vw, 1.1rem);
    border-bottom: 1px solid var(--medium-gray);
}

.registrations-table th {
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.9rem;
    letter-spacing: 0.5px;
}

.registrations-table th i {
    margin-right: 8px;
}

.registrations-table tbody tr {
    transition: var(--transition);
}

.registrations-table tbody tr:last-child td {
    border-bottom: none;
}

.registrations-table tbody tr:hover {
    background-color: rgba(46, 196, 182, 0.05);
    transform: translateY(-2px);
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
}

.registrations-table tbody tr:nth-child(even) {
    background-color: var(--light-gray);
}

.registrations-table tbody tr:nth-child(even):hover {
    background-color: rgba(46, 196, 182, 0.08);
}

/* ESTILOS PARA VERSIÓN MÓVIL (TABLA HORIZONTAL) */
.mobile-table-container {
    display: none;
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
    margin-top: 1rem;
}

.mobile-table {
    min-width: 600px;
    border-collapse: separate;
    border-spacing: 0;
}

.mobile-table th, 
.mobile-table td {
    padding: 0.8rem;
    text-align: left;
    border-bottom: 1px solid var(--medium-gray);
    white-space: nowrap;
}

.mobile-table th {
    background: linear-gradient(135deg, var(--primary-dark), #2a4365);
    color: var(--white);
    font-weight: 600;
    text-transform: uppercase;
    font-size: 0.8rem;
    letter-spacing: 0.5px;
    position: sticky;
    left: 0;
}

.mobile-table tbody tr {
    background-color: var(--white);
}

.mobile-table tbody tr:nth-child(even) {
    background-color: var(--light-gray);
}

.empty-state {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    padding: 3rem 1rem;
    text-align: center;
}

.empty-icon {
    font-size: clamp(3rem, 10vw, 5rem);
    color: var(--medium-gray);
    margin-bottom: 1.5rem;
}

.empty-message {
    font-size: clamp(1.2rem, 3vw, 1.6rem);
    color: var(--primary-dark);
    margin-bottom: 1rem;
    font-weight: 500;
}

.empty-submessage {
    font-size: clamp(1rem, 3vw, 1.2rem);
    color: #666;
    max-width: 500px;
    margin: 0 auto;
}

.divider {
    height: 1px;
    background: linear-gradient(90deg, transparent, var(--primary-light), transparent);
    margin: 2.5rem 0;
}

/* Badge para estado de clases */
.status-badge {
    display: inline-block;
    padding: 0.35rem 0.8rem;
    border-radius: 50px;
    font-size: 0.75rem;
    font-weight: 600;
    text-transform: uppercase;
    letter-spacing: 0.5px;
}

.badge-completed {
    background-color: rgba(46, 196, 182, 0.15);
    color: var(--primary-dark);
}

.badge-upcoming {
    background-color: rgba(255, 209, 102, 0.15);
    color: #8a6d3b;
}

.badge-cancelled {
    background-color: rgba(255, 107, 53, 0.15);
    color: var(--accent-orange);
}

/* MEDIA QUERIES PARA RESPONSIVE */
@media (max-width: 992px) {
    .registrations-container {
        padding: 1.5rem 1rem;
    }
    
    .registrations-card {
        padding: 1.5rem;
    }
}

/* Versión móvil - ocultar tabla normal y mostrar tabla horizontal */
@media (max-width: 768px) {
    .registrations-table {
        display: none;
    }
    
    .mobile-table-container {
        display: block;
    }
    
    .alert {
        flex-direction: column;
        text-align: center;
        gap: 0.8rem;
    }
    
    .empty-state {
        padding: 2rem 0.5rem;
    }
}

/* Animaciones */
@keyframes fadeIn {
    from { opacity: 0; transform: translateY(10px); }
    to { opacity: 1; transform: translateY(0); }
}

.registrations-card {
    animation: fadeIn 0.5s ease-out;
}

.registrations-table tbody tr,
.mobile-table tbody tr {
    animation: fadeIn 0.3s ease-out;
    animation-fill-mode: both;
}

.registrations-table tbody tr:nth-child(1),
.mobile-table tbody tr:nth-child(1) { animation-delay: 0.1s; }
.registrations-table tbody tr:nth-child(2),
.mobile-table tbody tr:nth-child(2) { animation-delay: 0.2s; }
.registrations-table tbody tr:nth-child(3),
.mobile-table tbody tr:nth-child(3) { animation-delay: 0.3s; }
.registrations-table tbody tr:nth-child(4),
.mobile-table tbody tr:nth-child(4) { animation-delay: 0.4s; }
</style>

<div class="registrations-container">
    <div class="registrations-header">
        <div class="header-icon">
            <i class="fas fa-chalkboard-teacher mb-3" style="color: var(--primary-dark); font-size: clamp(3rem, 10vw, 4.5rem);"></i>
        </div>
        <h1 class="registrations-title">Registros de Clases</h1>
        <p class="registrations-subtitle">Visualiza todos los alumnos registrados en tus clases programadas</p>
    </div>

    <div class="registrations-card">
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> 
                <div>{{ session('success') }}</div>
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger">
                <i class="fas fa-exclamation-triangle"></i> 
                <div>{{ session('error') }}</div>
            </div>
        @endif

        @if($registrations->isEmpty())
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-user-slash"></i>
                </div>
                <h3 class="empty-message">No hay registros disponibles</h3>
                <p class="empty-submessage">Actualmente no tienes alumnos registrados en tus clases. Los registros aparecerán aquí cuando los alumnos se inscriban.</p>
            </div>
        @else
            <!-- Versión de escritorio (Tabla normal) -->
            <div class="table-responsive">
                <table class="registrations-table">
                    <thead>
                        <tr>
                            <th><i class="fas fa-user"></i> Alumno</th>
                            <th><i class="fas fa-dumbbell"></i> Servicio</th>
                            <th><i class="far fa-calendar-alt"></i> Fecha</th>
                            <th><i class="far fa-clock"></i> Hora</th>
                            <th><i class="fas fa-align-left"></i> Descripción</th>
                            <th><i class="fas fa-info-circle"></i> Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            @php
                                $classDate = \Carbon\Carbon::parse($registration->class->date);
                                $isPast = $classDate->isPast();
                                $statusClass = $isPast ? 'badge-completed' : 'badge-upcoming';
                                $statusText = $isPast ? 'Completada' : 'Próxima';
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $registration->user->names }} {{ $registration->user->last_name }}</strong>
                                </td>
                                <td>{{ $registration->class->service->name }}</td>
                                <td>{{ $classDate->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->class->time)->format('h:i A') }}</td>
                                <td>{{ Str::limit($registration->class->description, 50, '...') }}</td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Versión móvil (Tabla horizontal) -->
            <div class="mobile-table-container">
                <table class="mobile-table">
                    <thead>
                        <tr>
                            <th>Alumno</th>
                            <th>Servicio</th>
                            <th>Fecha</th>
                            <th>Hora</th>
                            <th>Descripción</th>
                            <th>Estado</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registrations as $registration)
                            @php
                                $classDate = \Carbon\Carbon::parse($registration->class->date);
                                $isPast = $classDate->isPast();
                                $statusClass = $isPast ? 'badge-completed' : 'badge-upcoming';
                                $statusText = $isPast ? 'Completada' : 'Próxima';
                            @endphp
                            <tr>
                                <td>
                                    <strong>{{ $registration->user->names }} {{ $registration->user->last_name }}</strong>
                                </td>
                                <td>{{ $registration->class->service->name }}</td>
                                <td>{{ $classDate->translatedFormat('d/m/Y') }}</td>
                                <td>{{ \Carbon\Carbon::parse($registration->class->time)->format('h:i A') }}</td>
                                <td>{{ Str::limit($registration->class->description, 30, '...') }}</td>
                                <td>
                                    <span class="status-badge {{ $statusClass }}">{{ $statusText }}</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif

        <div class="divider"></div>
        
        @if(!$registrations->isEmpty())
            <div class="d-flex justify-content-end">
                <small class="text-muted">Mostrando {{ $registrations->count() }} registros</small>
            </div>
        @endif
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Interacción para la versión de escritorio
    const tableRows = document.querySelectorAll('.registrations-table tbody tr');
    tableRows.forEach(row => {
        row.addEventListener('click', function() {
            // Aquí puedes agregar funcionalidad al hacer clic en una fila
            console.log('Clic en la fila:', this);
        });
        
        row.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-3px)';
            this.style.boxShadow = '0 6px 15px rgba(0, 0, 0, 0.1)';
        });
        
        row.addEventListener('mouseleave', function() {
            this.style.transform = '';
            this.style.boxShadow = '';
        });
    });
    
    // Interacción para la versión móvil
    const mobileRows = document.querySelectorAll('.mobile-table tbody tr');
    mobileRows.forEach(row => {
        row.addEventListener('click', function() {
            // Aquí puedes agregar funcionalidad al hacer clic en una fila móvil
            console.log('Clic en la fila móvil:', this);
        });
    });
});
</script>
@endsection