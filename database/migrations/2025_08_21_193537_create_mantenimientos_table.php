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
            $table->date('fecha');
            $table->enum('tipo_mantenimiento',['preventivo','correctivo'])->nullable();
            $table->string('descripcion',100)->nullable();
            $table->string('foto_antes',200)->nullable();
            $table->string('foto_despues',200)->nullable();
            $table->integer('responsable')->nullable();
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
