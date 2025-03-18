<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up() {
        Schema::create('semanas', function (Blueprint $table) {
            $table->id();
            $table->date('inicio');
            $table->date('fin');
            $table->integer('cantidad_total')->default(0); // Iniciar en 0
            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('semanas');
    }
};

