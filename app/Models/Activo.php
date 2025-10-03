<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Activo extends Model
{
    use HasFactory;
    protected $table = 'activos';
    protected $fillable = ['detalle','codigo','marca','modelo','serie','color','area','ip','ubicacion','estado','fecha','descripcion','tipo'];

    public function movimientos():HasMany{
        return $this->hasMany(Movimiento::class);
    }

    public function mantenimientos():HasMany{
        return $this->hasMany(Mantenimiento::class);
    }

    public function componente():HasMany{
        return $this->hasMany(Componente::class);
    }
}
