<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Imovel;

class ImovelSeeder extends Seeder
{
    // Cria a seeder: > php artisan make:seeder ImovelSeeder

    public function run()
    {
        // Chama a factory e cria 10 imóveis.
        Imovel::factory()->count(10)->create();  
    }
}