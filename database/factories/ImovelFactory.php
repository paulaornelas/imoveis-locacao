<?php

namespace Database\Factories;

use App\Models\Imovel;
use App\Models\Proprietario; // Importa o modelo Proprietario
use Illuminate\Database\Eloquent\Factories\Factory;

class ImovelFactory extends Factory
{
    // Cria a factory: > php artisan make:factory ImovelFactory --model=Imovel

    protected $model = Imovel::class; // Define qual modelo a factory vai gerar. 


    public function definition() // Método que define como os dados fictícios serão gerados.
    {
        return [
            'endereco' => $this->faker->address, // Gera um endereço aleatório.
            'valor' => $this->faker->randomFloat(2, 100000, 1000000), // Gera um valor aleatório entre 100.000 e 1.000.000.
            'proprietario_id' => Proprietario::factory(), // Cria um proprietário vinculado.
        ];
    }
}