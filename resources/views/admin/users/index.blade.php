@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4 mt-5">
    <div class="row justify-content-center">
        <div class="col-12 col-xxl-10">
            <div class="card shadow-sm" style="border: 2px solid #1A365D;">
                <div class="card-header py-3" style="background-color: #1A365D; color: #FFFFFF; border-bottom: 3px solid #FF6B35;">
                    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center">
                        <!-- Primera fila - Título y botón Nuevo Usuario -->
                        <div class="d-flex justify-content-between align-items-center w-100 mb-3 mb-md-0">
                            <h2 class="mb-0" style="font-weight: 700; font-size: 1.8rem;">
                                <i class="fas fa-users me-3"></i>GESTIÓN DE USUARIOS
                            </h2>
                            
                            <div class="d-flex align-items-center">
                                @auth
                                    @if(auth()->user()->role_id == 1)
                                        <a href="{{ route('admin.users.edit', auth()->user()->id) }}" 
                                           class="btn py-2 px-3 me-2 d-none d-md-block" 
                                           style="background-color: #0A2647; color: #FFFFFF; font-weight: 600; font-size: 1.1rem;">
                                            <i class="fas fa-user-cog me-1"></i> Mi cuenta
                                        </a>
                                    @endif
                                @endauth
                                <a href="{{ route('admin.users.create', ['redirect_filter' => request('roleFilter')]) }}" 
                                   class="btn py-2 px-3" 
                                   style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.1rem;">
                                    <i class="fas fa-plus-circle me-1"></i> NUEVO USUARIO
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros superiores -->
                <div class="card-body p-4" style="background-color: #F4F4F4; border-bottom: 2px solid #1A365D;">
                    <form method="GET" action="{{ route('admin.users.index') }}">
                        <div class="row g-3 align-items-end">
                            <!-- Fila 1: Buscador y Botones -->
                            <div class="col-12 col-md-6">
                                <div class="input-container w-100">
                                    <input 
                                        name="search"
                                        value="{{ request('search') }}"
                                        class="input" 
                                        type="text" 
                                        placeholder="Buscar usuarios..." 
                                        autocomplete="off"/>
                                    <div class="input-icon">
                                        <i class="fas fa-search"></i>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="col-12 col-md-6">
                                <div class="d-flex" style="gap: 1rem;">
                                    <button type="submit" class="btn py-2 px-3 flex-grow-1" style="background-color: #FF6B35; color: #FFFFFF; font-weight: 600; font-size: 1.1rem;">
                                        <i class="fas fa-search me-1"></i> BUSCAR
                                    </button>

                                    <a href="{{ route('admin.users.index', array_merge(request()->except(['search', 'page']), ['search' => null])) }}" 
                                    class="btn py-2 px-3 flex-grow-1" 
                                    style="background-color: #2EC4B6; color: #FFFFFF; font-weight: 600; font-size: 1.1rem; border: 2px solid #1A365D;">
                                        <i class="fas fa-broom me-1"></i> LIMPIAR
                                    </a>
                                </div>
                            </div>
                            
                            <!-- Fila 2: Filtros de Rol y Estado -->
                            <div class="col-12 col-md-6">
                                <div class="circle-select-container w-100">
                                    <select name="roleFilter" class="circle-select" onchange="this.form.submit()">
                                        <option value="2" {{ $roleFilter == '2' ? 'selected' : '' }}>
                                            <i class="fas fa-user me-1"></i> Usuarios
                                        </option>
                                        <option value="3" {{ $roleFilter == '3' ? 'selected' : '' }}>
                                            <i class="fas fa-chalkboard-teacher me-1"></i> Instructores
                                        </option>
                                        <option value="1" {{ $roleFilter == '1' ? 'selected' : '' }}>
                                            <i class="fas fa-user-shield me-1"></i> Administradores
                                        </option>
                                    </select>
                                    <div class="select-icon">
                                        <i class="fas fa-users"></i>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12 col-md-6">
                                <div class="circle-select-container w-100">
                                    <select name="statusFilter" class="circle-select" onchange="this.form.submit()">
                                        <option value="">Todos</option>
                                        @foreach($statuses->filter(fn($status) => in_array($status->name, ['Activo', 'Inactivo'])) as $status)
                                            <option value="{{ $status->id }}" {{ request('statusFilter') == $status->id ? 'selected' : '' }}>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="select-icon">
                                        <i class="fas fa-info-circle"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>

                    @if(request('search') || request('roleFilter') || request('statusFilter') || (request('specialtyFilter') && $roleFilter == '3') || (request('certificationFilter') && $roleFilter == '3'))
                    <div class="alert alert-dismissible fade show m-4" role="alert" id="autoDismissAlert"
                        style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.4rem;">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-filter me-3 fs-4"></i>
                            <strong class="fs-5">
                                Filtros aplicados: 
                                @if(request('search')) <i class="fas fa-search me-1"></i> "{{ request('search') }}" @endif
                                @if(request('roleFilter')) | <i class="fas fa-users me-1"></i> {{ 
                                    request('roleFilter') == '2' ? 'Usuarios' : 
                                    (request('roleFilter') == '3' ? 'Instructores' : 'Administradores') 
                                }} @endif
                                @if(request('statusFilter')) | <i class="fas fa-info-circle me-1"></i> {{ 
                                    \App\Models\Status::find(request('statusFilter'))->name 
                                }} @endif
                                @if(request('specialtyFilter') && $roleFilter == '3')) | <i class="fas fa-certificate me-1"></i> {{ request('specialtyFilter') }} @endif
                                @if(request('certificationFilter') && $roleFilter == '3')) | <i class="fas fa-award me-1"></i> {{ request('certificationFilter') }} @endif
                            </strong>
                            <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    </div>
                    @endif

                    @if (session('success'))
                        <div class="alert alert-dismissible fade show m-4" role="alert" id="autoDismissAlert"
                            style="background-color: #2EC4B6; color: #FFFFFF; border-left: 5px solid #1A365D; font-size: 1.4rem;">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-check-circle me-3 fs-4"></i>
                                <strong class="fs-5">{{ session('success') }}</strong>
                                <button type="button" class="btn-close btn-close-white ms-auto fs-5" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>
                        </div>
                    @endif

                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover align-middle mb-0" style="border-top: none; width: 100%;">
                                <thead>
                                    <tr style="background-color: #1A365D; color: #FFFFFF;">
                                        <th class="ps-4 py-3" style="font-weight: 600; font-size: 1.4rem; width: 10%;">
                                            <i class="fas fa-id-card me-2"></i>Nombres
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 10%;">
                                            <i class="fas fa-id-card me-2"></i>Apellidos
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 15%;">
                                            <i class="fas fa-envelope me-2"></i>Email
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 8%;">
                                            <i class="fas fa-user-tag me-2"></i>Rol
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 8%;">
                                            <i class="fas fa-power-off me-2"></i>Estado
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 10%;">
                                            <i class="fas fa-venus-mars me-2"></i>Género
                                        </th>
                                        <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 12%;">
                                            <i class="fas fa-birthday-cake me-2"></i>Fecha Nacimiento
                                        </th>
                                        @if($roleFilter == '3')
                                            <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 10%;">
                                                <i class="fas fa-certificate me-2"></i>Especialidad
                                            </th>
                                            <th class="py-3" style="font-weight: 600; font-size: 1.4rem; width: 10%;">
                                                <i class="fas fa-award me-2"></i>Certificación
                                            </th>
                                        @endif
                                        <th class="pe-4 py-3 text-center" style="font-weight: 600; font-size: 1.4rem; width: {{ $roleFilter == '3' ? '15%' : '25%' }};">
                                            <i class="fas fa-cogs me-2"></i>Acciones
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($users as $user)
                                    <tr style="border-bottom: 2px solid #F4F4F4; {{ $user->status && $user->status->name === 'Inactivo' ? 'background-color: rgba(255, 107, 53, 0.1);' : 'background-color: rgba(46, 196, 182, 0.1);' }}">
                                        <td class="ps-4" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            <i class="fas fa-user-circle me-2"></i>{{ $user->names }}
                                        </td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">{{ $user->last_name }}</td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            <i class="fas fa-envelope me-2"></i>{{ $user->email }}
                                        </td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            @if($user->role_id == 1)
                                                <i class="fas fa-user-shield me-2"></i>
                                            @elseif($user->role_id == 2)
                                                <i class="fas fa-user me-2"></i>
                                            @else
                                                <i class="fas fa-chalkboard-teacher me-2"></i>
                                            @endif
                                            {{ $user->role->name_rol ?? 'N/A' }}
                                        </td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            @if($user->status && $user->status->name === 'Inactivo')
                                                <span class="badge rounded-pill" style="background-color: #FF6B35; color: white;">
                                                    <i class="fas fa-times-circle me-1"></i>{{ $user->status->name }}
                                                </span>
                                            @else
                                                <span class="badge rounded-pill" style="background-color: #2EC4B6; color: white;">
                                                    <i class="fas fa-check-circle me-1"></i>{{ $user->status->name ?? 'N/A' }}
                                                </span>
                                            @endif
                                        </td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            @if($user->gender == 'Masculino')
                                                <i class="fas fa-mars me-2"></i>
                                            @elseif($user->gender == 'Femenino')
                                                <i class="fas fa-venus me-2"></i>
                                            @else
                                                <i class="fas fa-genderless me-2"></i>
                                            @endif
                                            {{ $user->gender }}
                                        </td>
                                        <td style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                            <i class="fas fa-calendar-day me-2"></i>
                                            {{ \Carbon\Carbon::parse($user->birth_date)->translatedFormat('d/m/Y') }}
                                        </td>
                                        @if($roleFilter == '3')
                                            <td class="wrap-text" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                                <i class="fas fa-certificate me-2"></i>{{ $user->specialty ?? 'N/A' }}
                                            </td>
                                            <td class="wrap-text" style="font-size: 1.4rem; color: #1A365D; font-weight: 500;">
                                                <i class="fas fa-award me-2"></i>{{ $user->certification ?? 'N/A' }}
                                            </td>
                                        @endif
                                        <td class="pe-4 text-center" style="min-width: 150px;">
                                            <div class="d-flex justify-content-center" style="gap: 5px;">
                                                <a href="{{ route('admin.users.edit', ['user' => $user, 'redirect_filter' => request('roleFilter')]) }}" 
                                                    class="btn py-2 px-3" 
                                                    style="background-color: #2EC4B6; color: #FFFFFF; font-size: 1.3rem; font-weight: 500; white-space: nowrap;">
                                                    <i class="fas fa-edit me-1"></i>EDITAR
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="{{ $roleFilter == '3' ? 10 : 8 }}" class="text-center py-4">
                                            <div class="text-muted">
                                                <i class="fas fa-users-slash fs-1" style="color: #1A365D; font-size: 3rem;"></i>
                                                <p class="mt-2 fs-5" style="font-size: 1.4rem; font-weight: 600;">
                                                    @if(request('search') || request('roleFilter') || request('statusFilter') || request('specialtyFilter') || request('certificationFilter'))
                                                        No se encontraron usuarios con los filtros aplicados
                                                    @else
                                                        No hay usuarios registrados
                                                    @endif
                                                </p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>

                        <div class="card-footer py-4" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="text-muted" style="font-size: 1.3rem; font-weight: 500;">
                                    <i class="fas fa-clipboard-list me-2"></i> 
                                    MOSTRANDO <span class="fw-bold">{{ $users->count() }}</span> DE 
                                    <span class="fw-bold">{{ $users->total() }}</span> USUARIOS REGISTRADOS
                                </div>
                                <div style="font-size: 1.3rem; font-weight: 500;">
                                    <i class="fas fa-calendar-alt me-2"></i>
                                    {{ now()->translatedFormat('l, d \d\e F \d\e Y') }}
                                </div>
                            </div>
                        </div>

                        @if($users->hasPages())
                            <div class="card-footer py-4" style="background-color: #F4F4F4; border-top: 2px solid #1A365D;">
                                <div class="d-flex justify-content-center">
                                    {{ $users->appends(request()->query())->links('pagination::bootstrap-4') }}
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<style>
    body {
        font-size: 1.2rem;
    }
    
    .card {
        border-radius: 10px;
        overflow: hidden;
    }
    
    .table th {
        padding: 12px 8px;
        text-transform: uppercase;
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
        background-color: rgba(46, 196, 182, 0.2) !important;
        transform: translateY(-1px);
    }
    
    .alert {
        border-radius: 6px;
    }

    .btn-eliminar {
        background-color: #FF6B35 !important;
        color: #FFFFFF !important;
        font-size: 1.3rem !important;
        font-weight: 500 !important;
        min-width: 100px !important;
        border: none !important;
        transition: all 0.3s ease !important;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
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

    .pagination .page-item.active .page-link {
        background-color: #1A365D;
        border-color: #1A365D;
        font-size: 1.1rem;
        padding: 0.5rem 0.9rem;
    }

    .pagination .page-link {
        color: #1A365D;
        font-size: 1.1rem;
        padding: 0.5rem 0.9rem;
    }

    .badge {
        padding: 0.5em 0.9em;
        font-size: 1.1rem;
        font-weight: 600;
    }
    
    .input-container {
        position: relative;
        width: 100%;
    }

    .input {
        width: 100%;
        height: 45px;
        padding: 12px 12px 12px 40px;
        font-size: 18px;
        font-family: "Courier New", monospace;
        color: #1A365D;
        background-color: #2EC4B6;
        border: 4px solid #1A365D;
        border-radius: 0;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 8px 8px 0 #FF6B35;
    }

    .input::placeholder {
        color: rgba(26, 54, 93, 0.6);
    }

    .input:hover {
        transform: translate(-4px, -4px);
        box-shadow: 12px 12px 0 #FF6B35;
    }

    .input:focus {
        background-color: #1A365D;
        color: #fff;
        border-color: #FF6B35;
        animation: shake 0.5s ease-in-out;
    }

    .input:focus::placeholder {
        color: #fff;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #1A365D;
        font-size: 1.2rem;
    }

    /* Estilos para el select circular mejorado */
    .circle-select-container {
        position: relative;
        width: 100%;
        height: 45px;
    }

    .circle-select {
        width: 100%;
        height: 100%;
        padding: 0 15px; 
        padding-right: 40px;
        font-size: 1rem;
        font-weight: 600;
        color: #1A365D;
        background-color: #F4F4F4;
        border: 3px solid #1A365D;
        border-radius: 50px;
        appearance: none;
        -webkit-appearance: none;
        -moz-appearance: none;
        cursor: pointer;
        outline: none;
        transition: all 0.3s ease;
        box-shadow: 0 4px 8px rgba(26, 54, 93, 0.1);
    }

    .circle-select:hover {
        border-color: #FF6B35;
        box-shadow: 0 6px 12px rgba(255, 107, 53, 0.15);
    }

    .circle-select:focus {
        border-color: #2EC4B6;
        box-shadow: 0 0 0 3px rgba(46, 196, 182, 0.3);
    }

    .select-icon {
        position: absolute;
        top: 50%;
        right: 15px;
        transform: translateY(-50%);
        pointer-events: none;
        color: #1A365D;
        font-size: 1.1rem;
        transition: all 0.3s ease;
    }

    .circle-select:hover ~ .select-icon {
        color: #FF6B35;
        transform: translateY(-50%) scale(1.1);
    }

    .circle-select:focus ~ .select-icon {
        color: #2EC4B6;
    }

    /* Estilo para las opciones */
    .circle-select option {
        padding: 10px;
        font-size: 1.1rem;
        background-color: #F4F4F4;
        color: #1A365D;
    }

    .circle-select option:hover {
        background-color: #2EC4B6 !important;
        color: #FFFFFF;
    }

    /* Animación de cursor parpadeante */
    .input-container::after {
        content: "|";
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #1A365D;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .input:focus + .input-container::after,
    .input:not(:placeholder-shown) + .input-container::after {
        opacity: 1;
        animation: blink 0.7s step-end infinite;
    }

    @keyframes blink {
        50% {
            opacity: 0;
        }
    }

    /* Animación de glitch cuando hay texto */
    .input:not(:placeholder-shown) {
        animation: glitch 1s linear infinite;
        font-weight: bold;
        letter-spacing: 1px;
    }

    @keyframes glitch {
        0% {
            transform: none;
            opacity: 1;
        }
        7% {
            transform: skew(-0.5deg, -0.9deg);
            opacity: 0.75;
        }
        10% {
            transform: none;
            opacity: 1;
        }
        27% {
            transform: none;
            opacity: 1;
        }
        30% {
            transform: skew(0.8deg, -0.1deg);
            opacity: 0.75;
        }
        35% {
            transform: none;
            opacity: 1;
        }
        52% {
            transform: none;
            opacity: 1;
        }
        55% {
            transform: skew(-1deg, 0.2deg);
            opacity: 0.75;
        }
        50% {
            transform: none;
            opacity: 1;
        }
        72% {
            transform: none;
            opacity: 1;
        }
        75% {
            transform: skew(0.4deg, 1deg);
            opacity: 0.75;
        }
        80% {
            transform: none;
            opacity: 1;
        }
        100% {
            transform: none;
            opacity: 1;
        }
    }

    /* Animación de shake al enfocar */
    @keyframes shake {
        0% {
            transform: translateX(0);
        }
        25% {
            transform: translateX(-5px) rotate(-5deg);
        }
        50% {
            transform: translateX(5px) rotate(5deg);
        }
        75% {
            transform: translateX(-5px) rotate(-5deg);
        }
        100% {
            transform: translateX(0);
        }
    }

    /* Animación de typing (opcional, para cuando se valida el input) */
    @keyframes typing {
        from {
            width: 0;
        }
        to {
            width: 100%;
        }
    }

    .input:valid {
        animation: typing 2s steps(30, end);
    }

    .wrap-text {
        white-space: normal;
        word-break: break-word;
        max-width: 200px;
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
        
        .card-footer div {
            font-size: 1.0rem !important;
        }
        
        .wrap-text {
            max-width: 150px;
        }
        
        .table td:last-child {
            min-width: 120px;
        }
        
        .circle-select-container {
            height: 40px;
        }
        
        .circle-select {
            font-size: 1.1rem;
            padding: 0 15px;
            padding-right: 35px;
        }
        
        .select-icon {
            right: 12px;
            font-size: 1rem;
        }
    }

    /* Ajustes específicos para móviles pequeños */
    @media (max-width: 768px) {
        .card-header {
            padding: 1rem !important;
        }
        
        .card-header h2 {
            font-size: 1.4rem !important;
            margin-bottom: 1rem !important;
        }
        
        .input-container {
            max-width: 100% !important;
        }
        
        .input {
            font-size: 1rem !important;
            padding: 0.5rem 0.5rem 0.5rem 35px !important;
            height: 40px !important;
        }
        
        .input-icon {
            left: 10px;
            font-size: 1rem;
        }
        
        .btn {
            padding: 0.4rem 0.8rem !important;
            font-size: 0.9rem !important;
            min-width: auto !important;
        }
        
        .circle-select-container {
            height: 40px !important;
        }
        
        .circle-select {
            font-size: 0.9rem !important;
            padding: 0 15px !important;
            padding-right: 35px !important;
        }
        
        .card-footer div {
            flex-direction: column !important;
            gap: 0.5rem !important;
            text-align: center !important;
            font-size: 0.9rem !important;
        }
        
        .table th, .table td {
            font-size: 0.8rem !important;
            padding: 8px 4px !important;
        }
        
        .wrap-text {
            max-width: 100px !important;
        }
    }
</style>

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    // Función para confirmación de eliminación
    function confirmarEliminacion(event) {
        event.preventDefault();
        const form = event.target.closest('form');
        
        Swal.fire({
            title: '¿Eliminar Usuario?',
            html: `<div style="text-align: center;">
                    <i class="fas fa-exclamation-triangle" style="color: #FF6B35; font-size: 3rem; margin-bottom: 1rem;"></i>
                    <p>¿Está seguro que desea eliminar este usuario permanentemente?</p>
                    <p style="font-weight: 600;">Esta acción no se puede deshacer.</p>
                </div>`,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: '<i class="fas fa-trash-alt me-2"></i> Eliminar',
            cancelButtonText: '<i class="fas fa-times me-2"></i> Cancelar',
            buttonsStyling: false,
            customClass: {
                confirmButton: 'btn btn-eliminar',
                cancelButton: 'btn'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    }

    // Auto-dismiss alert after 3 seconds
    document.addEventListener('DOMContentLoaded', function() {
        const alerts = document.querySelectorAll('.alert.alert-dismissible');
        if (alerts) {
            alerts.forEach(alert => {
                setTimeout(function() {
                    const bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                }, 3000); // 3000 milisegundos = 3 segundos
            });
        }
    });
</script>
@endsection
@endsection