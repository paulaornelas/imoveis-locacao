<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Proprietario;

class ProprietarioSeeder extends Seeder
{
    // Cria a seeder: > php artisan make:seeder ProprietarioSeeder
    
    public function run()
    {
        // Chama a factory e cria 10 proprietários e salva no banco de dados.
        Proprietario::factory()->count(10)->create();
    }
}