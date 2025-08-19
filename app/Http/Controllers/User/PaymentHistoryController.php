<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use Illuminate\Support\Facades\Auth;

class PaymentHistoryController extends Controller
{
    const PER_PAGE = 10;

    public function index()
    {
        $userId = Auth::id();

        // Obtener todos los pagos paginados
        $allPayments = Payment::with(['membership', 'status'])
            ->where('user_id', $userId)
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'all_page');

        // Pagos filtrados con paginación
        $paymentsPending = Payment::with(['membership', 'status'])
            ->where('user_id', $userId)
            ->whereHas('status', fn($q) => $q->where('name', 'Pendiente de revisión'))
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'pending_page');

        $paymentsApproved = Payment::with(['membership', 'status'])
            ->where('user_id', $userId)
            ->whereHas('status', fn($q) => $q->where('name', 'Aprobado'))
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'approved_page');

        $paymentsRejected = Payment::with(['membership', 'status'])
            ->where('user_id', $userId)
            ->whereHas('status', fn($q) => $q->where('name', 'Rechazado'))
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'rejected_page');

        $paymentsExpired = Payment::with(['membership', 'status'])
            ->where('user_id', $userId)
            ->whereHas('status', fn($q) => $q->where('name', 'Vencido'))
            ->latest()
            ->paginate(self::PER_PAGE, ['*'], 'expired_page');

        return view('user.payments.index', compact(
            'allPayments',
            'paymentsPending',
            'paymentsApproved',
            'paymentsRejected',
            'paymentsExpired'
        ));
    }

    public function show($id)
    {
        $payment = Payment::with(['membership', 'status'])
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => [
                'transaction_id' => 'TRX-'.$payment->id,
                'membership' => $payment->membership->name ?? 'No disponible',
                'amount' => '$'.number_format($payment->price, 2),
                'payment_date' => \Carbon\Carbon::parse($payment->date)->format('d/m/Y'),
                'status' => $payment->status->name,
                'receipt_url' => $payment->receipt_url,
                'comment' => $payment->comment ?? 'Sin comentarios',
                'processed_date' => $payment->updated_at->format('d/m/Y H:i'),
                'status_class' => $this->getStatusClass($payment->status->name)
            ]
        ]);
    }

    private function getStatusClass($statusName)
    {
        switch ($statusName) {
            case 'Pendiente de revisión':
                return 'pendiente';
            case 'Aprobado':
                return 'aprobado';
            case 'Rechazado':
                return 'rechazado';
            case 'Vencido':
                return 'vencido';
            default:
                return '';
        }
    }
}