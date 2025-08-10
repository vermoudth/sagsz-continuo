<?php

/*use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id(); // id [PK]
            $table->string('identificacion', 20);
            $table->string('nombre', 100);
            $table->string('password', 255);
            $table->unsignedBigInteger('rol_id');
            $table->timestamp('creado_en')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};*/

