<?php

namespace Database\Factories;

use App\Models\Proprietario;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProprietarioFactory extends Factory
{
    // Cria a factory: > php artisan make:factory ProprietarioFactory --model=Proprietario

    protected $model = Proprietario::class; // Define qual modelo a factory vai gerar. 

    public function definition() // Método que define como os dados fictícios serão gerados.
    {
        return [
            'nome' => $this->faker->name, // Gera um nome aleatório.
            'email' => $this->faker->unique()->safeEmail, // Gera um email único.
        ];
    }
}