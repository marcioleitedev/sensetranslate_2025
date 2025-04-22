<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use App\Models\User;
use App\Mail\SendUserPassword;
use Illuminate\Support\Facades\Mail;

class UsuariosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $lista = User::paginate(10);
        return $lista;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // 1. Validar os dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
        ]);
    
        // 2. Gerar senha aleatória
        $plainPassword = Str::random(10); // Ex: "k8Pz0aFJx2"
    
        // 3. Criar o usuário com senha criptografada
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($plainPassword),
        ]);
    
        // 4. Enviar e-mail com a senha para o usuário
        Mail::to($user->email)->send(new SendUserPassword($user, $plainPassword));
    
        return response()->json([
            'message' => 'Usuário criado com sucesso. A senha foi enviada por e-mail.',
            'user' => $user
        ], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validação dos dados (personalize conforme necessário)
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email,' . $id,
                'level' => 'required|integer|in:1,2,3',
            ]);
    
            // Busca o usuário
            $user = User::find($id);
    
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'message' => 'Usuário não encontrado.'
                ], 404);
            }
    
            // Atualiza os dados
            $user->update($validated);
    
            return response()->json([
                'success' => true,
                'message' => 'Usuário atualizado com sucesso.',
                'user' => $user
            ], 200);
    
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Retorna erro de validação
            return response()->json([
                'success' => false,
                'errors' => $e->errors()
            ], 422);
    
        } catch (\Exception $e) {
            // Erros inesperados
            return response()->json([
                'success' => false,
                'message' => 'Erro ao a
                ',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // 1. Encontrar o usuário pelo ID
    $user = User::find($id);

    // 2. Verificar se o usuário foi encontrado
    if (!$user) {
        // Se não encontrar o usuário, retorna uma resposta de erro
        return response()->json([
            'message' => 'Usuário não encontrado.'
        ], 404);
    }

    // 3. Excluir o usuário
    $user->delete();

    // 4. Retornar resposta de sucesso
    return response()->json([
        'message' => 'Usuário excluído com sucesso.'
    ], 200);
    }
}
