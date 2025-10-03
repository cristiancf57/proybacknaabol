<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Actividad extends Model
{
    protected $table = 'actividades';
    protected $fillable = ['foto','fecha','tipo_mantenimiento','limpieza','sistema_operativo','archivos','hardware','software','encargado','tecnico','supervisor','observaciones','mantenimiento_id'];

    public function mantenimiento():BelongsTo{
        return $this->belongsTo(Mantenimiento::class);
    }

}
