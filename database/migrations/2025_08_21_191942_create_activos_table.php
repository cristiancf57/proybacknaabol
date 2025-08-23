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
        Schema::create('activos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre',80)->nullable();
            $table->string('marca',30)->nullable();
            $table->string('modelo',50)->nullable();
            $table->string('serie',100)->nullable();
            $table->integer('activo')->nullable();
            $table->string('area',100)->nullable();
            $table->string('ubicacion',100)->nullable();
            $table->enum('estado',['Activo','Reparacion', 'Baja'])->default('Activo');
            $table->string('descripcion',100)->nullable();
            $table->integer('id_tipo');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('activos');
    }
};
