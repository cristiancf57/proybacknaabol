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
        Schema::create('componentes', function (Blueprint $table) {
            $table->id();
            $table->integer('cantidad');
            $table->date('fecha');
            $table->string('descripcion',150)->nullable();

            $table->unsignedBigInteger('activo_id');
            $table->foreign('activo_id')->references('id')->on('activos')->onDelete('cascade');

            $table->unsignedBigInteger('repuesto_id');
            $table->foreign('repuesto_id')->references('id')->on('repuestos')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('componentes');
    }
};
