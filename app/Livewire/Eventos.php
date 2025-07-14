<?php
// app/Http/Livewire/Eventos.php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Evento;

class Eventos extends Component
{
    use WithPagination;

    public $search         = '';
    public $searchInput    = '';
    public $modal          = false;
    public $accion, $user_id, $codigo, $descripcion, $evento_id;

    protected $paginationTheme = 'bootstrap';
    protected $updatesQueryString = ['search'];

    protected $rules = [
        'accion'      => 'required|string|max:50',
        'user_id'     => 'required|integer|exists:users,id',
        'codigo'      => 'required|string|max:50',
        'descripcion' => 'nullable|string',
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
        $this->reset(['accion', 'user_id', 'codigo', 'descripcion', 'evento_id']);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        Evento::updateOrCreate(
            ['id' => $this->evento_id],
            [
                'accion'      => $this->accion,
                'user_id'     => $this->user_id,
                'codigo'      => $this->codigo,
                'descripcion' => $this->descripcion,
            ]
        );

        session()->flash(
            'message',
            $this->evento_id
                ? 'Evento actualizado correctamente.'
                : 'Evento registrado correctamente.'
        );

        $this->cerrarModal();
    }

    public function editar($id)
    {
        $e = Evento::findOrFail($id);
        $this->evento_id   = $e->id;
        $this->accion      = $e->accion;
        $this->user_id     = $e->user_id;
        $this->codigo      = $e->codigo;
        $this->descripcion = $e->descripcion;
        $this->modal       = true;
    }

    public function eliminar($id)
    {
        Evento::findOrFail($id)->delete();
        session()->flash('message', 'Evento eliminado correctamente.');
    }

    public function render()
    {
        $eventos = Evento::where(function($q){
                $q->where('accion', 'like', '%'.$this->search.'%')
                  ->orWhere('codigo', 'like', '%'.$this->search.'%')
                  ->orWhere('descripcion', 'like', '%'.$this->search.'%');
            })
            ->orderBy('created_at', 'desc')
            ->paginate(15);

        return view('livewire.eventos', [
            'eventos' => $eventos,
        ]);
    }
}
