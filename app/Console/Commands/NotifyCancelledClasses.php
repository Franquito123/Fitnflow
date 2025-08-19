<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Classes;
use App\Models\Status;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Notification;
use App\Notifications\ClassCancelledNotification;

class NotifyCancelledClasses extends Command
{
    protected $signature = 'classes:notify-cancelled';
    protected $description = 'Verifica clases canceladas y envía notificaciones a los inscritos si aún no se han enviado.';

    public function handle()
{
    // Obtener ID de estado "Cancelado"
    $cancelledStatusId = Status::where('type', 3)->where('name', 'Cancelada')->value('id');


    if (!$cancelledStatusId) {
        $this->error('No se encontró el estado Cancelado');
        return;
    }

    // Buscar clases canceladas sin notificación aún
    $cancelledClasses = Classes::where('status_id', $cancelledStatusId)
        ->where('notification', 0)
        ->with('registrations.user') // Cargar usuarios inscritos
        ->get();

    $this->info("Clases encontradas para notificar: " . $cancelledClasses->count());

    foreach ($cancelledClasses as $class) {
        $this->info("Procesando clase ID: {$class->id}, notification actual: {$class->notification}");

        foreach ($class->registrations as $registration) {
    $user = $registration->user;
    $this->info(" - Notificando usuario: {$user->email}");

    // CORRECTO: notifica al modelo User directamente
    $user->notify(new ClassCancelledNotification($class));
}


        // Marcar como notificadas
        $class->notification = 1;
        $saved = $class->save();

        if ($saved) {
            $this->info("Clase ID {$class->id} actualizada correctamente a notification=1");
        } else {
            $this->error("Error al actualizar clase ID {$class->id}");
        }

        // Refrescar para ver el valor actualizado
        $class->refresh();
        $this->info("Valor notification después de guardar: {$class->notification}");
    }

    $this->info("Proceso terminado. Clases canceladas notificadas: " . $cancelledClasses->count());
}

}
