<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ImovelController extends Controller
{
    // Lista todos os imóveis junto com o proprietário
    public function index()
    {
        try {
            // Busca todos imóveis e carrega dados do proprietário
            $imoveis = Imovel::with('proprietario')->get();
            return response()->json($imoveis, 200); // Retorna como JSON
        } catch (\Exception $e) {
            // Em caso de erro retorna mensagem genérica
            return response()->json(['error' => 'Erro ao listar imóveis.'], 500);
        }
    }

    // Cria um novo imóvel
    public function store(Request $request)
    {
        try {
            // Valida os dados da requisição
            $request->validate([
                'endereco' => 'required|string',
                'valor' => 'required|numeric',
                'proprietario_id' => 'required|exists:proprietarios,id',
            ]);
            // Cria o imóvel usando os dados enviados
            $imovel = Imovel::create($request->all());
            return response()->json($imovel, 201); // Retorna imóvel criado com status 201
        } catch (ValidationException $e) {
            throw $e; // Deixa o Laravel retornar o erro de validação padrão
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar imóvel.'], 500);
        }
    }

    // Retorna um imóvel específico
    public function show($id)
    {
        try {
            // Busca imóvel pelo ID e carrega o proprietário
            $imovel = Imovel::with('proprietario')->findOrFail($id);
            return response()->json($imovel, 200);
        } catch (ModelNotFoundException $e) {
            // Caso não encontre o imóvel retorna erro 404
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar imóvel.'], 500);
        }
    }

    // Atualiza um imóvel existente
    public function update(Request $request, $id)
    {
        try {
            // Valida os dados enviados
            $request->validate([
                'endereco' => 'required|string',
                'valor' => 'required|numeric',
                'proprietario_id' => 'required|exists:proprietarios,id',
            ]);
            // Busca o imóvel pelo ID
            $imovel = Imovel::findOrFail($id);
            // Atualiza os dados do imóvel
            $imovel->update($request->all());
            return response()->json($imovel, 200);
        } catch (ValidationException $e) {
            throw $e; // Deixa o Laravel retornar o erro de validação padrão
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar imóvel.'], 500);
        }
    }

    // Remove um imóvel
    public function destroy($id)
    {
        try {
            // Busca o imóvel pelo ID
            $imovel = Imovel::findOrFail($id);
            // Remove o imóvel do banco de dados
            $imovel->delete();
            return response()->json(null, 204); // Retorna sucesso, sem conteúdo
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover imóvel.'], 500);
        }
    }

    // Filtra imóveis por valor mínimo, máximo e cidade
    public function filter(Request $request)
    {
        try {
            // Começa a query já incluindo proprietário
            $query = Imovel::with('proprietario');

            // Filtra pelo valor mínimo, se informado
            if ($request->has('valor_minimo')) {
                $query->where('valor', '>=', $request->input('valor_minimo'));
            }
            // Filtra pelo valor máximo, se informado
            if ($request->has('valor_maximo')) {
                $query->where('valor', '<=', $request->input('valor_maximo'));
            }
            // Filtra pela cidade, se informada e não for vazia
            if ($request->has('cidade') && $request->filled('cidade')) {
                // Remove espaços e quebras de linha da cidade para evitar problemas de comparação
                $cidade = trim(preg_replace('/\s+/', ' ', $request->input('cidade')));
                $query->whereRaw(
                    "REPLACE(REPLACE(REPLACE(endereco, CHAR(13), ''), CHAR(10), ''), ' ', '') LIKE ?",
                    ['%' . str_replace(' ', '', $cidade) . '%']
                );
            }

            // Executa a busca e retorna o resultado
            $imoveis = $query->get();
            return response()->json($imoveis, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao filtrar imóveis.'], 500);
        }
    }
}
