<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('articulos', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->enum('unidad_medida', ['ml', 'kg', 'l', 'g','u']);
            $table->integer('cantidad_inicial')->default(0);
            $table->integer('precio_por_unidad');
            $table->string('imagen')->nullable(); // Campo para la ruta de la imagen
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('articulos');
    }
};
