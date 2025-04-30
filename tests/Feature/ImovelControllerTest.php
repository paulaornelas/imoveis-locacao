<?php

namespace Tests\Feature;

use App\Models\Imovel;
use App\Models\Proprietario;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ImovelControllerTest extends TestCase
{
    // Cria o arquivo de teste: > php artisan make:test ImovelControllerTest
    use RefreshDatabase; // Limpa o banco de dados entre os testes.

    /** @test */
    public function it_can_create_an_imovel() // Teste que verifica se um imóvel pode ser criado.
    {
        // Cria um proprietário para associar ao imóvel
        $proprietario = Proprietario::factory()->create(); // Usa a factory para criar um novo proprietário no banco de dados.

        // Faz uma requisição POST para a rota /api/imoveis com os dados do novo imóvel.
        $response = $this->postJson('/api/imoveis', [
            'endereco' => 'Rua Platina, 1375',
            'valor' => 300000.00,
            'proprietario_id' => $proprietario->id,
        ]);

        // Verifica se a resposta da requisição deu certo (status 201) e se os dados retornados estão corretos.
        $response->assertStatus(201)
                 ->assertJson([
                     'endereco' => 'Rua Platina, 1375',
                     'valor' => 300000.00,
                     'proprietario_id' => $proprietario->id,
                 ]);

        // Verifica se o imóvel foi realmente salvo no banco de dados com os dados corretos.
        $this->assertDatabaseHas('imoveis', [
            'endereco' => 'Rua Platina, 1375',
            'valor' => 300000.00,
            'proprietario_id' => $proprietario->id,
            // Verifica se existe um registro na tabela 'imoveis' com o endereço, valor e proprietário correto.
        ]);
    }

    /** @test */
    public function it_validates_required_fields_when_creating_an_imovel() // Teste que verifica a validação dos campos obrigatórios no momento de criar um imóvel.
    {
        $response = $this->postJson('/api/imoveis', []); // Faz uma requisição POST para a rota /api/imoveis sem dados.

        $response->assertStatus(422) // Verifica se a resposta  foi um erro (status 422) e se os campos obrigatórios estão sendo validados corretamente.
                 ->assertJsonValidationErrors(['endereco', 'valor', 'proprietario_id']); // // Verifica se os erros de validação incluem os campos endereco, valor e proprietario_id.
    }
}