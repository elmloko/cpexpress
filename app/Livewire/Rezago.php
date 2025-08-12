<?php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RezagoExport;


class Rezago extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $dateFrom;
    public $dateTo;
    public $selectAll = false;
    public $selected = [];


    protected $paginationTheme = 'bootstrap';

    public function mount()
    {
        $this->searchInput = $this->search;
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo   = Carbon::now()->endOfMonth()->toDateString();
    }

    public function buscar()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selected = Paquete::where('estado', 'REZAGO')
                ->where(function ($q) {
                    $q->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('destinatario', 'like', "%{$this->search}%")
                        ->orWhere('observacion', 'like', "%{$this->search}%");
                })
                ->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function enviarAlmacenSeleccionados()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No hay paquetes seleccionados.');
            return;
        }

        $paquetes = Paquete::whereIn('id', $this->selected)->get();

        // Cambiar estado a ALMACEN
        Paquete::whereIn('id', $this->selected)->update(['estado' => 'ALMACEN']);

        foreach ($paquetes as $pkg) {
            Evento::create([
                'accion'      => 'REZAGO -> ALMACEN',
                'descripcion' => 'Paquete enviado a ALMACEN desde rezago',
                'user_id'     => Auth::user()->name,
                'codigo'      => $pkg->codigo,
            ]);
        }

        $this->selected  = [];
        $this->selectAll = false;

        session()->flash('message', 'Paquetes enviados a ALMACEN correctamente.');
    }

    public function diasTranscurridos($created_at)
    {
        return Carbon::parse($created_at)->diffInDays(Carbon::now());
    }

    public function render()
    {
        $paquetes = Paquete::where('estado', 'REZAGO')
            ->where(function ($q) {
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('destinatario', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%");
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.rezago', compact('paquetes'));
    }

    public function exportarExcel()
    {
        $from = Carbon::parse($this->dateFrom)->startOfDay();
        $to = Carbon::parse($this->dateTo)->endOfDay();

        return Excel::download(
            new RezagoExport($this->search, $from, $to),
            "paquetes_rezago_{$this->dateFrom}_a_{$this->dateTo}.xlsx"
        );
    }
}
