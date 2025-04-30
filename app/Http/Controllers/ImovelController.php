<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Imovel;
use App\Models\Proprietario;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ImovelController extends Controller
{
    // Lista todos os imóveis
    public function index()
    {
        try {
            $imoveis = Imovel::with('proprietario')->get(); // Puxa todos os imóveis com os dados dos proprietários.
            return response()->json($imoveis, 200); // Retorna os imóveis com status 200 (OK).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar imóveis.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Armazena um novo imóvel
    public function store(Request $request)
    {
        try {
            $request->validate([ // Valida os dados recebidos na requisição.
                'endereco' => 'required|string', // o endereço é obrigatório e deve ser uma string.
                'valor' => 'required|numeric', // O valor é obrigatório e deve ser um número.
                'proprietario_id' => 'required|exists:proprietarios,id', // O ID do proprietário é obrigatório e deve existir na tabela proprietarios.
            ]);

            $imovel = Imovel::create($request->all()); // Cria um novo registro de Imovel com os dados validados.
            return response()->json($imovel, 201); // Retorna o novo imóvel com status 201 (Created).
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422); // Retorna erro em caso de falha com status 422 (Unprocessable Entity).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar imóvel.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Exibe um imóvel específico
    public function show($id)
    {
        try {
            $imovel = Imovel::with('proprietario')->findOrFail($id); // Tenta encontrar o imóvel pelo ID.
            return response()->json($imovel, 200); // Retorna o imóvel com status 200 (OK).
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);  // Retorna erro se o imóvel não for encontrado com status 404 (Not Found).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar imóvel.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Atualiza um imóvel específico
    public function update(Request $request, $id)
    {
        try { // Valida os dados recebidos na requisição.
            $request->validate([
                'endereco' => 'required|string', // O endereço é obrigatório e deve ser uma string.
                'valor' => 'required|numeric', // O valor é obrigatório e deve ser um número.
                'proprietario_id' => 'required|exists:proprietarios,id', // O ID do proprietário é obrigatório e deve existir na tabela proprietarios.
            ]);

            $imovel = Imovel::findOrFail($id); // Tenta encontrar o imóvel pelo ID. 
            $imovel->update($request->all()); // Atualiza o registro do imóvel com os dados validados.
            return response()->json($imovel, 200); // Retorna o imóvel atualizado em formato JSON com status 200
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404); // Retorna erro se o imóvel não for encontrado com status 404 (Not Found).
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422); // Retorna erro em caso de falha com status 422 (Unprocessable Entity).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar imóvel.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Remove um imóvel específico
    public function destroy($id)
    {
        try {
            $imovel = Imovel::findOrFail($id); // Tenta encontrar o imóvel pelo ID.
            $imovel->delete(); // Remove o registro do imóvel.
            return response()->json(null, 204); // Retorna status 204 (No Content) para informar que a remoção foi feita.
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404); // Retorna erro se o imóvel não for encontrado com status 404 (Not Found).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover imóvel.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    public function filter(Request $request) // GET /api/imoveis/filter?valor_minimo=100000&valor_maximo=500000
    {
        try {
            $query = Imovel::with('proprietario'); // Inicia a consulta na tabela de imóveis, incluindo a relação com o modelo de proprietário.

            // Aplica os filtros se estiverem presentes na requisição.
            if ($request->has('valor_minimo')) { // Verifica se o parâmetro 'valor_minimo' foi enviado na requisição.
                $query->where('valor', '>=', $request->input('valor_minimo')); // Adiciona uma condição para filtrar imóveis com valor maior ou igual ao valor mínimo.
            }

            if ($request->has('valor_maximo')) { // Verifica se o parâmetro 'valor_maximo' foi enviado na requisição.
                $query->where('valor', '<=', $request->input('valor_maximo')); // Adiciona uma condição para filtrar imóveis com valor menor ou igual ao valor máximo.
            }

            $imoveis = $query->get(); // Executa a consulta e puxa todos os imóveis que atendem aos critérios de filtragem.

            return response()->json($imoveis, 200); // Retorna o imóvel com status 200 (OK).
        } catch (\Exception $e) { 
            return response()->json(['error' => 'Erro ao filtrar imóveis.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }
}

