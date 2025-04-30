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
        // Cria a migration: > php artisan make:migration create_proprietarios_table --create=proprietarios
        // Executa a migration e cria a tabela no banco de dados: > php artisan migrate
        

        // Cria a tabela proprietarios.
        Schema::create('proprietarios', function (Blueprint $table) {
            $table->id(); // Chave primária.
            $table->string('nome');
            $table->string('email')->unique(); // Deve ser um registro único no banco de dados.
            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at' automaticamente.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverte a última migration executada: > php artisan migrate:rollback
        Schema::dropIfExists('proprietarios');
    }
};
