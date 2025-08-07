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
        Schema::create('registros_ambientales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('categoria_id');
            $table->decimal('temperatura', 5, 2);
            $table->decimal('humedad', 5, 2);
            $table->timestamp('registrado_en')->useCurrent();

            $table->foreign('categoria_id')->references('id')->on('categorias_animales')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registros_ambientales');
    }
};
