<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CenterInformation extends Model
{
    // Si tu tabla se llama 'center_information'
    protected $table = 'center_information';

    protected $fillable = [
        'opening_time',   // horario de apertura
        'closing_time',   // horario de cierre
        'days',           // días de atención
        'phone',          // teléfono
        'email',          // correo
        'address',        // dirección
        'map_embed',      // iframe de mapa
    ];
}