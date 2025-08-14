<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Paquete;
use Illuminate\Http\Request;


use App\Models\Empresa;
use App\Models\Peso;
use App\Models\Tarifario;
use App\Models\Evento;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;


class PaqueteApiController extends Controller
{
    public function index(Request $request)
    {
        $paquetes = Paquete::withTrashed()
            ->orderBy('updated_at', 'desc')
            ->get();

        return response()->json([
            'status' => 'success',
            'data'   => $paquetes
        ]);
    }

    public function darBaja(Request $request)
    {
        $ids = $request->input('ids');

        if (empty($ids) || !is_array($ids)) {
            return response()->json(['message' => 'No se enviaron paquetes válidos'], 400);
        }

        $packages = Paquete::whereIn('id', $ids)->get();

        foreach ($packages as $p) {
            $empresa = Empresa::whereRaw('UPPER(nombre)=?', [strtoupper($p->destinatario)])->first();
            $pesoCat = Peso::where('min', '<=', $p->peso)
                ->where('max', '>=', $p->peso)
                ->first();

            $unit = 0;

            if ($empresa && $pesoCat) {
                $tarifa = Tarifario::where('empresa', $empresa->id)
                    ->where('peso', $pesoCat->id)
                    ->first();

                $col = strtolower($p->destino);
                if ($tarifa && isset($tarifa->$col)) {
                    $unit = $tarifa->$col;
                }
            }

            $dias = Carbon::parse($p->created_at)->diffInDays(Carbon::now());

            $precioFinal = $dias <= 6 ? 17 : 17 + (($dias - 6) * 2);
            $mult = $p->grupo ? $p->cantidad : 1;
            $total = ($unit * $mult) + $precioFinal;

            $p->update([
                'total'        => $total,
                'precio_final' => $precioFinal,
                'estado'       => 'INVENTARIO'
            ]);

            $p->delete();

            Evento::create([
                'accion'      => 'ENTREGADO',
                'descripcion' => 'Paquete Entregado',
                'user_id'     => auth()->check() ? auth()->user()->name : 'API',
                'codigo'      => $p->codigo,
            ]);
        }

        return response()->json(['message' => 'Paquetes dados de baja correctamente']);
    }
}
