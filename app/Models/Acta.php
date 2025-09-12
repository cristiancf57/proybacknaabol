<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Acta extends Model
{
    use HasFactory;
    protected $table = 'actas';
    protected $fillable = ['descripcion','encargado','tecnico','supervisor','observaciones','actividad_id'];

    public function actividad():HasOne{
        return $this->hasOne(Actividad::class);
    }
}
