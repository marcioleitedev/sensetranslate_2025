<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use Illuminate\Http\Request;

class BudgetController extends Controller
{
    /**
     * Exibe a lista de orçamentos com paginação.
     */
    public function index(Request $request)
    {
        try {
            $query = Budget::query();

            if ($request->has('search') && !empty($request->search)) {
                $search = $request->search;
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                });
            }

            $budgets = $query->orderBy('id', 'desc')->paginate(10);
            return response()->json($budgets);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao buscar orçamentos.',
                'error' => $e->getMessage()
            ], 500);
        }
    }


    /**
     * Cria um novo orçamento.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            'content' => 'required|array',  // Você já deve validar como array
        ]);

        // Converta o conteúdo para string JSON
        $validated['content'] = json_encode($validated['content']);  // Converte para JSON


        try {
            $budget = Budget::create($validated);

            return response()->json([
                'message' => 'Orçamento criado com sucesso.',
                'budget' => $budget
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar orçamento.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Exibe um orçamento específico.
     */
    public function show($id)
    {
        try {
            $budget = Budget::findOrFail($id);
            return response()->json($budget);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Orçamento não encontrado.',
                'error' => $e->getMessage()
            ], 404);
        }
    }

    /**
     * Atualiza um orçamento.
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            // 'user_id' => 'required|integer',
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            // 'content' => 'required|string',
            // 'price' => 'required|numeric',
            // 'payment_method' => 'required|string',
            // 'status' => 'required|string',
            // 'data' => 'required|date',
        ]);

        try {
            $budget = Budget::findOrFail($id);
            $budget->update($request->all());

            return response()->json([
                'message' => 'Orçamento atualizado com sucesso.',
                'budget' => $budget
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar orçamento.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove um orçamento.
     */
    public function destroy($id)
    {
        try {
            $budget = Budget::findOrFail($id);
            $budget->delete();

            return response()->json([
                'message' => 'Orçamento removido com sucesso.'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao remover orçamento.',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
