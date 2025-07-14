<?php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Empresa;
use App\Models\Peso;
use App\Models\Tarifario;
use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Exports\PaquetesExport;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;

class Despacho extends Component
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
    public $destino;
    public $cuidad;
    public $peso;
    public $observacion;
    public $certificacion = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'       => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad'       => 'nullable|string|max:50',
        'peso'         => 'nullable|numeric',
        'observacion'  => 'nullable|string|max:255',
        'destino'      => 'required|string|max:50',
        'certificacion' => 'boolean',
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
        $this->reset([
            'paquete_id',
            'codigo',
            'destinatario',
            'estado',
            'cuidad',
            'destino',
            'peso',
            'user',
            'observacion'
        ]);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
        $this->validate();

        // 1. Datos base, incluyendo certificación
        $data = [
            'codigo'        => strtoupper($this->codigo),
            'destinatario'  => strtoupper($this->destinatario),
            'cuidad'        => strtoupper($this->cuidad),
            'peso'          => $this->peso,
            'observacion'   => strtoupper($this->observacion),
            'certificacion' => $this->certificacion ? 1 : 0,
            'estado'        => 'DESPACHADO',
            'user'          => Auth::user()->name,
        ];

        // 2. Crear o actualizar el paquete
        $paquete = Paquete::updateOrCreate(
            ['id' => $this->paquete_id],
            $data
        );

        // 3. Cálculo de precio unitario basado en Empresa, Peso, Destino y Certificación
        $precioUnitario = 0;

        // 3.1. Buscar la empresa (nombres en mayúsculas)
        $empresaModel = Empresa::whereRaw(
            'UPPER(nombre) = ?',
            [strtoupper($paquete->destinatario)]
        )->first();

        // 3.2. Categoría de peso
        $pesoCat = Peso::where('min', '<=', $paquete->peso)
            ->where('max', '>=', $paquete->peso)
            ->first();

        if ($empresaModel && $pesoCat) {
            // 3.3. Obtener la tarifa correspondiente
            $tarifa = Tarifario::where('empresa', $empresaModel->id)
                ->where('peso', $pesoCat->id)
                ->first();

            if ($tarifa) {
                // 3.4. Columna según destino
                $col = strtolower($paquete->destino);
                if (isset($tarifa->$col)) {
                    $precioUnitario = $tarifa->$col;
                }
            }
        }

        // 3.5. Agregar cargo de certificación si aplica
        if ($paquete->certificacion) {
            $precioUnitario += 8;
        }

        // 3.6. Multiplicar por la cantidad de paquetes
        $precioFinal = $precioUnitario * ($paquete->cantidad ?? 1);

        // 4. Actualizar el precio total en el modelo
        $paquete->update(['precio' => $precioFinal]);

        // 5. Registrar el evento
        Evento::create([
            'accion'      => 'EDICION',
            'descripcion' => 'Paquete editado y precio recalculado',
            'user_id'     => Auth::user()->name,
            'codigo'      => $data['codigo'],
        ]);

        // 6. Mensaje y cierre de modal
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
        $this->destino       = $p->destino;
        $this->cuidad       = $p->cuidad;
        $this->peso         = $p->peso;
        $this->observacion  = $p->observacion;
        $this->modal        = true;
        $this->certificacion = (bool) $p->certificacion;
    }

    public function restaurar($id)
    {
        // Buscar sólo entre los activos (no borrados)
        $p = Paquete::findOrFail($id);

        // Cambiar estado a ALMACEN
        $p->estado = 'ENVIANDO';
        $p->save();

        // Evento::create([
        //     'accion'      => 'RESTABLECER',
        //     'descripcion' => 'Paquete dado de alta en Almacén',
        //     'user_id'     => Auth::user()->name,
        //     'codigo'      => $p->codigo,
        // ]);

        session()->flash('message', 'Paquete marcado como ALMACEN.');
        $this->resetPage();
    }


    public function render()
    {
        $paquetes = Paquete::where('estado', 'DESPACHADO')
            ->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cuidad', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%")
            )
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        $empresas = Empresa::orderBy('nombre')->get();

        return view('livewire.despacho', compact('paquetes', 'empresas'));
    }
}
