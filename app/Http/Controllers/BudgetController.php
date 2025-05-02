<?php

namespace App\Http\Controllers;

use App\Models\Budget;
use App\Models\Service;
use Illuminate\Http\Request;
use Carbon\Carbon;

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
            'user_id' => 'required|string',
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            // 'content' => 'required|array',  // Você já deve validar como array
        ]);


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
        $validated = $request->validate([
            'name' => 'required|string',
            'email' => 'required|email',
            'phone' => 'required|string',
            'price' => 'required|numeric',
            'status' => 'required|integer',
            'content' => 'required|array',
        ]);

        $validated['content'] = json_encode($validated['content']);

        try {
            $budget = Budget::findOrFail($id);
            $budget->update($validated);

            if ($validated['status'] == 2) {
                $dateService = [
                    "user_id" => $budget->user_id ?? null,
                    "budget" => $budget->id ?? null,
                    "employer" => $budget->user_id ?? null,
                    "name" => $budget->name,
                    "method_payment" => null,
                    "price" => $budget->price,
                    "status" => 1,
                    "contract" => null,
                    "data" => now()->format('Y-m-d H:i:s'),
                    "obs" => null,
                    "start" => null,
                    "end" => null,
                    "updated_at" => now()->format('Y-m-d H:i:s')
                ];
            }
            $service = Service::create($dateService);

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
