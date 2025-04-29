<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Genealogy;
use App\Models\Service;

class GenealogyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Service::whereHas('genealogies') // só serviços que têm genealogias
            ->with(['genealogies' => function ($q) {
                $q->limit(1); // só traz uma genealogia relacionada
            }]);

        // Filtro por nome do serviço, se enviado
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%");
        }

        // Paginação
        $services = $query->paginate(10);

        return response()->json($services);
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {

        $service = Service::where('id', $id)->first();
        $genealogy = Genealogy::where('service', $id)->get();

        return response()->json([
            'service' => $service,
            'genealogy' => $genealogy,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:1,2',
            'origin' => 'required|string',
            'smaller' => 'required|boolean',
        ]);

        Genealogy::create($request->all());
        return back();
    }

    public function update(Request $request, $id)
    {
        $node = Genealogy::findOrFail($id);
        $node->update($request->all());
        return back();
    }

    public function delete($id)
    {
        $node = Genealogy::findOrFail($id);
        $node->delete();
        return back();
    }

    public function getTree($service)
    {
        // dd($service);
        $serviceQuery = Service::where('id', $service)->first();
        $genealogy = Genealogy::where('service', $service)->get();

        return response()->json([
            'service' => $serviceQuery,
            'genealogy' => $genealogy,
        ]);
    }

    // GenealogyController.php
    public function getCleanTree($service)
    {
        $serviceQuery = Service::where('id', $service)->first();
        $genealogy = Genealogy::where('service', $service)->get();

        return response()->json([
            'service' => $serviceQuery,
            'genealogy' => $genealogy,
        ]);
    }
}
