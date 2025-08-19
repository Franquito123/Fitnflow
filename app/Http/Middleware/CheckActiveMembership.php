<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Status;
use Carbon\Carbon;

class CheckActiveMembership
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        $approvedStatusId = Status::where('name', 'Aprobado')->where('type', 2)->value('id');
        $activeMembershipStatusId = Status::where('name', 'Activo')->where('type', 1)->value('id');

        $activePayment = $user->payments()
            ->where('status_id', $approvedStatusId)
            ->latest()
            ->first();

        if (!$activePayment || !$activePayment->membership) {
            return redirect()->route('user.memberships.index')
                ->with('warning', 'Necesitas una membresía aprobada y vigente para acceder.');
        }

        if ($activePayment->membership->status_id !== $activeMembershipStatusId) {
            return redirect()->route('user.memberships.index')
                ->with('warning', 'Tu membresía ya no está activa. Debes renovarla.');
        }

        $expirationDate = Carbon::parse($activePayment->date)
            ->addDays($activePayment->membership->duration ?? 30)
            ->endOfDay();

        if (Carbon::now()->greaterThan($expirationDate)) {
            return redirect()->route('user.memberships.index')
                ->with('warning', 'Tu membresía ha vencido. Necesitas renovarla.');
        }

        return $next($request);
    }
}
