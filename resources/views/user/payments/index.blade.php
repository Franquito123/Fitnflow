@extends('layouts.app-master')
@section('content')
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

<div class="container-fluid py-4">
    <!-- Welcome Message -->
    <div class="mb-4 text-center p-4 rounded-3 welcome-container">
        <i class="fas fa-file-invoice-dollar fa-5x mb-3 wallet-icon"></i>
        <h2 class="welcome-title">
            <i class="fas fa-hand-holding-usd me-2"></i>¡Bienvenido a tu Historial de Pagos!
        </h2>
        <p class="welcome-subtitle">
            <i class="fas fa-search-dollar me-2"></i>Revisa el estado de tus transacciones y membresías
        </p>
    </div>

    <!-- Header and Filter -->
    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap">
        <h2 class="section-title">
            <i class="fas fa-money-check-alt me-2"></i>Mis Pagos
        </h2>
        
        <div class="filter-container">
            <div class="dropdown">
                <button class="btn dropdown-toggle filter-dropdown" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                    <i class="fas fa-sliders-h me-2"></i>Filtrar por estado
                </button>
                <ul class="dropdown-menu" aria-labelledby="filterDropdown">
                    <li><a class="dropdown-item filter-option active" href="#" data-filter="all"><i class="fas fa-list-ol me-2"></i>Todos los pagos</a></li>
                    <li><hr class="dropdown-divider"></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="pending"><i class="fas fa-hourglass-half me-2"></i>Pendientes</a></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="approved"><i class="fas fa-check-double me-2"></i>Aprobados</a></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="rejected"><i class="fas fa-ban me-2"></i>Rechazados</a></li>
                    <li><a class="dropdown-item filter-option" href="#" data-filter="expired"><i class="fas fa-clock me-2"></i>Vencidos</a></li>
                </ul>
            </div>
        </div>
    </div>

    <!-- Tables Container -->
    <div class="card payment-card">
        <!-- All Payments Table -->
        <div id="table-all">
            <div class="card-header payment-card-header">
                <h5 class="mb-0"><i class="fas fa-table me-2"></i>Todos mis Pagos</h5>
            </div>
            <div class="card-body p-0">
                @if($allPayments->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 payment-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-2"></i>Membresía</th>
                                <th><i class="far fa-calendar-alt me-2"></i>Fecha de Pago</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                                <th><i class="fas fa-ellipsis-h me-2"></i>Detalles</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($allPayments as $payment)
                            <tr class="payment-row" data-status="{{ strtolower(str_replace(' ', '_', $payment->status->name)) }}">
                                <td><i class="fas fa-cut me-2"></i>{{ $payment->membership->name ?? 'No disponible' }}</td>
                                <td><i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td><i class="fas fa-money-bill-wave me-2"></i>${{ number_format($payment->price, 2) }}</td>
                                <td>
                                    @if($payment->status->name == 'Pendiente de revisión')
                                        <span class="status-badge pendiente"><i class="fas fa-hourglass-half me-1"></i>Pendiente</span>
                                    @elseif($payment->status->name == 'Aprobado')
                                        <span class="status-badge aprobado"><i class="fas fa-check-circle me-1"></i>Aprobado</span>
                                    @elseif($payment->status->name == 'Rechazado')
                                        <span class="status-badge rechazado"><i class="fas fa-times-circle me-1"></i>Rechazado</span>
                                    @elseif($payment->status->name == 'Vencido')
                                        <span class="status-badge vencido"><i class="fas fa-exclamation-triangle me-1"></i>Vencido</span>
                                    @endif
                                </td>
                                <td>
                                    <button class="btn btn-sm details-btn" data-payment-id="{{ $payment->id }}">
                                        <i class="fas fa-search-plus me-1"></i> Ver más
                                    </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3 py-2 d-flex justify-content-center">
                    {{ $allPayments->links() }}
                </div>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-wallet fa-3x mb-3 text-muted"></i>
                    <p>No hay registros de pagos.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Pending Payments Table -->
        <div id="table-pending" style="display: none;">
            <div class="card-header payment-card-header">
                <h5 class="mb-0"><i class="fas fa-hourglass me-2"></i>Pagos Pendientes</h5>
            </div>
            <div class="card-body p-0">
                @if($paymentsPending->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 payment-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-2"></i>Membresía</th>
                                <th><i class="far fa-calendar-alt me-2"></i>Fecha de Pago</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsPending as $payment)
                            <tr>
                                <td><i class="fas fa-cut me-2"></i>{{ $payment->membership->name ?? 'No disponible' }}</td>
                                <td><i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td><i class="fas fa-money-bill-wave me-2"></i>${{ number_format($payment->price, 2) }}</td>
                                <td>
                                    <span class="status-badge pendiente"><i class="fas fa-hourglass-half me-1"></i>Pendiente de revisión</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3 py-2 d-flex justify-content-center">
                    {{ $paymentsPending->links() }}
                </div>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-check-circle fa-3x mb-3 text-muted"></i>
                    <p>No hay pagos pendientes.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Approved Payments Table -->
        <div id="table-approved" style="display: none;">
            <div class="card-header payment-card-header">
                <h5 class="mb-0"><i class="fas fa-check-double me-2"></i>Pagos Aprobados</h5>
            </div>
            <div class="card-body p-0">
                @if($paymentsApproved->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 payment-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-2"></i>Membresía</th>
                                <th><i class="far fa-calendar-alt me-2"></i>Fecha de Pago</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                <th><i class="fas fa-calendar-check me-2"></i>Fecha de Aprobación</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsApproved as $payment)
                            <tr>
                                <td><i class="fas fa-cut me-2"></i>{{ $payment->membership->name ?? 'No disponible' }}</td>
                                <td><i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td><i class="fas fa-money-bill-wave me-2"></i>${{ number_format($payment->price, 2) }}</td>
                                <td><i class="far fa-calendar-check me-2"></i>{{ $payment->updated_at->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td>
                                    <span class="status-badge aprobado"><i class="fas fa-check-circle me-1"></i>Aprobado</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3 py-2 d-flex justify-content-center">
                    {{ $paymentsApproved->links() }}
                </div>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-search-dollar fa-3x mb-3 text-muted"></i>
                    <p>No hay pagos aprobados.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Rejected Payments Table -->
        <div id="table-rejected" style="display: none;">
            <div class="card-header payment-card-header">
                <h5 class="mb-0"><i class="fas fa-times-circle me-2"></i>Pagos Rechazados</h5>
            </div>
            <div class="card-body p-0">
                @if($paymentsRejected->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 payment-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-2"></i>Membresía</th>
                                <th><i class="far fa-calendar-alt me-2"></i>Fecha de Pago</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                <th><i class="fas fa-comment-dots me-2"></i>Motivo de Rechazo</th>
                                <th><i class="fas fa-calendar-times me-2"></i>Fecha de Rechazo</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsRejected as $payment)
                            <tr>
                                <td><i class="fas fa-cut me-2"></i>{{ $payment->membership->name ?? 'No disponible' }}</td>
                                <td><i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td><i class="fas fa-money-bill-wave me-2"></i>${{ number_format($payment->price, 2) }}</td>
                                <td><i class="fas fa-comment me-2"></i>{{ $payment->comment ?? 'No especificado' }}</td>
                                <td><i class="far fa-calendar-times me-2"></i>{{ $payment->updated_at->translatedFormat('d \d\e F \d\e Y')}}</td>
                                <td>
                                    <span class="status-badge rechazado"><i class="fas fa-ban me-1"></i>Rechazado</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3 py-2 d-flex justify-content-center">
                    {{ $paymentsRejected->links() }}
                </div>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-thumbs-up fa-3x mb-3 text-muted"></i>
                    <p>No hay pagos rechazados.</p>
                </div>
                @endif
            </div>
        </div>

        <!-- Expired Payments Table -->
        <div id="table-expired" style="display: none;">
            <div class="card-header payment-card-header">
                <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Pagos Vencidos</h5>
            </div>
            <div class="card-body p-0">
                @if($paymentsExpired->count() > 0)
                <div class="table-responsive">
                    <table class="table align-middle mb-0 payment-table">
                        <thead>
                            <tr>
                                <th><i class="fas fa-id-card me-2"></i>Membresía</th>
                                <th><i class="far fa-calendar-alt me-2"></i>Fecha de Pago</th>
                                <th><i class="fas fa-dollar-sign me-2"></i>Monto</th>
                                <th><i class="fas fa-hourglass-end me-2"></i>Fecha de Vencimiento</th>
                                <th><i class="fas fa-info-circle me-2"></i>Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($paymentsExpired as $payment)
                            <tr>
                                <td><i class="fas fa-cut me-2"></i>{{ $payment->membership->name ?? 'No disponible' }}</td>
                                <td><i class="far fa-clock me-2"></i>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y')}}</td>
                                <td><i class="fas fa-money-bill-wave me-2"></i>${{ number_format($payment->price, 2) }}</td>
                                <td><i class="fas fa-hourglass-end me-2"></i>{{ \Carbon\Carbon::parse($payment->expiration_date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                                <td>
                                    <span class="status-badge vencido"><i class="fas fa-exclamation-triangle me-1"></i>Vencido</span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="mt-3 px-3 py-2 d-flex justify-content-center">
                    {{ $paymentsExpired->links() }}
                </div>
                @else
                <div class="text-center p-4">
                    <i class="fas fa-check-circle fa-3x mb-3 text-muted"></i>
                    <p>No hay pagos vencidos.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
</div>


<div class="modal fade" id="paymentDetailsModal" tabindex="-1" aria-labelledby="paymentDetailsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content border-0 shadow-lg">
            <div class="modal-header" style="background-color: #1A365D; border-bottom: 3px solid #FF6B35;">
                <h5 class="modal-title text-white" id="paymentDetailsModalLabel">
                    <i class="fas fa-file-invoice-dollar me-2"></i>Detalles del Pago
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body p-4" id="paymentDetailsContent" style="background-color: #f8f9fa;">
                <div class="text-center py-4">
                    <i class="fas fa-spinner fa-spin fa-3x mb-3" style="color: #1A365D;"></i>
                    <p style="color: #1A365D; opacity: 0.8;">Cargando detalles del pago...</p>
                </div>
            </div>
            <div class="modal-footer" style="background-color: #f8f9fa; border-top: 1px solid #e9ecef;">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal" style="background-color: #1A365D; border: none;">
                    <i class="fas fa-times me-1"></i>Cerrar
                </button>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    // Filter functionality remains unchanged
    const filterOptions = document.querySelectorAll('.filter-option');
    
    function setActiveFilter(selectedFilter) {
        filterOptions.forEach(option => {
            option.classList.remove('active');
            if(option.dataset.filter === selectedFilter) {
                option.classList.add('active');
            }
        });
        
        const dropdownBtn = document.getElementById('filterDropdown');
        const activeOption = document.querySelector('.filter-option.active');
        dropdownBtn.innerHTML = `<i class="fas fa-filter me-2"></i>${activeOption.textContent.trim()}`;
    }
    
    function showTable(tableToShow) {
        document.querySelectorAll('#table-all, #table-pending, #table-approved, #table-rejected, #table-expired').forEach(table => {
            table.style.display = 'none';
        });
        
        if(tableToShow) {
            document.getElementById(tableToShow).style.display = '';
        }
    }
    
    filterOptions.forEach(option => {
        option.addEventListener('click', function(e) {
            e.preventDefault();
            const filterValue = this.dataset.filter;
            
            setActiveFilter(filterValue);
            
            if(filterValue === 'all') {
                showTable('table-all');
            } else {
                showTable(`table-${filterValue}`);
            }
        });
    });
    
    setActiveFilter('all');
    
    // Enhanced Payment Details Modal
    const paymentModal = new bootstrap.Modal(document.getElementById('paymentDetailsModal'));

    document.addEventListener('click', async function(e) {
        if (e.target.closest('.details-btn')) {
            const button = e.target.closest('.details-btn');
            const paymentId = button.getAttribute('data-payment-id');
            const modalContent = document.getElementById('paymentDetailsContent');
            
            try {
                // Show loader
                modalContent.innerHTML = `
                    <div class="text-center py-4">
                        <i class="fas fa-spinner fa-spin fa-3x mb-3" style="color: #1A365D;"></i>
                        <p style="color: #1A365D; opacity: 0.8;">Cargando detalles del pago...</p>
                    </div>
                `;
                
                paymentModal.show();
                
                const response = await fetch(`/user/payments/${paymentId}`);
                
                if (!response.ok) throw new Error('Error al cargar los datos');
                
                const data = await response.json();
                if (!data.success) throw new Error(data.message || 'Error en los datos recibidos');
                
                // Enhanced payment details layout
                modalContent.innerHTML = `
                    <div class="payment-details-container">
                        <div class="row gx-3 gy-3">
                            <!-- Left Column - Payment Information -->
                            <div class="col-md-6">
                                <div class="detail-card h-100 p-4 rounded-3" style="background-color: white; border-left: 4px solid #1A365D;">
                                    <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1A365D; font-size: 1.1rem;">
                                        <i class="fas fa-info-circle me-2 fs-5"></i>
                                        Información del Pago
                                    </h6>
                                    <div class="detail-grid">
                                        <div class="detail-item mb-3">
                                            <div class="detail-label fw-semibold small text-muted mb-1">ID de Transacción</div>
                                            <div class="detail-value fw-bold" style="color: #1A365D; font-size: 1rem;">${data.data.transaction_id}</div>
                                        </div>
                                        <div class="detail-item mb-3">
                                            <div class="detail-label fw-semibold small text-muted mb-1">Membresía</div>
                                            <div class="detail-value" style="color: #1A365D; font-size: 1rem;">${data.data.membership}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label fw-semibold small text-muted mb-1">Monto</div>
                                            <div class="detail-value fw-bold" style="color: #2a9d8f; font-size: 1.2rem;">${data.data.amount}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Right Column - Dates and Status -->
                            <div class="col-md-6">
                                <div class="detail-card h-100 p-4 rounded-3" style="background-color: white; border-left: 4px solid #2EC4B6;">
                                    <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1A365D; font-size: 1.1rem;">
                                        <i class="fas fa-clock me-2 fs-5" style="color: #2EC4B6;"></i>
                                        Fechas y Estado
                                    </h6>
                                    <div class="detail-grid">
                                        <div class="detail-item mb-3">
                                            <div class="detail-label fw-semibold small text-muted mb-1">Fecha de Pago</div>
                                            <div class="detail-value" style="color: #1A365D; font-size: 1rem;">${data.data.payment_date}</div>
                                        </div>
                                        <div class="detail-item mb-3">
                                            <div class="detail-label fw-semibold small text-muted mb-1">Procesado</div>
                                            <div class="detail-value" style="color: #1A365D; font-size: 1rem;">${data.data.processed_date}</div>
                                        </div>
                                        <div class="detail-item">
                                            <div class="detail-label fw-semibold small text-muted mb-1">Estado</div>
                                            <div class="detail-value">
                                                <span class="badge ${data.data.status_class} p-2 px-3 rounded-pill">${data.data.status}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Comments Section - Improved with better spacing -->
                        ${data.data.comment ? `
                        <div class="mt-4">
                            <div class="detail-card p-4 rounded-3" style="background-color: white; border-left: 4px solid #FF6B35;">
                                <h6 class="fw-bold mb-3 d-flex align-items-center" style="color: #1A365D; font-size: 1.1rem;">
                                    <i class="fas fa-comment me-2 fs-5" style="color: #FF6B35;"></i>
                                    Comentarios
                                </h6>
                                <div class="p-3 bg-light rounded-2" style="max-height: 150px; overflow-y: auto;">
                                    <p class="mb-0" style="white-space: pre-wrap; color: #495057; font-size: 0.95rem; line-height: 1.5;">${data.data.comment}</p>
                                </div>
                            </div>
                        </div>
                        ` : ''}
                    </div>
                `;
                
            } catch (error) {
                console.error('Error:', error);
                modalContent.innerHTML = `
                    <div class="alert alert-danger border-0" style="background-color: rgba(255, 107, 53, 0.1); border-left: 4px solid #FF6B35;">
                        <i class="fas fa-exclamation-triangle me-2" style="color: #d82c0d;"></i>
                        <span style="color: #d82c0d;">Error al cargar los detalles: ${error.message}</span>
                    </div>
                `;
            }
        }
    });
});
</script>

<style>
   /* Enhanced Detail Card Styles */
    .detail-card {
        transition: all 0.3s ease;
        box-shadow: 0 2px 12px rgba(0, 0, 0, 0.05);
        height: 100%;
    }
    
    .detail-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 16px rgba(0, 0, 0, 0.1);
    }
    
    .payment-details-container {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .detail-grid {
        display: flex;
        flex-direction: column;
        gap: 1.5rem;
    }
    
    .detail-item {
        display: flex;
        flex-direction: column;
    }
    
    .detail-label {
        font-size: 0.85rem;
        letter-spacing: 0.3px;
        opacity: 0.8;
    }
    
    /* Custom Scrollbar for Comments */
    .detail-card ::-webkit-scrollbar {
        width: 6px;
    }
    
    .detail-card ::-webkit-scrollbar-thumb {
        background-color: rgba(0, 0, 0, 0.15);
        border-radius: 4px;
    }
    
    .detail-card ::-webkit-scrollbar-track {
        background-color: rgba(0, 0, 0, 0.05);
        border-radius: 4px;
    }
    
    /* Responsive Adjustments */
    @media (max-width: 768px) {
        .detail-grid {
            gap: 1rem;
        }
        
        .detail-card {
            padding: 1.5rem !important;
        }
    }  border-radius: 3px;
    
    /* Base Styles */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
        color: #333;
    }
    
    /* Welcome Section */
    .welcome-container {
        background: linear-gradient(135deg, #1A365D 0%, #2a528a 100%);
        color: white;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }
    
    .wallet-icon {
        color: #FFD166;
    }
    
    .welcome-title {
        font-size: 2rem;
        margin-bottom: 0.5rem;
        font-weight: 700;
    }
    
    .welcome-subtitle {
        font-size: 1.4rem;
        opacity: 0.9;
        margin-bottom: 0;
        color: #2EC4B6;
    }
    
    /* Section Title */
    .section-title {
        font-size: 1.6rem;
        color: #1A365D;
        font-weight: 700;
        margin: 0;
    }
    
    /* Filter Dropdown */
    .filter-container {
        margin: 0.5rem 0;
    }
    
    .filter-dropdown {
        background-color: #1A365D;
        color: white;
        border: none;
        padding: 0.6rem 1.2rem;
        border-radius: 8px;
        font-weight: 500;
        transition: all 0.2s ease;
    }
    
    .filter-dropdown:hover {
        background-color: #2a528a;
        transform: translateY(-1px);
    }
    
    .filter-dropdown:active, .filter-dropdown:focus {
        background-color: #1A365D;
    }
    
    .dropdown-menu {
        border-radius: 8px;
        border: 1px solid rgba(0, 0, 0, 0.1);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }
    
    .dropdown-item {
        padding: 0.5rem 1rem;
        font-size: 1rem;
        transition: all 0.2s ease;
    }
    
    .dropdown-item:hover {
        background-color: #f8f9fa;
    }
    
    .dropdown-item.active {
        background-color: #e9ecef;
        color: #1A365D;
        font-weight: 500;
    }
    
    /* Payment Card */
    .payment-card {
        border: none;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.08);
        overflow: hidden;
        margin-bottom: 25rem;
    }
    
    .payment-card-header {
        background-color: #1A365D;
        color: white;
        padding: 1rem 1.5rem;
        border-bottom: none;
    }
    
    .payment-card-header h5 {
        margin: 0;
        font-weight: 600;
        display: flex;
        align-items: center;
    }
    
    /* Status Badges */
    .status-badge {
        display: inline-block;
        padding: 0.35rem 0.8rem;
        border-radius: 20px;
        font-weight: 500;
        font-size: 0.85rem;
        white-space: nowrap;
    }
    
    .pendiente {
        background-color: rgba(255, 209, 102, 0.2);
        color: #d4a017;
    }
    
    .aprobado {
        background-color: rgba(46, 196, 182, 0.2);
        color: #2EC4B6;
    }
    
    .rechazado {
        background-color: rgba(255, 107, 53, 0.2);
        color: #FF6B35;
    }
    
    .vencido {
        background-color: rgba(216, 44, 13, 0.2);
        color: #d82c0d;
    }
    
    /* Tables */
    .payment-table {
        border-collapse: separate;
        border-spacing: 0;
        width: 100%;
    }
    
    .payment-table th {
        background-color: #f8f9fa;
        color: #495057;
        font-weight: 600;
        padding: 1rem 1.5rem;
        border-bottom: 2px solid #e9ecef;
        position: sticky;
        top: 0;
    }
    
    .payment-table td {
        padding: 1rem 1.5rem;
        border-bottom: 1px solid #e9ecef;
        vertical-align: middle;
    }
    
    .payment-table tbody tr:last-child td {
        border-bottom: none;
    }
    
    .payment-table tbody tr:hover {
        background-color: #f8f9fa;
    }
    
    /* Details Button */
    .details-btn {
        background-color: transparent;
        color: #1A365D;
        border: 1px solid #1A365D;
        border-radius: 6px;
        padding: 0.25rem 0.75rem;
        transition: all 0.2s ease;
    }
    
    .details-btn:hover {
        background-color: #1A365D;
        color: white;
    }
    
    /* Rejection Reason */
    .rejection-reason {
        max-width: 200px;
        white-space: pre-wrap;
        word-wrap: break-word;
    }
    
    /* Pagination Styles */
    .pagination {
        display: flex;
        padding-left: 0;
        list-style: none;
        border-radius: 0.375rem;
    }
    
    .page-item.active .page-link {
        background-color: #1A365D;
        border-color: #1A365D;
    }
    
    .page-link {
        color: #1A365D;
        padding: 0.375rem 0.75rem;
        margin-left: -1px;
        line-height: 1.25;
        border: 1px solid #dee2e6;
    }
    
    .page-link:hover {
        color: #0a2540;
        background-color: #e9ecef;
        border-color: #dee2e6;
    }
    
    /* Payment Details Modal */
    .payment-details {
        display: grid;
        grid-template-columns: 1fr 2fr;
        gap: 1rem;
    }
    
    .detail-item {
        display: contents;
    }
    
    .detail-label {
        font-weight: 600;
        color: #495057;
    }
    
    .detail-value {
        color: #212529;
    }
    
    /* Responsive Design */
    @media (max-width: 992px) {
        .welcome-title {
            font-size: 1.8rem;
        }
        
        .welcome-subtitle {
            font-size: 1.2rem;
        }
        
        .section-title {
            font-size: 1.4rem;
        }
    }
    
    @media (max-width: 768px) {
        .payment-details {
            grid-template-columns: 1fr;
            gap: 0.5rem;
        }
        
        .detail-item {
            display: flex;
            flex-direction: column;
            margin-bottom: 0.75rem;
        }
        
        .payment-table th, 
        .payment-table td {
            padding: 0.75rem;
        }
    }
    
    @media (max-width: 576px) {
        .welcome-title {
            font-size: 1.5rem;
        }
        
        .welcome-subtitle {
            font-size: 1.1rem;
        }
        
        .section-title {
            font-size: 1.3rem;
            margin-bottom: 0.5rem;
        }
        
        .filter-container {
            width: 100%;
        }
        
        .filter-dropdown {
            width: 100%;
            text-align: left;
        }
        
        .payment-table {
            display: block;
            overflow-x: auto;
        }
        
    }
</style>
@endsection