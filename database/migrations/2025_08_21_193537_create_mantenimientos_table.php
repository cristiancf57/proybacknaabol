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
        Schema::create('mantenimientos', function (Blueprint $table) {
            $table->id();
            $table->integer('activo_id')->nullable();
            $table->integer('id_tecnico')->nullable();
            $table->date('fecha_programada');
            $table->date('fecha_realizada');
            $table->enum('tipo_mantenimiento',['preventivo','correctivo'])->nullable();
            $table->string('resultados',100)->nullable();
            $table->string('foto_antes',200)->nullable();
            $table->string('foto_despues',200)->nullable();
            $table->string('observaciones',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mantenimientos');
    }
};
