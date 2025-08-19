<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSetting extends Model
{
    protected $fillable = ['style', 'radius', 'duration', 'brightness_animation'];
}