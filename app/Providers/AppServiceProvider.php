<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\Models\Payment;
use App\Models\CenterInformation;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Define morphMap solo una vez, para evitar sobrescribir
        Relation::morphMap([
            'status' => \App\Models\Status::class,
            'users' => \App\Models\User::class,
        ]);

        view()->composer([
    'welcome',
    'home',
    'layouts.public',
    'layouts.partials.admi-navbar',
    'layouts.partials.footer'  // Agregas la vista del footer aquí
], function ($view) {
    $view->with('services', \App\Models\Service::all());  // Aquí agregas $services
});



        // Compartir info del centro a todas las vistas
        View::composer('*', function ($view) {
            $centerInfo = CenterInformation::first();
            $view->with('centerInfo', $centerInfo);
        });

        // Compartir estado de membresía aprobada a todas las vistas para usuarios autenticados
        View::composer('*', function ($view) {
            if (Auth::check()) {
                $payments = Payment::where('user_id', Auth::id())
                    ->whereHas('status', fn($q) => $q->where('name', 'Aprobado'))
                    ->get();

                $hasApprovedMembership = $payments->contains(function ($payment) {
                    $paymentDate = Carbon::parse($payment->date);
                    $durationDays = $payment->membership->duration ?? 30;
                    $expirationDate = $paymentDate->copy()->addDays($durationDays);
                    return $expirationDate->isFuture();
                });

                $view->with('hasApprovedMembership', $hasApprovedMembership);
            } else {
                $view->with('hasApprovedMembership', false);
            }
        });
    }
}