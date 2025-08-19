<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function index(Request $request)
{
    $estado = $request->estado ?? 'pendiente';

    $statusMap = [
        'pendiente' => 4,
        'aprobado' => 5,
        'rechazado' => 6,
        'vencido' => 7
    ];

    $query = Payment::with(['user', 'membership', 'status'])
        ->where('status_id', $statusMap[$estado] ?? 4)
        ->orderBy('date', 'desc');

    // ✅ Filtro por búsqueda de usuario
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('names', 'like', '%' . $request->search . '%')
              ->orWhere('last_name', 'like', '%' . $request->search . '%')
              ->orWhere('email', 'like', '%' . $request->search . '%');
        });
    }

    $payments = $query->paginate(10)->withQueryString();

    // ✅ Actualización automática a vencido
    foreach ($payments as $payment) {
        $paymentDate = Carbon::parse($payment->date);
        $durationDays = $payment->membership->duration ?? 30;
        $expirationDate = $paymentDate->copy()->addDays($durationDays);

        if (Carbon::now()->greaterThan($expirationDate) && $payment->status_id != 7) {
            $payment->update([
                'status_id' => 7,
                'comment' => 'Pago marcado automáticamente como vencido.',
            ]);
        }
    }

    return view('admin.payments.index', compact('payments'));
}

    public function show(Payment $payment)
    {
        return view('admin. payments.show', compact('payment'));
    }

    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'status_id' => 'required|in:4,5,6',
            'comment' => 'nullable|string|max:1000',
        ]);

        $statusId = $request->status_id;
        $comment = $request->comment;

        if ($statusId == 6 && empty($comment)) {
            return back()->withErrors(['comment' => 'Debes proporcionar un motivo para rechazar el pago.']);
        }

        $updateData = [
            'status_id' => $statusId,
            'comment' => $statusId == 6 
                ? $comment 
                : ($statusId == 5 
                    ? 'Pago aprobado por el administrador.' 
                    : 'Pago en revisión.')
        ];

        $payment->update($updateData);

        return back()->with('status', 'Pago actualizado correctamente.');
    }

    public function generateReport(Request $request)
{
    $validated = $request->validate([
        'mes' => 'required|numeric|between:1,12',
        'anio' => 'required|numeric|min:2020',
        'estado' => 'required|in:pendiente,aprobado,rechazado,vencido',
    ]);

    $view = $request->boolean('view'); // true para visualizar, false para descargar

    $statusMap = [
        'pendiente' => 4,
        'aprobado' => 5,
        'rechazado' => 6,
        'vencido' => 7
    ];

    $payments = Payment::with(['user', 'membership', 'status'])
        ->where('status_id', $statusMap[$validated['estado']])
        ->whereMonth('date', $validated['mes'])
        ->whereYear('date', $validated['anio'])
        ->orderBy('date', 'desc')
        ->get();

    $total = $validated['estado'] == 'aprobado' ? $payments->sum('price') : 0;

    $meses = [
        1 => 'Enero', 2 => 'Febrero', 3 => 'Marzo', 4 => 'Abril',
        5 => 'Mayo', 6 => 'Junio', 7 => 'Julio', 8 => 'Agosto',
        9 => 'Septiembre', 10 => 'Octubre', 11 => 'Noviembre', 12 => 'Diciembre'
    ];

    $fileName = "reporte_pagos_{$validated['estado']}_{$meses[$validated['mes']]}_{$validated['anio']}.pdf";

   $visualizando = $view;

$pdf = Pdf::loadView('admin.payments.report-pdf', [
    'payments' => $payments,
    'estado' => $validated['estado'],
    'mes' => $validated['mes'],
    'anio' => $validated['anio'],
    'total' => $total,
    'meses' => $meses,
    'visualizando' => $visualizando // 👈
]);


    return $view
    ? $pdf->stream($fileName)
    : $pdf->download($fileName);


}

}
