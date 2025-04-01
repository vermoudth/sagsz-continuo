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
        Schema::table('users', function (Blueprint $table) {
            // Eliminar columnas
            $table->dropColumn('email');
            $table->dropColumn('email_verified_at');

            // Agregar nuevas columnas
            $table->string('identificacion', 50)->unique();
            $table->string('cargo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // Revertir cambios
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();

            $table->dropColumn('identificacion');
            $table->dropColumn('cargo');
        });
    }
};
