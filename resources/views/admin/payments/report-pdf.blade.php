<!DOCTYPE html>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <title>Reporte de Pagos - {{ ucfirst($estado) }}</title>
    <style>
        :root {
            --azul-marino: #1A365D;
            --naranja-brillante: #FF6B35;
            --verde-esmeralda: #2EC4B6;
            --blanco: #FFFFFF;
            --azul-oscuro: #0f2a4a;
        }
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            color: var(--azul-oscuro);
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: flex-start;
            gap: 20px;
            margin-bottom: 25px;
        }
        .logo {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border-radius: 50%;
        }
        .header-text {
            flex: 1;
        }
        .title {
            font-size: 20px;
            font-weight: bold;
            color: var(--azul-marino);
        }
        .subtitle {
            font-size: 15px;
            color: var(--naranja-brillante);
            margin-bottom: 5px;
        }
        .date {
            font-size: 12px;
            color: #555;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            font-size: 13px;
        }
        .table th {
            background-color: var(--azul-marino);
            color: var(--blanco);
            text-align: left;
            padding: 8px;
        }
        .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table tr:nth-child(even) {
            background-color: #f4f4f4;
        }
        .table tr:hover {
            background-color: #e0f7f5;
        }
        .total {
            margin-top: 15px;
            font-weight: bold;
            text-align: right;
            color: var(--verde-esmeralda);
        }
        .footer {
            margin-top: 30px;
            font-size: 10px;
            text-align: center;
            color: #777;
        }
    </style>
</head>
<body>
    <div class="header">
        <img class="logo" src="{{ public_path('images/logo.png') }}" alt="Logo FitNFlow">
        <div class="header-text">
            <div class="title">Reporte de Pagos - {{ ucfirst($estado) }}</div>
            <div class="subtitle">FitNFlow Sport Club</div>
            <div class="date">{{ $meses[$mes] }} de {{ $anio }}</div>
        </div>
    </div>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Usuario</th>
                <th>Membresía</th>
                <th>Monto</th>
                <th>Fecha</th>
                @if($estado == 'rechazado')
                <th>Motivo</th>
                @endif
            </tr>
        </thead>
        <tbody>
            @foreach($payments as $index => $payment)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $payment->user->names }} {{ $payment->user->last_name }}</td>
                <td>{{ $payment->membership->name }} ({{ $payment->membership->duration }} días)</td>
                <td>${{ number_format($payment->price, 2) }}</td>
                <td>{{ \Carbon\Carbon::parse($payment->date)->translatedFormat('d \d\e F \d\e Y') }}</td>
                @if($estado == 'rechazado')
                <td>{{ $payment->comment ?? 'Sin comentario' }}</td>
                @endif
            </tr>
            @endforeach
        </tbody>
    </table>
    
    @if($estado == 'aprobado' && $total)
    <div class="total">
        Total de ventas: ${{ number_format($total, 2) }} | 
        Total de membresías: {{ $payments->count() }}
    </div>
    @endif
    
    <div class="footer">
        Generado el {{ now()->format('d/m/Y H:i') }} | FitNFlow Sport Club System v1.0
    </div>
</body>
</html>