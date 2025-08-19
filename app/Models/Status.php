<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Status extends Model
{
    use HasFactory;

    protected $table = 'statuses';  // plural table name
    protected $fillable = ['name', 'type'];

    // Example constant for 'type'
    const TYPE_USER = 1;

    // Polymorphic relationship placeholder (you may adjust based on your app logic)
    public function statusable()
    {
        return $this->morphTo(__FUNCTION__, 'type', 'id');
    }

    public static function getTypes()
    {
        return [
            self::TYPE_USER => 'User',
        ];
    }

    // Accessor for readable type name
    public function getTypeNameAttribute()
    {
        return self::getTypes()[$this->type] ?? 'Unknown';
    }

    // Scope to filter by user type
    public function scopeForUsers($query)
    {
        return $query->where('type', self::TYPE_USER);
    }
}
