<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Paquete;

class Dashboard extends Component
{
    public $totalPaquetes;
    public $totalEnviando;
    public $totalDespacho;
    public $totalRecibido;
    public $totalAlmacen;
    public $totalInventario;

    public function mount()
    {
        $this->loadCounts();
    }

    public function loadCounts()
    {
        $this->totalPaquetes   = Paquete::count();
        $this->totalEnviando   = Paquete::where('estado', 'ENVIANDO')->count();
        $this->totalDespacho   = Paquete::where('estado', 'DESPACHO')->count();
        $this->totalRecibido   = Paquete::where('estado', 'RECIBIDO')->count();
        $this->totalAlmacen    = Paquete::where('estado', 'ALMACEN')->count();
        $this->totalInventario = Paquete::where('estado', 'INVENTARIO')->count();
    }

    public function render()
    {
        return view('livewire.dashboard');
    }
}
