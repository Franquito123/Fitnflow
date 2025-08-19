<?php
namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Membership;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class MembershipController extends Controller
{
    // Mostrar membresías activas para el usuario
    public function index()
    {
        $memberships = Membership::where('status_id', 1)->get(); // Solo activas
        return view('user.memberships.index', compact('memberships'));
    }

    // Mostrar detalle de membresía y opción de pago
    public function pay(Membership $membership)
    {
        $user = Auth::user();
        $previousPayment = Payment::where('user_id', $user->id)
            ->where('membership_id', $membership->id)
            ->latest()->first();
        
        return view('user.memberships.pay', compact('membership', 'user', 'previousPayment'));
    }

    // Mostrar formulario para subir comprobante
    public function uploadReceipt(Membership $membership)
    {
        return view('user.memberships.upload-receipt', compact('membership'));
    }

    // Procesar carga del comprobante
    public function storeReceipt(Request $request)
    {
        $request->validate([
            'membership_id' => 'required|exists:memberships,id',
            'receipt' => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $user = Auth::user();
        $membership = Membership::findOrFail($request->membership_id);
        $filePath = $request->file('receipt')->store('comprobantes', 'public');

    // Crear un nuevo registro sin modificar registros previos
    Payment::create([
        'user_id' => $user->id,
        'membership_id' => $membership->id,
        'status_id' => 4, // Pendiente de revisión
        'date' => Carbon::now(), // Aquí se usa la fecha actual
        'price' => $membership->price,
        'receipt_url' => $filePath,
        'comment' => null,
    ]);

        return redirect()->route('user.payments.index')->with('status', 'Comprobante enviado. Espera la validación del administrador.');
    }

    // Validar vigencia actual del usuario
    public function verificarVigencia()
{
    $payment = Payment::where('user_id', Auth::id())->latest()->first();

    if (!$payment) {
        return redirect()->back()->withErrors('No has contratado una membresía activa.');
    }

    // Sumar duración y ajustar al final del día
    $endDate = Carbon::parse($payment->date)
        ->addDays($payment->membership->duration ?? 30)
        ->endOfDay();

    $isExpired = Carbon::now()->gt($endDate);

    if ($isExpired) {
        return redirect()->back()->withErrors('Tu membresía ha vencido. No puedes agendar clases.');
    }

    return true;
}

}