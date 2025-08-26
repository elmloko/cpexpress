<?php

namespace App\Http\Controllers;

use App\Models\Paquete;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Carbon\CarbonPeriod;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\KardexExport;
use Illuminate\Support\Facades\Auth;


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

        $rows = Paquete::select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as total'))
            ->where('estado', $state)
            ->whereBetween('created_at', [$start, $end])
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->pluck('total', 'date');

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

    /*  public function kardex(Request $request)
    {
        $user = Auth::user();

        // Validar fechas
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        // Query base
        $query = Paquete::whereBetween('created_at', [$start, $end]);

        // Si es administrador -> solo paquetes en estado INVENTARIO
        if ($user && $user->hasRole('Administrador')) {
            $query->where('estado', 'INVENTARIO');
        }

        // Si no es admin -> forzar solo paquetes del día actual
        if ($user && !$user->hasRole('Administrador')) {
            $query->whereDate('created_at', now());
        }

        $packages = $query->orderBy('created_at', 'asc')->get();

        $fechaHoy = now()->format('d/m/Y');

        return Excel::download(
            new KardexExport($fechaHoy, $packages),
            "Kardex_Inventario_{$start->format('Y-m-d')}_{$end->format('Y-m-d')}.xlsx"
        );
    } */



    /* public function exportKardex(Request $request)
    {
        // Si no es admin -> forzar fechas al día actual
        if (!Auth::user()->hasRole('Administrador')) {
            $request->merge([
                'start_date' => now()->format('Y-m-d'),
                'end_date'   => now()->format('Y-m-d')
            ]);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        $query = Paquete::whereBetween('created_at', [$start, $end]);

        // Si es administrador -> solo INVENTARIO
        if (Auth::user()->hasRole('Administrador')) {
            $query->where('estado', 'INVENTARIO');
        }

        $packages = $query->orderBy('created_at', 'asc')->get();
        $fechaHoy = now()->format('d/m/Y');

        return Excel::download(
            new KardexExport($fechaHoy, $packages),
            "Kardex_Inventario_{$start->format('Y-m-d')}_{$end->format('Y-m-d')}.xlsx"
        );
    } */




    public function exportKardexTodos()
    {
        $packages = Paquete::onlyTrashed()
            ->whereDate('deleted_at', now())
            ->orderBy('deleted_at')
            ->get();

        $fechaHoy = now()->format('Y-m-d');

        return Excel::download(
            new KardexExport($fechaHoy, $packages),
            "Kardex_Bajas_{$fechaHoy}.xlsx"
        );
    }


    public function exportKardexAdmin(Request $request)
    {
        if ($request->has('date')) {
            $request->merge([
                'start_date' => $request->date,
                'end_date'   => $request->date
            ]);
        }

        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date',
        ]);

        $start = Carbon::parse($request->start_date)->startOfDay();
        $end   = Carbon::parse($request->end_date)->endOfDay();

        $packages = Paquete::onlyTrashed()
            ->whereBetween('deleted_at', [$start, $end])
            ->orderBy('deleted_at')
            ->get();

        return Excel::download(
            new KardexExport(
                now()->format('Y-m-d'),
                $packages
            ),
            "Kardex_Admin_{$start->format('Y-m-d')}_{$end->format('Y-m-d')}.xlsx"
        );
    }
}
