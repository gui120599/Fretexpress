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
        Schema::create('fretes', function (Blueprint $table) {
            $table->id();
            $table->string('frete_descricao_carga')->nullable();
            $table->foreignId('motorista_id')->constrained();
            $table->string('frete_empresa')->nullable();
            $table->string('frete_municipio_saida',100)->nullable();
            $table->string('frete_municipio_destino',100)->nullable();
            $table->decimal('frete_valor_km',10,2)->nullable();
            $table->integer('frete_distancia_percorrida')->nullable();
            $table->decimal('frete_valor_total',10,2);
            $table->date('frete_data_saida')->nullable();
            $table->date('frete_data_chegada')->nullable();
            $table->date('frete_data')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fretes');
    }
};
