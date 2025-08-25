<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Actareporte extends Model
{
    use HasFactory;
    protected $table = 'actareportes';
    protected $fillable = ['foto','fecha_hora','usuario_id','reporte_id'];

    public function reporte():HasOne{
        return $this->hasOne(Reporte::class);
    }
}
