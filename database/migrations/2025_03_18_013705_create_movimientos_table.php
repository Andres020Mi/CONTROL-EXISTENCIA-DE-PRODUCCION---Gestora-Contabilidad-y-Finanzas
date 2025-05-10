<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('movimientos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('articulo_id')->constrained('articulos')->onDelete('cascade');
            $table->integer('cantidad');
            $table->enum('tipo', ['entrada', 'salida']);
            $table->date('fecha');
            $table->integer("valor_del_movimiento");
            $table->foreignId('semana_id')->constrained('semanas')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('movimientos');
    }
};
