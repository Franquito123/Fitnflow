<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PasswordChangedNotification extends Notification
{
    use Queueable;

    public $newPassword;

    public function __construct($newPassword)
    {
        $this->newPassword = $newPassword;
    }

    public function via($notifiable)
    {
        return ['mail']; // o 'database' si quieres guardarla también
    }

    public function toMail($notifiable)
    {
        return (new \Illuminate\Notifications\Messages\MailMessage)
            ->subject('Tu contraseña ha sido actualizada')
            ->greeting('Hola ' . $notifiable->names . ',')
            ->line('Tu contraseña ha sido actualizada correctamente.')
            ->line('Nueva contraseña: **' . $this->newPassword . '**')
            ->line('Si no realizaste este cambio, por favor comunícate con soporte.')
            ->salutation('Saludos, Equipo de Soporte');
    }
}
