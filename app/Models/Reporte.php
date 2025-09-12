<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Reporte extends Model
{
    use HasFactory;
    protected $table = 'reportes';
    protected $fillable = ['detalle','tipo_reporte','fecha','hora','estado','personal'];

    public function actareportes():HasOne{
        return $this->hasOne(Actareporte::class);
    }
}
