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
            $table->string('detalle',90)->nullable();
            $table->integer('codigo')->nullable();
            $table->string('marca',30)->nullable();
            $table->string('modelo',50)->nullable();
            $table->string('serie',100)->nullable();
            $table->string('color',60)->nullable();
            $table->string('area',100)->nullable();
            $table->string('ip',15)->nullable();
            $table->string('ubicacion',100)->nullable();
            $table->enum('estado',['Operable','Reparacion', 'Baja'])->default('Activo');
            $table->date('fecha');
            $table->string('descripcion',100)->nullable();

            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id')->references('id')->on('tipos')->onDelete('cascade');

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
