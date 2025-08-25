<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Acta extends Model
{
    use HasFactory;
    protected $table = 'actas';
    protected $fillable = ['codigo_acta','descripcion','encargado','mantenimiento_id'];

    public function mantenimiento():HasOne{
        return $this->hasOne(Mantenimiento::class);
    }
}
