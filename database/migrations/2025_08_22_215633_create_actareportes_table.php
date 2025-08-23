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
        Schema::create('actareportes', function (Blueprint $table) {
            $table->id();
            $table->string('foto')->nullable();
            $table->timestamp('fecha_hora')->nullable();
            $table->integer('usuario_id');
            $table->integer('reporte_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('actareportes');
    }
};
