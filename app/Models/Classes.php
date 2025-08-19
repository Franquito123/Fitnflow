<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Classes extends Model
{
    use HasFactory;

    protected $table = 'classes';
    protected $fillable = [
        'service_id',
        'status_id',
        'instructor_id',
        'date',
        'time',
        'description',
        'max_capacity',
        'room',
        'comment',
        'notification',
    ];

    protected $casts = [
        'date' => 'date', // ✔️ Para que date sea un objeto Carbon
        'time' => 'string', // ✔️ O usar 'datetime:H:i' solo si es datetime en la DB
        'notification' => 'boolean',
    ];

    // Relación con servicio
    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    // Relación con estado
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // Relación con instructor
    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function registrations()
    {
        return $this->hasMany(Registration::class, 'class_id');
    }
    // Verificar disponibilidad
    public function isAvailable()
    {
        return $this->status_id == 1; // Asumiendo que 1 es "Disponible"
    }

    
}