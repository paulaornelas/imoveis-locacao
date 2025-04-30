<?php

namespace App\Http\Controllers;

use App\Models\Imovel;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ImovelController extends Controller
{
    public function index()
    {
        try {
            $imoveis = Imovel::with('proprietario')->get();
            return response()->json($imoveis, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar imóveis.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $request->validate([
                'endereco' => 'required|string',
                'valor' => 'required|numeric',
                'proprietario_id' => 'required|exists:proprietarios,id',
            ]);
            $imovel = Imovel::create($request->all());
            return response()->json($imovel, 201);
        } catch (ValidationException $e) {
            throw $e;
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar imóvel.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $imovel = Imovel::with('proprietario')->findOrFail($id);
            return response()->json($imovel, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar imóvel.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $request->validate([
                'endereco' => 'required|string',
                'valor' => 'required|numeric',
                'proprietario_id' => 'required|exists:proprietarios,id',
            ]);
            $imovel = Imovel::findOrFail($id);
            $imovel->update($request->all());
            return response()->json($imovel, 200);
        } catch (ValidationException $e) {
            throw $e;
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar imóvel.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $imovel = Imovel::findOrFail($id);
            $imovel->delete();
            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Imóvel não encontrado.'], 404);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover imóvel.'], 500);
        }
    }

    public function filter(Request $request)
    {
        try {
            $query = Imovel::with('proprietario');
            if ($request->has('valor_minimo')) {
                $query->where('valor', '>=', $request->input('valor_minimo'));
            }
            if ($request->has('valor_maximo')) {
                $query->where('valor', '<=', $request->input('valor_maximo'));
            }
            if ($request->has('cidade') && $request->filled('cidade')) {
                $cidade = trim(preg_replace('/\s+/', ' ', $request->input('cidade')));
                $query->whereRaw(
                    "REPLACE(REPLACE(REPLACE(endereco, CHAR(13), ''), CHAR(10), ''), ' ', '') LIKE ?",
                    ['%' . str_replace(' ', '', $cidade) . '%']
                );
            }
            $imoveis = $query->get();
            return response()->json($imoveis, 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao filtrar imóveis.'], 500);
        }
    }
}
