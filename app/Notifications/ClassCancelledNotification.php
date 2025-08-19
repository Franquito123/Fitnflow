<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use App\Models\Classes;
use Carbon\Carbon;

class ClassCancelledNotification extends Notification
{
    use Queueable;

    protected $class;

    public function __construct(Classes $class)
    {
        $this->class = $class;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        // Establecer el locale en español
        Carbon::setLocale('es');

        // Formatear la fecha completa: "martes, 10 de junio de 2025"
        $formattedDate = Carbon::parse($this->class->date)->translatedFormat('l, d \d\e F \d\e Y');

        // Formatear la hora: "01:00 PM"
        $formattedTime = Carbon::createFromFormat('H:i:s', $this->class->time)->format('h:i A');

        return (new MailMessage)
            ->subject('Clase Cancelada')
            ->greeting('Hola ' . $notifiable->name)
            ->line("La clase de {$this->class->service->name} con el instructor {$this->class->instructor->name} programada para el {$formattedDate} a las {$formattedTime} ha sido cancelada.")
            ->line('Lamentamos los inconvenientes y te invitamos a revisar otras clases disponibles.')
            ->action('Ver clases disponibles', url('/user/classes'))
            ->line('Gracias por usar nuestra plataforma.');
    }
}
