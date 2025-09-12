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
    // protected $fillable = ['marca','modelo','serie','color','activo','area','ubicacion','estado','descripcion','tipo_id'];
    protected $fillable = ['detalle','codigo','marca','modelo','serie','color','area','ip','ubicacion','estado','fecha','descripcion','tipo_id'];

    public function tipo():BelongsTo{
        return $this->belongsTo(Tipo::class);
    }

    public function movimientos():HasMany{
        return $this->hasMany(Movimiento::class);
    }

    public function mantenimientos():HasMany{
        return $this->hasMany(Mantenimiento::class);
    }
}
