<?php

namespace App\Exports;

use App\Models\Paquete;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Carbon\Carbon;

class PaquetesExport implements FromQuery, WithHeadings
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
        return Paquete::onlyTrashed()
            ->select('codigo','destinatario','cuidad','peso','precio','estado','observacion','deleted_at')
            ->where('estado', 'INVENTARIO')
            ->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                  ->orWhere('destinatario', 'like', "%{$this->search}%")
                  ->orWhere('cuidad', 'like', "%{$this->search}%");
            })
            ->whereBetween('deleted_at', [$this->from, $this->to])
            ->orderBy('deleted_at', 'desc');
    }

    public function headings(): array
    {
        return [
            'Código', 'Destinatario', 'Ciudad',
            'Peso (kg)', 'Precio (Bs)', 'Estado',
            'Observación', 'Fecha Baja',
        ];
    }
}
