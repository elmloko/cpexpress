<?php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Exports\PaquetesExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class Inventario extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $dateFrom;
    public $dateTo;

    public $modal = false;
    public $paquete_id;
    public $codigo;
    public $destinatario;
    public $cuidad;
    public $peso;
    public $observacion;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'       => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad'       => 'nullable|string|max:50',
        'peso'         => 'nullable|numeric',
        'observacion'  => 'nullable|string|max:255',
    ];

    public function mount()
    {
        $this->searchInput = $this->search;
        // Inicializar fechas al mes actual por defecto
        $this->dateFrom = Carbon::now()->startOfMonth()->toDateString();
        $this->dateTo   = Carbon::now()->endOfMonth()->toDateString();
    }

    public function buscar()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function exportarExcel()
    {
        // Validar fechas
        $from = Carbon::parse($this->dateFrom)->startOfDay();
        $to   = Carbon::parse($this->dateTo)->endOfDay();

        return Excel::download(
            new PaquetesExport($this->search, $from, $to),
            "inventario_{$this->dateFrom}_a_{$this->dateTo}.xlsx"
        );
    }

    // Resto de métodos (abrirModal, cerrarModal, guardar, editar, restaurar) idénticos
    public function abrirModal()
    {
        $this->reset(['paquete_id', 'codigo', 'destinatario', 'cuidad', 'peso', 'observacion']);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'codigo'       => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'cuidad'       => strtoupper($this->cuidad),
            'peso'         => $this->peso,
            'observacion'  => strtoupper($this->observacion),
            'estado'       => 'INVENTARIO',
            'user'         => Auth::user()->name,
        ];

        Paquete::updateOrCreate(['id' => $this->paquete_id], $data);

        Evento::create([
            'accion'      => 'EDICION',
            'descripcion' => 'Paquete Editado',
            'user_id'     => Auth::user()->name,
            'codigo'      => $data['codigo'],
        ]);

        session()->flash(
            'message',
            $this->paquete_id
                ? 'Paquete actualizado en Inventario.'
                : 'Paquete agregado a Inventario.'
        );

        $this->cerrarModal();
    }

    public function editar($id)
    {
        // Incluimos también los soft-deleted
        $p = Paquete::withTrashed()->findOrFail($id);

        $this->paquete_id   = $p->id;
        $this->codigo       = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->cuidad       = $p->cuidad;
        $this->peso         = $p->peso;
        $this->observacion  = $p->observacion;
        $this->modal        = true;
    }

    public function restaurar($id)
    {
        $p = Paquete::withTrashed()->findOrFail($id);
        $p->restore();
        $p->estado = 'ALMACEN';
        $p->save();

        Evento::create([
            'accion'      => 'ALTA',
            'descripcion' => 'Paquete Restaurado a Almacen',
            'user_id'     => Auth::user()->name,
            'codigo'      => $p->codigo,
        ]);

        session()->flash('message', 'Paquete restaurado y dado de alta.');
        $this->resetPage();
    }

    public function render()
    {
            $paquetes = Paquete::onlyTrashed()
            ->where('estado', 'INVENTARIO')
            ->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cuidad', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%")
            )
            ->orderBy('deleted_at', 'desc')
            ->paginate(10);

        return view('livewire.inventario', compact('paquetes'));
    }
}
