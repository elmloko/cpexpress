<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Models\Paquete;
use App\Models\Evento;
use App\Models\Empresa;

class Resago extends Component
{
    use WithPagination;

    public $search = '';
    public $modal = false;
    public $paquete_id, $codigo, $destinatario, $cuidad, $direccion_paquete,
        $telefono, $correo_destinatario, $peso, $casilla,
        $observacion, $aduana, $grupo = false, $almacenaje = false;

    public $selected = [];
    public $selectPage = false;
    public $selectAll = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo' => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad' => 'required|string|max:50',
        'direccion_paquete' => 'required|string|max:99',
        'telefono' => 'nullable|string|max:25',
        'correo_destinatario' => 'nullable|email|max:60',
        'peso' => 'required|numeric',
        'casilla' => 'nullable|numeric',
        'aduana' => 'required|string|in:SI,NO',
        'observacion' => 'nullable|string|max:255',
    ];

    public function getPaquetesProperty()
    {
        return Paquete::where('estado', 'RESAGADO')
            ->where(function ($query) {
                $query->where('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cuidad', 'like', '%' . $this->search . '%')
                    ->orWhere('observacion', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);
    }

    public function render()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        return view('livewire.resago', [
            'paquetes' => $this->paquetes,
            'empresas' => $empresas,
        ]);
    }

    public function updatedSelectPage($value)
    {
        if ($value) {
            // Selecciona todos los paquetes de la página actual
            $this->selected = $this->paquetes->pluck('id')->map(fn($id) => (string)$id)->toArray();
        } else {
            // Deselecciona todos
            $this->selected = [];
            $this->selectAll = false;
        }
    }

    public function abrirModal()
    {
        $this->reset([
            'paquete_id',
            'codigo',
            'destinatario',
            'direccion_paquete',
            'telefono',
            'correo_destinatario',
            'cuidad',
            'peso',
            'casilla',
            'observacion',
            'almacenaje',
            'aduana',
        ]);
        $this->cuidad = Auth::user()->city;
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        $this->cuidad = Auth::user()->city;

        $data = [
            'codigo' => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'cuidad' => strtoupper($this->cuidad),
            'direccion_paquete' => strtoupper($this->direccion_paquete),
            'telefono' => $this->telefono,
            'correo_destinatario' => $this->correo_destinatario,
            'aduana' => strtoupper($this->aduana),
            'peso' => $this->peso,
            'casilla' => $this->casilla,
            'observacion' => strtoupper($this->observacion),
            'cantidad' => 1,
            'user' => Auth::user()->name,
            'estado' => 'RESAGADO',
            'precio' => 0,
        ];

        if ($this->paquete_id) {
            $p = Paquete::findOrFail($this->paquete_id);
            $p->update($data);

            Evento::create([
                'accion' => 'EDICION',
                'descripcion' => 'Paquete Editado (RESAGADO)',
                'user_id' => Auth::user()->name,
                'codigo' => $data['codigo'],
            ]);

            session()->flash('message', 'Paquete actualizado como RESAGADO.');
        } else {
            Paquete::create($data);

            Evento::create([
                'accion' => 'CREACION',
                'descripcion' => 'Paquete Creado como RESAGADO',
                'user_id' => Auth::user()->name,
                'codigo' => $data['codigo'],
            ]);

            session()->flash('message', 'Paquete registrado como RESAGADO.');
        }

        $this->cerrarModal();
        $this->reset(['paquete_id', 'codigo', 'destinatario', 'cuidad', 'direccion_paquete', 'telefono', 'correo_destinatario', 'peso', 'casilla', 'observacion', 'aduana']);
    }

    public function enviarSeleccionadosAAlmacen()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No se seleccionó ningún paquete.');
            return;
        }

        $paquetes = Paquete::whereIn('id', $this->selected)
            ->where('estado', 'RESAGADO')
            ->get();

        foreach ($paquetes as $paquete) {
            $paquete->update(['estado' => 'ALMACEN']);

            Evento::create([
                'accion' => 'CAMBIO DE ESTADO',
                'descripcion' => 'Resagado enviado a ALMACÉN',
                'user_id' => Auth::user()->name,
                'codigo' => $paquete->codigo,
            ]);
        }

        $this->selected = [];
        $this->selectPage = false;
        $this->selectAll = false;

        session()->flash('message', 'Paquetes enviados a ALMACÉN correctamente.');
    }

    public function editar($id)
    {
        $paquete = Paquete::findOrFail($id);

        $this->paquete_id = $paquete->id;
        $this->codigo = $paquete->codigo;
        $this->destinatario = $paquete->destinatario;
        $this->cuidad = $paquete->cuidad;
        $this->direccion_paquete = $paquete->direccion_paquete;
        $this->telefono = $paquete->telefono;
        $this->correo_destinatario = $paquete->correo_destinatario;
        $this->peso = $paquete->peso;
        $this->casilla = $paquete->casilla;
        $this->observacion = $paquete->observacion;
        $this->aduana = $paquete->aduana;

        $this->modal = true;
    }

    public function eliminarPaquete($id)
    {
        $paquete = Paquete::findOrFail($id);
        $codigo = $paquete->codigo;
        $paquete->delete();

        Evento::create([
            'accion' => 'ELIMINACION',
            'descripcion' => "Paquete eliminado (RESAGADO) Código: $codigo",
            'user_id' => Auth::user()->name,
            'codigo' => $codigo,
        ]);

        session()->flash('message', 'Paquete eliminado correctamente.');
    }
}
