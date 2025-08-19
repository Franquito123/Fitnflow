<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Requirement extends Model
{
    protected $fillable = ['service_id', 'name'];
    
    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }
}