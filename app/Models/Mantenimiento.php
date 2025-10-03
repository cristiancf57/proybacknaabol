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
    protected $fillable = ['estado','fecha','observaciones','activo_id'];

    public function usuarios():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function actividades():HasMany{
        return $this->hasMany(Actividad::class);
    }
}
