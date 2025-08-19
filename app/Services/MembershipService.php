<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Payment;
use App\Models\Status;
use App\Models\User;
use App\Notifications\MembershipToExpireNotification;
use App\Notifications\MembershipExpiredNotification;

class MembershipService
{
    /**
     * Reactiva usuarios con pagos vigentes.
     */
    public function reactivarUsuarios($command = null)
    {
        $statusApprovedId = Status::where('name', 'Aprobado')->where('type', 2)->value('id');
        $activeStatusId = Status::where('name', 'Activo')->where('type', 1)->value('id');
        $userRoleId = 2; // ID rol Usuario

        // Obtener pagos aprobados con membresías activas agrupados por usuario
        $usersWithValidPayments = Payment::with(['membership', 'user'])
            ->where('status_id', $statusApprovedId)
            ->whereHas('membership', fn($q) => $q->where('status_id', $activeStatusId))
            ->get()
            ->groupBy('user_id');

        foreach ($usersWithValidPayments as $userPayments) {
            $user = $userPayments->first()->user;

            $command?->info("Evaluando usuario: {$user->email} | rol: {$user->rol_id} | estado: {$user->status_id}");

            // Solo usuarios (no instructores u otros roles)
            if ($user->rol_id != $userRoleId) {
                $command?->info(" - No es usuario, se omite.");
                continue;
            }

            // Verificar si hay algún pago válido (fecha + duración)
            $hasValid = $userPayments->contains(function ($p) {
                return now()->lessThan(
                    Carbon::parse($p->date)->addDays($p->membership->duration ?? 0)->startOfDay()
                );
            });

            if ($hasValid && $user->status_id !== $activeStatusId) {
                $user->update(['status_id' => $activeStatusId]);
                $command?->info("🟢 Usuario {$user->email} reactivado automáticamente.");
            }
        }
    }

    /**
     * Desactiva usuarios sin pagos vigentes o pagos vencidos y envía notificaciones.
     */
    public function desactivarUsuarios($command = null)
    {
        $hoy = Carbon::today();

        $statusApprovedId = Status::where('name', 'Aprobado')->where('type', 2)->value('id');
        $statusDuePaymentId = Status::where('name', 'Vencido')->where('type', 2)->value('id');
        $activeStatusId = Status::where('name', 'Activo')->where('type', 1)->value('id');
        $inactiveStatusId = Status::where('name', 'Inactivo')->where('type', 1)->value('id');
        $userRoleId = 2;

        // Obtener pagos aprobados con membresías activas
        $payments = Payment::with(['membership', 'user'])
            ->where('status_id', $statusApprovedId)
            ->whereHas('membership', fn($q) => $q->where('status_id', $activeStatusId))
            ->get();

        foreach ($payments as $payment) {
            $membership = $payment->membership;
            $user = $payment->user;

            if (!$membership || !$user) {
                $command?->warn("❌ Pago sin membresía o usuario (ID: {$payment->id})");
                continue;
            }

            if ($user->rol_id != $userRoleId) {
                continue;
            }

            $expirationDate = Carbon::parse($payment->date)
                ->addDays($membership->duration)
                ->startOfDay();

            // Si ya venció el pago
            if (now()->greaterThanOrEqualTo($expirationDate)) {

                if ($payment->status_id !== $statusDuePaymentId) {
                    $payment->update(['status_id' => $statusDuePaymentId]);
                    $user->notify(new MembershipExpiredNotification());
                    $command?->info("⚠ Notificación de vencimiento enviada a {$user->email}");
                }

                // Revisar si existen otros pagos vigentes para el usuario
                $otherValid = Payment::where('user_id', $user->id)
                    ->where('status_id', $statusApprovedId)
                    ->where('id', '!=', $payment->id)
                    ->get()
                    ->filter(fn($p) => now()->lessThan(
                        Carbon::parse($p->date)->addDays($p->membership->duration ?? 0)->startOfDay()
                    ));

                if ($otherValid->isEmpty() && $user->status_id !== $inactiveStatusId) {
                    $user->update(['status_id' => $inactiveStatusId]);
                    $command?->info("🔴 Usuario {$user->email} desactivado automáticamente (todos sus pagos vencidos).");
                }

                continue; // No revisar notificación de expiración próxima si ya venció
            }

            // Notificación si faltan 5,4,3,2 o 1 días para expirar
            $remainingDays = $hoy->diffInDays($expirationDate, false);

            if (in_array($remainingDays, [5,4,3,2,1])) {
                $user->notify(new MembershipToExpireNotification($remainingDays));
                $command?->info("📩 Notificación enviada a {$user->email} (faltan {$remainingDays} días)");
            }
        }

        // Desactivar usuarios con estado activo pero sin pagos aprobados
        $usersWithNoValidPayments = User::where('status_id', $activeStatusId)
            ->where('rol_id', $userRoleId)
            ->whereDoesntHave('payments', fn($q) => $q->where('status_id', $statusApprovedId))
            ->get();

        foreach ($usersWithNoValidPayments as $user) {
            $user->update(['status_id' => $inactiveStatusId]);
            $command?->info("🔴 Usuario {$user->email} desactivado por no tener pagos aprobados.");
        }
    }
}
