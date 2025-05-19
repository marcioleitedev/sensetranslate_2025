<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use function Illuminate\Log\log;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $query = Service::with(['budget', 'employer']);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('method_payment', 'like', "%{$search}%")
                    ->orWhere('status', 'like', "%{$search}%");
            })->orderBy('created_at', 'desc');
        }

        $services = $query->orderBy('created_at', 'desc')->paginate(10);

        return response()->json($services);
    }


    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
        ]);

        return Service::create($validated);
    }

    public function update(Request $request)
    {
        // Validação dos dados recebidos
        $validated = $request->validate([
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'nullable|numeric',
            'status' => 'nullable|integer',
            'method_payment' => 'nullable|string',
            'start' => 'nullable|date',
            'end' => 'nullable|date',
            'contract' => 'nullable|string',
            'obs' => 'nullable|string',
        ]);

        $service = Service::where('id', $validated['id'])->first();

        // Atualiza o serviço com os dados validados
        $service->update($validated);

        // Registra no log para depuração
        Log::info('Serviço atualizado:', $service->toArray());

        // Retorna o serviço atualizado como resposta JSON
        return response()->json([
            'message' => 'Serviço atualizado com sucesso.',
            'service' => $service,
        ]);
    }

    public function destroy($id)
    {
        $service = Service::where('id', $id);
        $service->delete();
        return response()->json([
            'message' => 'Orçamento removido com sucesso.'
        ]);
    }
}
