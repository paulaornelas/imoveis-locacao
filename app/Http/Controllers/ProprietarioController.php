<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Proprietario;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Validation\ValidationException;

class ProprietarioController extends Controller
{
    // Lista todos os proprietários
    public function index()
    {
        try {
            $proprietarios = Proprietario::all(); // Puxa todos os registros da tabela proprietarios.
            return response()->json($proprietarios, 200); // Retorna os proprietários com status 200 (OK).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao listar proprietários.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Armazena um novo proprietário
    public function store(Request $request)
    {
        try {
            $request->validate([ // Valida os dados recebidos na requisição.
                'nome' => 'required|string|max:255', // O nome é obrigatório, deve ser uma string e ter no máximo 255 caracteres.
                'email' => 'required|string|email|max:255|unique:proprietarios', // O email é obrigatório, deve ser um email válido, único e ter no máximo 255 caracteres.
            ]);

            $proprietario = Proprietario::create($request->all()); // Cria um novo registro de proprietário com os dados validados.
            return response()->json($proprietario, 201); // Retorna o novo proprietário com status 201 (Created).
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422); // Retorna erro em caso de falha com status 422 (Unprocessable Entity).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao criar proprietário.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Exibe um proprietário específico
    public function show($id)
    {
        try {
            $proprietario = Proprietario::findOrFail($id); // Tenta encontrar o proprietário pelo ID. 
            return response()->json($proprietario, 200); // Retorna o proprietário com status 200 (OK).
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Proprietário não encontrado.'], 404); // Retorna erro se o proprietário não for encontrado com status 404 (Not Found).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao buscar proprietário.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Atualiza um proprietário específico
    public function update(Request $request, $id)
    {
        try {
            $request->validate([ // Valida os dados recebidos na requisição.
                'nome' => 'required|string|max:255', // O nome é obrigatório, deve ser uma string e ter no máximo 255 caracteres.
                'email' => 'required|string|email|max:255|unique:proprietarios,email,' . $id, // O email é obrigatório, deve ser um email válido, único (exceto para o usuário com esse $id) e ter no máximo 255 caracteres.
            ]);

            $proprietario = Proprietario::findOrFail($id); // Tenta encontrar o proprietário pelo ID. 
            $proprietario->update($request->all()); // Atualiza o registro do proprietário com os dados validados.
            return response()->json($proprietario, 200); // Atualiza o registro do proprietário com os dados validados.
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Proprietário não encontrado.'], 404); // Retorna erro se o proprietário não for encontrado com status 404 (Not Found).
        } catch (ValidationException $e) {
            return response()->json(['error' => $e->validator->errors()], 422); // Retorna erro se o proprietário não for encontrado com status 404 (Not Found).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao atualizar proprietário.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }

    // Remove um proprietário específico
    public function destroy($id)
    {
        try {
            $proprietario = Proprietario::findOrFail($id); // Tenta encontrar o proprietário pelo ID.
            $proprietario->delete(); // Remove o registro do proprietário.
            return response()->json(null, 204); // Retorna status 204 (No Content) para informar que a remoção foi feita.
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Proprietário não encontrado.'], 404); // Retorna erro se o proprietário não for encontrado com status 404 (Not Found).
        } catch (\Exception $e) {
            return response()->json(['error' => 'Erro ao remover proprietário.'], 500); // Retorna erro em caso de falha com status 500 (Internal Server Error).
        }
    }
}