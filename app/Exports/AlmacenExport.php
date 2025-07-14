<?php

namespace App\Exports;

use App\Models\Paquete;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class AlmacenExport implements FromQuery, WithHeadings
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

    public function query()
    {
        return Paquete::query()
            ->select('codigo','destinatario','peso','estado','cuidad','observacion','created_at')
            ->where('estado', 'ALMACEN')
            ->where(function($q){
                $q->where('codigo', 'like', "%{$this->search}%")
                  ->orWhere('cuidad', 'like', "%{$this->search}%")
                  ->orWhere('observacion', 'like', "%{$this->search}%");
            })
            ->whereBetween('created_at', [$this->from, $this->to])
            ->orderBy('created_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Código', 'Empresa', 'Peso (kg)',
            'Estado', 'Ciudad', 'Observaciones', 'Fecha Registro'
        ];
    }
}
