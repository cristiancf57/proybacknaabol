<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
     protected $fillable = [
        'name',
        'guard_name',
        'description'
    ];

    // Relaciones personalizadas
    public function users()
    {
        return $this->morphedByMany(
            config('auth.providers.users.model'),
            'model',
            config('permission.table_names.model_has_roles'),
            'role_id',
            'model_id'
        );
    }

    // Métodos personalizados
    public function hasPermission($permission)
    {
        return $this->permissions->contains('name', $permission);
    }
}
