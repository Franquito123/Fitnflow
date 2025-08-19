<?php

namespace App\Models;

use Illuminate\Contracts\Auth\CanResetPassword;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use App\Notifications\ResetPasswordNotification;

class User extends Authenticatable implements CanResetPassword
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'names',
        'last_name',
        'birth_date',
        'gender',
        'email',
        'password',
        'rol_id',
        'status_id',
        'specialty',
        'certification',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    // Relación con la tabla roles (tu lógica personalizada)
    public function role()
    {
        return $this->belongsTo(Role::class, 'rol_id')->withDefault([
            'name_rol' => 'Sin Rol',
            'slug' => 'sin-rol',
        ]);
    }

    // Método personalizado para verificar el rol
    public function hasRole($slug)
    {
        return $this->role && $this->role->slug === $slug;
    }

    // Relación con el modelo de estado
    public function status()
    {
        return $this->belongsTo(Status::class, 'status_id')->withDefault([
            'name' => 'Undefined Status',
        ]);
    }

    // Relación: un usuario tiene muchos pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    // Relación: un usuario tiene muchas inscripciones
    public function registrations()
    {
        return $this->hasMany(Registration::class, 'user_id');
    }

    // Notificación para resetear contraseña
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }
}
