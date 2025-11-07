<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    protected $fillable = [
        'name',
        'guard_name',
        'description', 
        'module' 
    ];

    // Métodos personalizados
    public function getModuleAttribute()
    {
        return explode('.', $this->name)[0] ?? 'general';
    }
}
