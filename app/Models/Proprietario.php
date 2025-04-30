<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Proprietario extends Model
{
    // Cria o model: > php artisan make:model Proprietario
    use HasFactory; // Habilita o uso de factories.

    protected $fillable = ['nome', 'email']; // Define quais atributos podem ser preenchidos em massa.

    // Define o relacionamento com o modelo Imovel.
    public function imoveis()
    {
        return $this->hasMany(Imovel::class); // Indica que um proprietário pode ter muitos imóveis.
    }
    
}

