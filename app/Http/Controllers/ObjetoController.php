<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Objeto;

class ObjetoController extends Controller
{
    public function index(Request $request)
    {
        $query = Objeto::query();

        if ($request->filled('buscar')) {
            $busqueda = $request->input('buscar');
            $query->where('codigo_activo', 'ILIKE', "%$busqueda%")
                  ->orWhere('nombre', 'ILIKE', "%$busqueda%");
        }

        $objetos = $query->get();

        return view('objetos.index', compact('objetos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'codigo_activo' => 'required|unique:objetos|max:20',
            'nombre' => 'required|max:100',
            'cantidad' => 'required|integer|min:1',
            'area' => 'required|max:50',
        ]);

        Objeto::create($request->all());

        return redirect()->route('objetos.index')->with('success', 'Objeto registrado.');
    }

    public function update(Request $request, $id)
    {
        $objeto = Objeto::findOrFail($id);

        $request->validate([
            'cantidad' => 'required|integer|min:1',
        ]);

        $objeto->cantidad = $request->cantidad;
        $objeto->save();

        return redirect()->route('objetos.index')->with('success', 'Cantidad actualizada.');
    }
}
