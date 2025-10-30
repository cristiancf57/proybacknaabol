<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Componente extends Model
{
    use HasFactory;
    protected $table = 'componentes';
    protected $fillable = ['cantidad','fecha','descripcion','activo_id','repuesto_id'];

    public function activo():BelongsTo{
        return $this->belongsTo(Activo::class);
    }

    public function repuesto():BelongsTo{
        return $this->belongsTo(Repuesto::class);
    }
}
