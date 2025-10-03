<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Repuesto extends Model
{
    use HasFactory;
    protected $table = 'repuestos';
    protected $fillable = ['nombre','marca','modelo','descripcion','stock'];

    public function componente():HasMany{
        return $this->hasMany(Componente::class);
    }
}
