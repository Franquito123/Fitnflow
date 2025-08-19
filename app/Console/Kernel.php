<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Los comandos Artisan personalizados.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\NotifyCancelledClasses::class,
        \App\Console\Commands\CheckMembershipExpirations::class,
        \App\Console\Commands\ReactivateUsers::class,
        \App\Console\Commands\DeactivateUsers::class,
    ];

    /**
     * Define el horario de los comandos.
     */
    protected function schedule(Schedule $schedule): void
    {
        $schedule->command('check:memberships')->hourly();
        $schedule->command('classes:notify-cancelled')->everyMinute();
        $schedule->command('users:reactivate')->everyMinute();       // Reactiva usuarios con pagos vigentes
        $schedule->command('users:deactivate')->everyMinute();       // Desactiva usuarios sin pagos válidos
    }

    /**
     * Registra los comandos para la aplicación.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
