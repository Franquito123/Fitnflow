<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MembershipToExpireNotification extends Notification
{
    use Queueable;

    public $remainingdays;

    public function __construct($remainingdays)
    {
        $this->remainingdays = $remainingdays;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $daystext = $this->remainingdays === 1 ? '1 día' : "{$this->remainingdays} días";

        return (new MailMessage)
            ->subject("🔔 Tu membresía vence en {$daystext}")
            ->greeting("Hola, {$notifiable->name}")
            ->line("Este es un recordatorio de que tu membresía está por vencer.")
            ->line("Te quedan **{$daystext}** para renovarla y seguir disfrutando de nuestros servicios sin interrupciones.")
            ->action('Renovar ahora', url('/membresia/renovar'))
            ->line("Gracias por confiar en nosotros.");
    }
}
