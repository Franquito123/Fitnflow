<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class MembershipExpiredNotification extends Notification
{
    use Queueable;

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Tu membresía ha vencido')
            ->greeting("Hola {$notifiable->name},")
            ->line('Tu membresía ha vencido y ya no tienes acceso a los beneficios de la plataforma.')
            ->line('Te invitamos a renovarla para seguir disfrutando de nuestros servicios.')
            ->action('Renovar membresía', url('/membresia/renovar'))
            ->line('Gracias por ser parte de nuestra comunidad.');
    }
}
