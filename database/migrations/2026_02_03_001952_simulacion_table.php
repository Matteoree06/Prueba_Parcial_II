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
        Schema::create('simulacion', function (Blueprint $table){
                $table->string('id')->unique();
                $table->string('usuario_id')->foreign()->references('id')->on('usuarios');
                $table->timestamp('fecha_simulacion');
                $table->decimal('capital_disponible', 10, 2)->default(0);
                $table->decimal('ganancia_total', 10, 2)->default(0);
                $table->jsonb('productos_seleccionados');    
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('simulacion');
    }
};
