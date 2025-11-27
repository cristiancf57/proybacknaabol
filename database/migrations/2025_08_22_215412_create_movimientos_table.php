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
            $table->enum('tipo_movimiento',['cambio de ubicacion','asignacion','baja'])->nullable();
            $table->string('origen',80)->nullable();
            $table->string('destino',80)->nullable();
            $table->date('fecha')->nullable();
            $table->enum('estado',['operable','nuevo','baja'])->nullable();
            $table->string('descripcion',150)->nullable();

            $table->unsignedBigInteger('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('activo_id');
            $table->foreign('activo_id')->references('id')->on('activos')->onDelete('cascade');

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
