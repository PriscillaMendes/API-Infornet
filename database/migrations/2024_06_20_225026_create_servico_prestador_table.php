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
        Schema::create('servico_prestador', function (Blueprint $table) {
            $table->id();
            $table->foreignId('prestador_id')->constrained('prestador')->onDelete('cascade');
            $table->foreignId('servico_id')->constrained('servicos')->onDelete('cascade');
            $table->integer('km_saida');
            $table->decimal('valor_saida', 8, 2);
            $table->decimal('valor_km_excedente', 8, 2);
            $table->timestamps();

            $table->unique(['prestador_id','servico_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('servico_prestador');
    }
};
