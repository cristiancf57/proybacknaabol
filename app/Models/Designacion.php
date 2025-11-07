<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Designacion extends Model
{
    protected $table = 'designaciones';
    protected $fillable = ['estado','fecha_inicio','fecha_fin','rol','usuario_id','cargo_id'];

    public function usuario():BelongsTo{
        return $this->belongsTo(User::class);
    }

    public function cargo():BelongsTo{
        return $this->belongsTo(cargo::class,'cargo_id');
    }

}
