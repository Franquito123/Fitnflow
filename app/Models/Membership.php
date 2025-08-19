<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Membership extends Model
{
    use HasFactory;

    protected $fillable = [
        'status_id',
        'name',
        'description',
        'duration',
        'price',
    ];

    // RELACIÓN: una membresía pertenece a un estado
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    // RELACIÓN: una membresía tiene muchos pagos
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }
    public function latestPayment()
    {
        return $this->hasOne(Payment::class)->latestOfMany();
    }


public function getReadableDurationAttribute()
{
    $dias = $this->duration;
    $texto = '';

    // Casos especiales
    if ($dias === 365 || $dias === 366) {
        return '1 año';
    }

    if ($dias >= 182 && $dias <= 184) {
        return '6 meses';
    }

    if (in_array($dias, [28, 29, 30, 31])) {
        return '1 mes';
    }

    // Calcular años y meses normalmente
    $años = intdiv($dias, 365);
    $resto = $dias % 365;

    // Meses reales (considerando 30.44 días como promedio mensual)
    $meses = intdiv($resto, 30);
    $resto_dias = $resto % 30;

    if ($años > 0) {
        $texto .= $años . ' ' . ($años == 1 ? 'año' : 'años');
    }

    if ($meses > 0) {
        $texto .= ($texto ? ' y ' : '') . $meses . ' ' . ($meses == 1 ? 'mes' : 'meses');
    }

    if (!$texto && $dias < 28) {
        $texto = $dias . ' días';
    }

    return $texto;
}


}
