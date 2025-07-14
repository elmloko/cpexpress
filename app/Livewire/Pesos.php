<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Peso;
use Livewire\WithPagination;

class Pesos extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $modal = false;
    public $min, $max, $peso_id;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    protected $rules = [
        'min' => 'required|numeric|min:0',
        'max' => 'required|numeric|gt:min',
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
        $this->reset(['min', 'max', 'peso_id']);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        Peso::updateOrCreate(
            ['id' => $this->peso_id],
            [
                'min' => $this->min,
                'max' => $this->max,
            ]
        );

        session()->flash('message', $this->peso_id ? 'Peso actualizado correctamente.' : 'Peso registrado correctamente.');
        $this->cerrarModal();
    }

    public function editar($id)
    {
        $peso = Peso::findOrFail($id);
        $this->peso_id = $peso->id;
        $this->min = $peso->min;
        $this->max = $peso->max;
        $this->modal = true;
    }

    public function eliminar($id)
    {
        Peso::findOrFail($id)->delete();
        session()->flash('message', 'Peso eliminado correctamente.');
    }

    public function render()
    {
        $pesos = Peso::where('min', 'like', '%' . $this->search . '%')
            ->orWhere('max', 'like', '%' . $this->search . '%')
            ->orderBy('min', 'asc')
            ->paginate(100);

        return view('livewire.pesos', [
            'pesos' => $pesos
        ]);
    }
}
