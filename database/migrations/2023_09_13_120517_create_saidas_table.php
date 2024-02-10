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
        Schema::create('saidas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('motorista_id')->constrained();
            $table->string('saida_descricao');
            $table->date('saida_data');
            $table->decimal('saida_valor',10,2);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('saidas');
    }
};
