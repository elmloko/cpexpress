<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paquete;
use Illuminate\Support\Facades\DB;
use PDF;

class DashboardController extends Controller
{
    public function index()
    {
        // Totales por estado
        $totalPaquetes   = Paquete::count();
        $totalEnviando   = Paquete::where('estado', 'ENVIANDO')->count();
        $totalDespacho   = Paquete::where('estado', 'DESPACHO')->count();
        $totalRecibido   = Paquete::where('estado', 'RECIBIDO')->count();
        $totalAlmacen    = Paquete::where('estado', 'ALMACEN')->count();
        $totalInventario = Paquete::where('estado', 'INVENTARIO')->count();

        // Datos para el gráfico de destino
        $destinos = Paquete::select('destino', DB::raw('count(*) as total'))
            ->groupBy('destino')
            ->get();
        // Convierte a dos arrays simples
        $destinoLabels = $destinos->pluck('destino')->all();
        $destinoTotals = $destinos->pluck('total')->all();

        return view('dashboard', compact(
            'totalPaquetes',
            'totalEnviando',
            'totalDespacho',
            'totalRecibido',
            'totalAlmacen',
            'totalInventario',
            'destinoLabels',
            'destinoTotals'
        ));
    }
    public function kardex(Request $request)
    {
        $request->validate([
            'start_date' => 'required|date',
            'end_date'   => 'required|date|after_or_equal:start_date',
        ]);

        $from = $request->start_date . ' 00:00:00';
        $to   = $request->end_date   . ' 23:59:59';

        $packages = Paquete::withTrashed()                     // trae también los soft-deleted
            ->whereIn('estado', ['INVENTARIO', 'DESPACHADO'])    // filtra ambos estados
            ->whereBetween('created_at', [$from, $to])         // rango de fechas
            ->get();

        // ya puedes pasar $packages al PDF
        $pdf = PDF::loadView('pdf.kardex', compact('packages'));

        return $pdf->stream("kardex_{$request->start_date}_{$request->end_date}.pdf");
    }
}
