<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Tarea extends Model
{
    use HasFactory;
    protected $table = 'tareas';
    protected $fillable = ['detalle','tipo_reporte','fecha','hora','estado','personal'];

    public function actareportes():HasOne{
        return $this->hasOne(Actareporte::class);
    }
}
