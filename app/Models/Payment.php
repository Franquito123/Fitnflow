<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'membership_id',
        'status_id',
        'date',
        'price',
        'receipt_url',
        'comment',
    ];

    // RELACIÓN: el pago pertenece a un usuario
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // RELACIÓN: el pago pertenece a una membresía
    public function membership()
    {
        return $this->belongsTo(Membership::class);
    }

    // RELACIÓN: el pago tiene un estado
    public function status()
    {
        return $this->belongsTo(Status::class);
    }

    public function getFormattedDateAttribute()
    {
        return Carbon::parse($this->date)->format('d/m/Y'); // Puedes cambiar a 'Y-m-d' si prefieres
    }
}
