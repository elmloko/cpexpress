<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;


class DashboardController extends Controller
{
    public function index(Request $request)
    {
        $totalPaquetes   = Paquete::count();
        $totalRecibido   = Paquete::where('estado', 'RECIBIDO')->count();
        $totalInventario = Paquete::where('estado', 'INVENTARIO')->count();
        $totalRezago     = Paquete::where('estado', 'REZAGO')->count();
        $totalAlmacen    = Paquete::where('estado', 'ALMACEN')->count();
        $totalDespacho   = Paquete::where('estado', 'DESPACHO')->count();

        $destinoData = Paquete::select('destino', DB::raw('count(*) as total'))
            ->groupBy('destino')
            ->orderBy('total', 'desc')
            ->get();

        $destinoLabels = $destinoData->pluck('destino')->map(fn($d) => $d ?? 'N/A')->toArray();
        $destinoTotals = $destinoData->pluck('total')->toArray();

        return view('dashboard', compact(
            'totalPaquetes',
            'totalRecibido',
            'totalInventario',
            'totalRezago',
            'totalAlmacen',
            'totalDespacho',
            'destinoLabels',
            'destinoTotals'
        ));
    }

    /**
     * Retorna JSON con labels y data (conteo por día) para un estado.
     * Parámetros GET: state, start_date, end_date
     */
    public function stateStats(Request $request)
    {
        $allowed = ['RECIBIDO', 'INVENTARIO', 'REZAGO', 'ALMACEN', 'DESPACHO'];

        $request->validate([
            'state' => ['required', 'string'],
            'start_date' => ['required', 'date'],
            'end_date'   => ['required', 'date'],
        ]);

        $state = strtoupper($request->query('state'));
        if (! in_array($state, $allowed)) {
            return response()->json(['error' => 'Estado no permitido'], 422);
        }

        $start = Carbon::parse($request->query('start_date'))->startOfDay();
        $end   = Carbon::parse($request->query('end_date'))->endOfDay();

        // Obtener conteos agrupados por fecha (YYYY-MM-DD)
        $rows = Paquete::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('estado', $state)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date'); // collection date => total

        // Crear periodo de fechas completo para llenar ceros donde no existan datos
        $period = CarbonPeriod::create($start->toDateString(), $end->toDateString());
        $labels = [];
        $data   = [];

        foreach ($period as $day) {
            $d = $day->format('Y-m-d');
            $labels[] = $d;
            $data[]   = (int) ($rows[$d] ?? 0);
        }

        return response()->json([
            'labels' => $labels,
            'data'   => $data,
            'state'  => $state,
        ]);
    }
    public function estadisticaEstado($estado)
    {
        $data = Paquete::select(
            DB::raw('DATE(created_at) as fecha'),
            DB::raw('COUNT(*) as total')
        )
            ->where('estado', $estado)
            ->groupBy('fecha')
            ->orderBy('fecha')
            ->get();

        return response()->json([
            'labels' => $data->pluck('fecha'),
            'data'   => $data->pluck('total')
        ]);
    }

    public function paquetesPorEstadoFecha($estado, $fecha)
    {
        return Paquete::where('estado', $estado)
            ->whereDate('created_at', $fecha)
            ->get();
    }
    public function kardex(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        // Aquí filtramos los paquetes
        $packages = Paquete::whereBetween('created_at', [$start, $end])
            ->orderBy('created_at', 'asc')
            ->get();

        // Generar el PDF usando tu plantilla pdf/kardex.blade.php
        $pdf = Pdf::loadView('pdf.kardex', [
            'packages'   => $packages,
            'start_date' => $start,
            'end_date'   => $end
        ])->setPaper('A4', 'portrait');

        // Descargar con nombre dinámico
        return $pdf->download("kardex_{$start->format('Ymd')}_{$end->format('Ymd')}.pdf");
    }
}
