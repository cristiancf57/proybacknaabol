<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Usuario extends Model
{
    use HasFactory;
    protected $table = 'usuarios';
    protected $fillable = ['nombre','apellido','email','telefono','username','password','rol_id'];

    public function rol():BelongsTo{
        return $this->belongsTo(Rol::class);
    }

    public function mantenimientos():HasMany{
        return $this->hasMany(Mantenimiento::class);
    }

    public function movimientos():HasMany{
        return $this->hasMany(Movimiento::class);
    }

    public function actareportes():HasMany{
        return $this->hasMany(Actareporte::class);
    }
}
