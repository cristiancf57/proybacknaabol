<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Mantenimiento extends Model
{
    use HasFactory;
    protected $table = 'mantenimientos';
    protected $fillable = ['fecha_programada','fecha_realizada','tipo_mantenimiento','resultados','foto_antes','foto_despues','observaciones','activo_id','tecnico_id'];

    public function acta():HasOne{
        return $this->hasOne(Acta::class);
    }

    public function usuario():BelongsTo{
        return $this->belongsTo(Usuario::class);
    }

    public function activo():BelongsTo{
        return $this->belongsTo(Activo::class);
    }

    public function componentes():HasMany{
        return $this->hasMany(Componente::class);
    }
}
