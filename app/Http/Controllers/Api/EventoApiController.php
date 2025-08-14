<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Evento;
use Carbon\Carbon;

class EventoApiController extends Controller
{
    // Obtener todos los eventos de un paquete según su código

    public function eventosPorCodigo(Request $request)
    {
        $request->validate([
            'codigo' => 'required|string|max:50',
        ]);

        $codigo = $request->input('codigo');

        $eventos = Evento::where('codigo', $codigo)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($evento) {
                return [
                    'id'          => $evento->id,
                    'accion'      => $evento->accion,
                    'user_id'     => $evento->user_id,
                    'codigo'      => $evento->codigo,
                    'descripcion' => $evento->descripcion,
                    'created_at'  => Carbon::parse($evento->created_at)->format('d-m-Y H:i:s'),
                    'updated_at'  => Carbon::parse($evento->updated_at)->format('d-m-Y H:i:s'),
                ];
            });

        if ($eventos->isEmpty()) {
            return response()->json([
                'message' => 'No se encontraron eventos para este código'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'codigo' => $codigo,
            'data'   => $eventos
        ]);
    }
}
