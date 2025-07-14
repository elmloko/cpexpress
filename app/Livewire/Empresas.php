<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Empresa;
use Livewire\WithPagination;

class Empresas extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $modal = false;
    public $nombre, $tipo, $empresa_id;

    protected $paginationTheme = 'bootstrap';

    protected $updatesQueryString = ['search'];

    protected $rules = [
        'nombre' => 'required|string|max:50',
        'tipo'   => 'required|string|max:50',
    ];

    public function mount()
    {
        $this->searchInput = $this->search;
    }

    public function buscar()
    {
        $this->search = $this->searchInput;
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['nombre', 'tipo', 'empresa_id']);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        Empresa::updateOrCreate(
            ['id' => $this->empresa_id],
            [
                'nombre' => strtoupper($this->nombre),
                'tipo'   => strtoupper($this->tipo),
            ]
        );

        $mensaje = $this->empresa_id ? 'Empresa actualizada correctamente.' : 'Empresa registrada correctamente.';
        session()->flash('message', $mensaje);

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $empresa = Empresa::findOrFail($id);
        $this->empresa_id = $empresa->id;
        $this->nombre = strtoupper($empresa->nombre);
        $this->tipo = strtoupper($empresa->tipo);
        $this->modal = true;
    }

    public function eliminar($id)
    {
        $empresa = Empresa::findOrFail($id);
        $empresa->delete();

        session()->flash('message', 'Empresa eliminada correctamente.');
    }

    public function render()
    {
        $empresas = Empresa::where('nombre', 'like', '%' . $this->search . '%')
            ->orWhere('tipo', 'like', '%' . $this->search . '%')
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.empresas', [
            'empresas' => $empresas
        ]);
    }
}
