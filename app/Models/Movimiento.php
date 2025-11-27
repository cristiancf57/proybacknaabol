<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Movimiento extends Model
{
    use HasFactory;
    protected $table = 'movimientos';
    protected $fillable = ['tipo_movimiento','origen','destino','fecha','estado','descripcion','usuario_id','activo_id'];

    public function usuario():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function activo():BelongsTo{
        return $this->belongsTo(Activo::class);
    }

}
