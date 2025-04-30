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
        // Cria a migration: > php artisan make:migration create_imoveis_table --create=imoveis
        // Executa a migration e cria a tabela no banco de dados: > php artisan migrate
        // Modifica a migration: > php artisan make:migration modify_proprietario_id_on_imoveis_table --table=imoveis

        // Cria a tabela imoveis.
        Schema::create('imoveis', function (Blueprint $table) {
            $table->id(); // Chave primária.
            $table->foreignId('proprietario_id')->constrained('proprietarios')->onDelete('cascade'); // Referencia a tabela 'proprietarios' e define que, se um proprietário for deletado, todos os imóveis associados a ele também serão deletados.
            $table->string('endereco');
            $table->decimal('valor', 10, 2);
            $table->timestamps(); // Adiciona as colunas 'created_at' e 'updated_at' automaticamente.
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Reverte a última migration executada: > php artisan migrate:rollback
        Schema::dropIfExists('imoveis');
    }
};
