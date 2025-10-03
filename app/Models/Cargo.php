<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cargo extends Model
{
    use HasFactory;
    protected $table = 'cargos';
    protected $fillable = ['descripcion','area'];

    public function designacion():HasMany{
        return $this->hasMany(Designacion::class);
    }
}

