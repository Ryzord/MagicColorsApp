<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('color_combinations', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nombre del conjunto de colores
            $table->json('colors'); // Almacenamos los colores como JSON
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('color_combinations');
    }
};
