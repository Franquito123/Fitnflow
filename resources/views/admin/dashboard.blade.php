@extends('layouts.admi-app-master')

@section('content')
<div class="container-fluid px-4">
    <!-- Nuevo Encabezado Mejorado -->
    <div class="container-fluid px-4 mt-4">
        <div class="row justify-content-center">
            <div class="col-md-12">
                <div class="card border-0 shadow-lg">
                    <div class="card-body p-5">
                        <div class="welcome-content text-center">
                            <div class="welcome-header mb-5">
                                <h1 class="display-3 fw-bold text-primary-dark mb-4">PANEL DE ADMINISTRACIÓN <span class="text-gradient">FITNFLOW</span></h1>
                                <p class="fs-3 text-primary-dark opacity-75">Desde este panel podrás administrar todas las operaciones de tu centro fitness de manera eficiente y profesional.</p>
                                <div class="divider mx-auto my-4" style="width: 150px; height: 4px; background: linear-gradient(90deg, #1A365D 0%, #FF6B35 100%);"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>

    <!-- Header Mejorado -->
    <div class="d-sm-flex align-items-center justify-content-between mb-5">
        <div class="d-flex align-items-center">
            <i class="fas fa-tachometer-alt fa-3x text-primary me-4" style="color: #1A365D;"></i>
            <h1 class="h1 mb-0 text-gray-900 fw-bold" style="font-size: 2.5rem;"></h1>
        </div>
        <div class="d-none d-sm-inline-block">
            <span class="badge text-white p-4 fs-5" style="background-color: #2EC4B6;">
                <i class="fas fa-calendar-day me-3 fs-4"></i>
                {{ now()->translatedFormat('l, d F Y') }}
            </span>
        </div>
    </div>

    <!-- Métricas Rápidas - Mejoradas visualmente -->
    <div class="row mb-5">
        <!-- Tarjeta de Ingresos -->
        <div class="col-xl-3 col-md-6 mb-5">
            <div class="card border-start-primary border-start-4 shadow-lg h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-3">
                            <div class="fs-4 fw-bold text-uppercase mb-3" style="color: #1A365D;">
                                <i class="fas fa-money-bill-wave me-3 fs-4"></i>Ingresos (30 días)
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-900" style="font-size: 2.2rem;">
                                ${{ number_format($revenueLast30Days, 2) }}
                            </div>
                            <div class="mt-3 text-success fs-5">
                                <i class="fas fa-arrow-up me-2"></i> 12% vs mes anterior
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-dollar-sign fa-4x opacity-25" style="color: #1A365D;"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Pagos Aprobados -->
        <div class="col-xl-3 col-md-6 mb-5">
            <div class="card border-start-success border-start-4 shadow-lg h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-3">
                            <div class="fs-4 fw-bold text-success text-uppercase mb-3">
                                <i class="fas fa-check-circle me-3 fs-4"></i>Pagos Aprobados
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-900" style="font-size: 2.2rem;">
                                {{ $paymentStatuses['approved'] }}
                            </div>
                            <div class="mt-3 text-muted fs-5">
                                <i class="fas fa-percentage me-2"></i> {{ round(($paymentStatuses['approved']/$paymentStatuses['total'])*100) }}% del total
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-thumbs-up fa-4x text-success opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Pagos Pendientes -->
        <div class="col-xl-3 col-md-6 mb-5">
            <div class="card border-start-warning border-start-4 shadow-lg h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-3">
                            <div class="fs-4 fw-bold text-warning text-uppercase mb-3">
                                <i class="fas fa-clock me-3 fs-4"></i>Pagos Pendientes
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-900" style="font-size: 2.2rem;">
                                {{ $paymentStatuses['pending'] }}
                            </div>
                            <div class="mt-3 text-warning fs-5">
                                <i class="fas fa-exclamation-circle me-2"></i> Requieren atención
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-hourglass-half fa-4x text-warning opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Tarjeta de Pagos Totales -->
        <div class="col-xl-3 col-md-6 mb-5">
            <div class="card border-start-info border-start-4 shadow-lg h-100 py-3">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-3">
                            <div class="fs-4 fw-bold text-info text-uppercase mb-3">
                                <i class="fas fa-list-alt me-3 fs-4"></i>Total Transacciones
                            </div>
                            <div class="h2 mb-0 fw-bold text-gray-900" style="font-size: 2.2rem;">
                                {{ $paymentStatuses['total'] }}
                            </div>
                            <div class="mt-3 text-info fs-5">
                                <i class="fas fa-chart-line me-2"></i> Todas las transacciones
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-chart-pie fa-4x text-info opacity-25"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos - Mejorados visualmente -->
    <div class="row">
        <!-- Gráfico de Ingresos Mensuales -->
        <div class="col-xl-8 col-lg-7">
            <div class="card shadow-lg mb-5">
                <div class="card-header py-4 d-flex flex-row align-items-center justify-content-between text-white" style="background-color: #1A365D;">
                    <h3 class="m-0 fw-bold fs-2">
                        <i class="fas fa-chart-line me-3 fs-3"></i>Ingresos Mensuales
                    </h3>
                    <div class="dropdown no-arrow">
                        <a class="dropdown-toggle text-white fs-4" href="#" role="button" id="dropdownMenuLink" 
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <i class="fas fa-ellipsis-v"></i>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in" 
                             aria-labelledby="dropdownMenuLink">
                            <div class="dropdown-header fs-5">Opciones de visualización:</div>
                            <a class="dropdown-item fs-5" href="#" onclick="updateChart(6)">
                                <i class="fas fa-calendar-minus me-3"></i>Últimos 6 meses
                            </a>
                            <a class="dropdown-item fs-5" href="#" onclick="updateChart(12)">
                                <i class="fas fa-calendar-alt me-3"></i>Últimos 12 meses
                            </a>
                        </div>
                    </div>
                </div>
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="monthlyRevenueChart" height="350"></canvas>
                    </div>
                </div>
            </div>
        </div>

        <!-- Gráfico de Estado de Pagos -->
        <div class="col-xl-4 col-lg-5">
            <div class="card shadow-lg mb-5">
                <div class="card-header py-4 text-white" style="background-color: #1A365D;">
                    <h3 class="m-0 fw-bold fs-2">
                        <i class="fas fa-chart-pie me-3 fs-3"></i>Distribución de Pagos
                    </h3>
                </div>
                <div class="card-body">
                    <div class="chart-pie pt-5 pb-3">
                        <canvas id="paymentStatusChart" height="300"></canvas>
                    </div>
                    <div class="mt-5 text-center fs-5">
                        <span class="d-block d-sm-inline-block mb-3 mb-sm-0 mr-4">
                            <i class="fas fa-circle text-success me-2"></i> Aprobados
                        </span>
                        <span class="d-block d-sm-inline-block mb-3 mb-sm-0 mr-4">
                            <i class="fas fa-circle text-warning me-2"></i> Pendientes
                        </span>
                        <span class="d-block d-sm-inline-block mb-3 mb-sm-0 mr-4">
                            <i class="fas fa-circle text-danger me-2"></i> Rechazados
                        </span>
                        <span class="d-block d-sm-inline-block">
                            <i class="fas fa-circle text-secondary me-2"></i> Vencidos
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection



<style>
    /* Estilos adicionales para mejorar la visualización */
    .card {
        border-radius: 15px;
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 25px rgba(0,0,0,0.15) !important;
    }
    .card-header {
        border-radius: 12px 12px 0 0 !important;
    }
    .dropdown-item {
        transition: background-color 0.2s;
        padding: 12px 20px;
    }
    .dropdown-header {
        font-size: 1.1rem !important;
        padding-bottom: 10px;
    }
    
    /* Estilos para el nuevo encabezado */
    .text-primary-dark {
        color: #1A365D;
    }
    .text-gradient {
        background: linear-gradient(90deg, #1A365D 0%, #FF6B35 100%);
        -webkit-background-clip: text;
        -webkit-text-fill-color: transparent;
    }
    .divider {
        border-radius: 2px;
    }
    
    /* Ajustes para móviles */
    @media (max-width: 768px) {
        .fs-4 {
            font-size: 1.2rem !important;
        }
        .h2 {
            font-size: 1.8rem !important;
        }
        .fs-5 {
            font-size: 1.1rem !important;
        }
        .card-header h3 {
            font-size: 1.5rem !important;
        }
        .display-3 {
            font-size: 2.5rem !important;
        }
        .lead {
            font-size: 1.2rem !important;
        }
    }
    
    /* Color primario personalizado */
    .text-primary {
        color: #1A365D !important;
    }
    
    .border-start-primary {
        border-left-color: #1A365D !important;
        border-left-width: 5px !important;
    }
    
    .bg-primary {
        background-color: #1A365D !important;
    }
    
    /* Tamaños de fuente aumentados */
    body {
        font-size: 1.1rem;
    }
    h1 {
        font-size: 2.5rem;
    }
    h2 {
        font-size: 2rem;
    }
    h3 {
        font-size: 1.75rem;
    }
    .fs-4 {
        font-size: 1.5rem;
    }
    .fs-5 {
        font-size: 1.25rem;
    }
</style>

@push('scripts')
<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// Gráfico de estado de pagos - Mejorado
var paymentStatusChart = new Chart(document.getElementById('paymentStatusChart'), {
    type: 'doughnut',
    data: {
        labels: ['Aprobados', 'Pendientes', 'Rechazados', 'Vencidos'],
        datasets: [{
            data: [
                {{ $paymentStatuses['approved'] }},
                {{ $paymentStatuses['pending'] }},
                {{ $paymentStatuses['rejected'] }},
                {{ $paymentStatuses['expired'] }}
            ],
            backgroundColor: ['#1cc88a', '#f6c23e', '#e74a3b', '#858796'],
            hoverBackgroundColor: ['#17a673', '#dda20a', '#be2617', '#6b6d7d'],
            hoverBorderColor: "rgba(234, 236, 244, 1)",
            borderWidth: 3,
        }],
    },
    options: {
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                titleFont: {
                    size: 18,
                    weight: 'bold'
                },
                padding: 15,
                backgroundColor: "#fff",
                titleColor: "#333",
                bodyColor: "#666",
                borderColor: "rgba(0,0,0,0.1)",
                borderWidth: 2,
                cornerRadius: 8,
                displayColors: true,
                boxPadding: 8
            }
        },
        cutout: '65%',
    }
});

// Gráfico de ingresos mensuales - Mejorado
var monthlyRevenueChart = new Chart(document.getElementById('monthlyRevenueChart'), {
    type: 'line',
    data: {
        labels: @json($monthlyRevenueData['labels']),
        datasets: [{
            label: "Ingresos",
            lineTension: 0.3,
            backgroundColor: "rgba(26, 54, 93, 0.05)",
            borderColor: "#1A365D",
            borderWidth: 4,
            pointRadius: 5,
            pointBackgroundColor: "#1A365D",
            pointBorderColor: "#fff",
            pointBorderWidth: 3,
            pointHoverRadius: 8,
            pointHoverBackgroundColor: "#1A365D",
            pointHoverBorderColor: "#1A365D",
            pointHitRadius: 15,
            data: @json($monthlyRevenueData['data']),
        }],
    },
    options: {
        maintainAspectRatio: false,
        responsive: true,
        plugins: {
            legend: {
                display: false
            },
            tooltip: {
                bodyFont: {
                    size: 16
                },
                titleFont: {
                    size: 18,
                    weight: 'bold'
                },
                padding: 15,
                backgroundColor: "#fff",
                titleColor: "#333",
                bodyColor: "#666",
                borderColor: "rgba(0,0,0,0.1)",
                borderWidth: 2,
                cornerRadius: 8,
                displayColors: false,
                callbacks: {
                    label: function(tooltipItem) {
                        return '$' + tooltipItem.raw.toLocaleString();
                    }
                }
            }
        },
        scales: {
            x: {
                grid: {
                    display: false,
                    drawBorder: false
                },
                ticks: {
                    maxTicksLimit: 12,
                    font: {
                        size: 14
                    }
                }
            },
            y: {
                beginAtZero: true,
                max: Math.ceil({{ $monthlyRevenueData['max'] }} * 1.2),
                ticks: {
                    maxTicksLimit: 5,
                    padding: 15,
                    font: {
                        size: 14
                    },
                    callback: function(value) {
                        return '$' + value.toLocaleString();
                    }
                },
                grid: {
                    color: "rgb(234, 236, 244)",
                    drawBorder: false,
                    borderDash: [2],
                    zeroLineBorderDash: [2]
                }
            }
        }
    }
});

// Función para actualizar el gráfico con diferente rango de meses
function updateChart(months) {
    fetch(`/admin/dashboard-data?months=${months}`)
        .then(response => response.json())
        .then(data => {
            monthlyRevenueChart.data.labels = data.labels;
            monthlyRevenueChart.data.datasets[0].data = data.data;
            monthlyRevenueChart.options.scales.y.max = Math.ceil(Math.max(...data.data) * 1.2);
            monthlyRevenueChart.update();
            
            // Mostrar notificación de actualización
            Toastify({
                text: `Gráfico actualizado: últimos ${months} meses`,
                duration: 3000,
                close: true,
                gravity: "top",
                position: "right",
                backgroundColor: "#1A365D",
                className: "fs-5",
                style: {
                    fontSize: '1.1rem',
                    padding: '15px'
                }
            }).showToast();
        });
}
</script>

<!-- Toastify para notificaciones -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
@endpush
