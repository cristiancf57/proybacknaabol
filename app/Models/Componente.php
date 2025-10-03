<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Componente extends Model
{
    use HasFactory;
    protected $table = 'componentes';
    protected $fillable = ['cantidad','fecha','descripcion','mantenimiento_id','repuesto_id'];

    public function activos():BelongsTo{
        return $this->belongsTo(Activo::class);
    }

    public function repuestos():BelongsTo{
        return $this->belongsTo(Repuesto::class);
    }
}
