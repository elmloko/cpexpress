<?php

namespace App\Exports;

use App\Models\Paquete;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class AlmacenExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $from;
    protected $to;

    public function __construct(string $search, Carbon $from, Carbon $to)
    {
        $this->search = $search;
        $this->from   = $from;
        $this->to     = $to;
    }

    public function collection()
    {
        return Paquete::where('estado', 'ALMACEN')
            ->whereBetween('created_at', [$this->from, $this->to])
            ->where(function($q){
                $q->where('codigo', 'like', "%{$this->search}%")
                  ->orWhere('cuidad', 'like', "%{$this->search}%")
                  ->orWhere('observacion', 'like', "%{$this->search}%");
            })
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($paquete){
                return [
                    'codigo'       => $paquete->codigo,
                    'destinatario' => $paquete->destinatario,
                    'peso'         => $paquete->peso,
                    'precio_final'         => $paquete->precio_final,
                    'estado'       => $paquete->estado,
                    'cuidad'       => $paquete->cuidad,
                    'observacion'  => $paquete->observacion,
                    'factura'      => $paquete->factura,
                    'created_at'   => $paquete->created_at
                                         ->setTimezone('America/La_Paz')
                                         ->format('Y-m-d H:i'),
                ];
            });
    }

    public function headings(): array
    {
        return [
            'Código', 'Empresa', 'Peso (kg)', 'Precio Final',
            'Estado', 'Ciudad', 'Observaciones', 'Factura','Fecha Registro'
        ];
    }
}
