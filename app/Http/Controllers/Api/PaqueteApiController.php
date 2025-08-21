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
            ->get()
            ->map(function ($p) {
                return [
                    'id'                => $p->id,
                    'codigo'            => $p->codigo,
                    'destinatario'      => $p->destinatario,
                    'estado'            => $p->estado,
                    'cuidad'            => $p->cuidad,
                    'peso'              => $p->peso,
                    'precio'            => $p->precio,
                    'destino'           => $p->destino,
                    'user'              => $p->user,
                    'observacion'       => $p->observacion,
                    'photo'             => $p->photo,
                    'cantidad'          => $p->cantidad,
                    'created_at'        => Carbon::parse($p->created_at)->format('d-m-Y H:i:s'),
                    'updated_at'        => Carbon::parse($p->updated_at)->format('d-m-Y H:i:s'),
                    'deleted_at'        => $p->deleted_at ? Carbon::parse($p->deleted_at)->format('d-m-Y H:i:s') : null,
                    'aduana'            => $p->aduana,
                    'direccion_paquete' => $p->direccion_paquete,
                    'telefono'          => $p->telefono,
                    'correo_destinatario' => $p->correo_destinatario,
                    'casilla'           => $p->casilla,
                    'precio_final'      => $p->precio_final,
                    'notificado'        => $p->notificado,
                    'factura'           => $p->factura,
                ];
            });

        return response()->json([
            'status' => 'success',
            'data'   => $paquetes
        ]);
    }



    public function darBaja(Request $request)
    {
        $codigos = $request->input('codigos'); // Recibimos los códigos

        if (empty($codigos) || !is_array($codigos)) {
            return response()->json(['message' => 'No se enviaron códigos válidos'], 400);
        }

        // Buscamos los paquetes por código
        $packages = Paquete::whereIn('codigo', $codigos)->get();

        if ($packages->isEmpty()) {
            return response()->json(['message' => 'No se encontraron paquetes con esos códigos'], 404);
        }

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
                'user_id'     => optional(auth('sanctum')->user())->name ?? 'API',
                'codigo'      => $p->codigo,
            ]);
        }

        return response()->json(['message' => 'Paquetes dados de baja correctamente']);
    }
}
