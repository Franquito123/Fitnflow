<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'image_url', // <--- NUEVO CAMPO
    ];

    public function requirements()
    {
        return $this->hasMany(Requirement::class);
    }
}