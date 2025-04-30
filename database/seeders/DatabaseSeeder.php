<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Executar as seeders e popular o banco com os dados: > php artisan db:seed

    public function run()
    {
        $this->call([ // Chama outras seeders para serem executadas.
            ProprietarioSeeder::class, // Chama a seeder para criar dados do proprietário.
            ImovelSeeder::class, // Chama a seeder para criar dados do imóvel.
        ]);
    }
}
