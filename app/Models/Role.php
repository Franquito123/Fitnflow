<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model {
    const ADMIN = 'admin';
    const USUARIO = 'usuario';
    const INSTRUCTOR = 'instructor';
    
    // Asegúrate que estos campos estén en fillable
    protected $fillable = [
        'name_rol',
        'slug',
        'created_at',
        'updated_at'
    ];


    public function users()
{
    return $this->hasMany(User::class, 'rol_id');
}

}