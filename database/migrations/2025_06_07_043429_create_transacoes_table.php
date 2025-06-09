<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('transacoes', function (Blueprint $table) {
            $table->id();
            // adiciona user_id para ligar transação a um usuário
            $table->foreignId('user_id')
                  ->constrained()       // referencia users.id
                  ->onDelete('cascade');
            $table->foreignId('conta_id')
                  ->constrained('contas')
                  ->onDelete('cascade');
            $table->string('descricao')->nullable();
            $table->decimal('valor', 10, 2);
            $table->enum('tipo', ['entrada', 'saida']);
            $table->date('data');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('transacoes');
    }
};
