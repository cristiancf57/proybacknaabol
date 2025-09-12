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
        Schema::create('actividades', function (Blueprint $table) {
            $table->id();
            $table->string('foto',200)->nullable();
            $table->date('fecha')->nullable();
            $table->enum('tipo_mantenimiento',['preventivo','correctivo'])->nullable();
            $table->enum('limpieza',['si','no'])->nullable();
            $table->enum('sistema_operativo',['si','no'])->nullable();
            $table->enum('archivos',['si','no'])->nullable();
            $table->enum('hardware',['si','no'])->nullable();
            $table->enum('software',['si','no'])->nullable();
            $table->string('observaciones',200)->nullable();

            $table->unsignedBigInteger('mantenimiento_id');
            $table->foreign('mantenimiento_id')->references('id')->on('mantenimientos')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actividades');
    }
};
