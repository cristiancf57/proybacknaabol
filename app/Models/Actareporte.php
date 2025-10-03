<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Actareporte extends Model
{
    use HasFactory;
    protected $table = 'actareportes';
    protected $fillable = ['foto','fecha','hora','descripcion', 'estado','usuario_id','tarea_id'];

    public function tarea():HasOne{
        return $this->hasOne(Tarea::class);
    }

    public function usuarios():HasOne{
        return $this->hasOne(User::class);
    }

}
