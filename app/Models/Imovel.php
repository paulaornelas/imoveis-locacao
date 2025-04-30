<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Imovel extends Model
{
    // Cria o model: > php artisan make:model Imovel
    use HasFactory;

    protected $table = 'imoveis'; // Define o nome da tabela associada a este modelo.
    protected $fillable = ['endereco', 'valor', 'proprietario_id'];  // Define quais atributos podem ser preenchidos em massa.

    // Define o relacionamento com o modelo Proprietario.
    public function proprietario()
    {
        return $this->belongsTo(Proprietario::class); // Indica que um imóvel pertence a um proprietário.
    }
    
}