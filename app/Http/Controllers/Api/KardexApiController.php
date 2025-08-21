<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paquete;
use Carbon\Carbon;

class KardexApiController extends Controller
{
    public function getBajas(Request $request)
    {
        // Obtener los paquetes eliminados hoy
        $packages = Paquete::onlyTrashed()
            ->whereDate('deleted_at', now())
            ->orderBy('deleted_at')
            ->get();

        // Formatear la respuesta
        $data = $packages->map(function ($p) {
            return [
                'codigo' => $p->codigo,
                'cantidad' => $p->cantidad ?? 1,
                'peso' => $p->peso ?? 0,
                'factura' => $p->factura ?? '',
                'importe' => $p->precio_final ?? $p->precio ?? 0,
                'fecha_baja' => Carbon::parse($p->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'total' => $packages->count(),
            'data' => $data
        ]);
    }
    public function getBajasPorFecha(Request $request)
    {
        // Validar que venga la fecha
        $request->validate([
            'date' => 'required|date'
        ]);

        $fecha = $request->query('date'); // yyyy-mm-dd

        $packages = Paquete::onlyTrashed()
            ->whereDate('deleted_at', $fecha)
            ->orderBy('deleted_at')
            ->get();

        $data = $packages->map(function ($p) {
            return [
                'codigo' => $p->codigo,
                'cantidad' => $p->cantidad ?? 1,
                'peso' => $p->peso ?? 0,
                'factura' => $p->factura ?? '',
                'importe' => $p->precio_final ?? $p->precio ?? 0,
                'fecha_baja' => Carbon::parse($p->deleted_at)->format('Y-m-d H:i:s'),
            ];
        });

        return response()->json([
            'success' => true,
            'fecha' => $fecha,
            'total' => $packages->count(),
            'data' => $data
        ]);
    }
}
