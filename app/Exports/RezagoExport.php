<?php

namespace App\Exports;

use App\Models\Paquete;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class RezagoExport implements FromCollection, WithHeadings
{
    protected $search;
    protected $dateFrom;
    protected $dateTo;

    public function __construct($search, $dateFrom, $dateTo)
    {
        $this->search = $search;
        $this->dateFrom = $dateFrom;
        $this->dateTo = $dateTo;
    }

    public function collection()
    {
        return Paquete::where('estado', 'REZAGO')
            ->whereBetween('created_at', [$this->dateFrom, $this->dateTo])
            ->where(function ($query) {
                $query->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('destinatario', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->get([
                'codigo',
                'destinatario',
                'peso',
                'telefono',
                'cuidad',
                'observacion',
                'created_at'
            ])
            ->map(function ($paquete) {
                // Aseguramos que devuelva string formateado
                $paquete->created_at = Carbon::parse($paquete->created_at)
                    ->setTimezone('America/La_Paz')
                    ->format('Y-m-d H:i');

                return [
                    'codigo'       => $paquete->codigo,
                    'destinatario' => $paquete->destinatario,
                    'peso'         => $paquete->peso,
                    'telefono'     => $paquete->telefono,
                    'cuidad'       => $paquete->cuidad,
                    'observacion'  => $paquete->observacion,
                    'created_at'   => $paquete->created_at, // ya es string
                ];
            });
    }


    public function headings(): array
    {
        return [
            'Código',
            'Destinatario',
            'Peso (kg)',
            'Teléfono',
            'Ciudad',
            'Observaciones',
            'Fecha Registro',
        ];
    }
}
