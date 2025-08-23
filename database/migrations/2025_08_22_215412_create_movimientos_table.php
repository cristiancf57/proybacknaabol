<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->enum('tipo_movimiento',['prevecambio de ubicacion','asignacion','baja'])->nullable();
            $table->string('detalle',150)->nullable();
            $table->enum('estado',['operable','nuevo','baja'])->nullable();
            $table->integer('usuario_id');
            $table->integer('activo_id');
            $table->integer('ubicacion_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('movimientos');
    }
};
