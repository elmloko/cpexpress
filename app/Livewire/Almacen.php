<?php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Evento;
use App\Models\Empresa;
use App\Models\Peso;
use App\Models\Tarifario;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use App\Exports\AlmacenExport;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Carbon\Carbon;

class Almacen extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';

    public $dateFrom;
    public $dateTo;
    public $paquete_id;
    public $codigo;
    public $destinatario;
    public $destino;
    public $cuidad;
    public $peso;
    public $observacion;
    public $modal = false;

    // checkbox
    public $selectAll = false;
    public $certificacion = false;
    public $grupo = false;
    public $almacenaje = false;
    public $pda;
    public $selected = [];
    public $cantidad = 1;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'       => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad'       => 'nullable|string|max:50',
        'peso'         => 'nullable|numeric',
        'observacion'  => 'nullable|string|max:255',
        'destino'      => 'required|string|max:50',
        'pda'           => 'nullable|numeric',
        'certificacion' => 'boolean',
        'grupo'         => 'boolean',
        'almacenaje'    => 'boolean',
        'cantidad'    => 'required|integer|min:1',
    ];

    public function mount()
    {
        $this->searchInput = $this->search;
        // Por defecto, rango: primeros y últimos días del mes actual
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
        $from = Carbon::parse($this->dateFrom)->startOfDay();
        $to   = Carbon::parse($this->dateTo)->endOfDay();

        return Excel::download(
            new AlmacenExport($this->search, $from, $to),
            "paquetes_{$this->dateFrom}_a_{$this->dateTo}.xlsx"
        );
    }

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
            'observacion',
            'grupo',
            'certificacion',
            'almacenaje',
            'cantidad',
            'pda',
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
            'destino'       => $this->destino,
            'observacion'   => strtoupper($this->observacion),
            'pda'           => $this->pda,
            'certificacion' => $this->certificacion ? 1 : 0,
            'grupo'         => $this->grupo ? 1 : 0,
            'almacenaje'    => $this->almacenaje ? 1 : 0,
            'estado'        => 'ALMACEN',
            'user'          => Auth::user()->name,
        ];

        // 2. Crear o actualizar el paquete
        $paquete = Paquete::updateOrCreate(
            ['id' => $this->paquete_id],
            $data
        );

        // 3. Cálculo de precio basado en Empresa, Peso, Destino y Certificación
        $precio = 0;

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
                // 3.4. Columna según destino (asegúrate de tener el campo 'destino' en tu tabla)
                $col = strtolower($paquete->destino);
                if (isset($tarifa->$col)) {
                    $precio = $tarifa->$col;
                }
            }
        }

        // 3.5. Agregar cargo de certificación si aplica
        if ($paquete->certificacion) {
            $precio += 8;
        }

        if ($paquete->almacenaje) {
            $precio += 15;
        }

        $multiplier = $paquete->grupo ? $paquete->cantidad : 1;

        // 5) Cálculo final
        $total = $precio * $multiplier;

        // 4. Actualizar el precio en el modelo
        $paquete->update(['total' => $total]);

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
        $this->pda          = $p->pda;
        $this->modal        = true;
        $this->certificacion = (bool) $p->certificacion;
        $this->grupo         = (bool) $p->grupo;
        $this->almacenaje   = (bool) $p->almacenaje;
    }

    public function toggleSelectAll()
    {
        $this->selectAll = ! $this->selectAll;

        if ($this->selectAll) {
            $this->selected = Paquete::where('estado', 'ALMACEN')
                ->where(function ($q) {
                    $q->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('cuidad', 'like', "%{$this->search}%")
                        ->orWhere('observacion', 'like', "%{$this->search}%");
                })
                ->pluck('id')->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function darBajaSeleccionados()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No hay paquetes seleccionados.');
            return;
        }

        // 1) Obtener paquetes
        $packages = Paquete::whereIn('id', $this->selected)->get();

        // 2) Para cada paquete, calcular precio y actualizar antes de dar baja
        foreach ($packages as $p) {
            // 2.1 Empresa y categoría de peso
            $empresa   = Empresa::whereRaw('UPPER(nombre)=?', [strtoupper($p->destinatario)])->first();
            $pesoCat   = Peso::where('min', '<=', $p->peso)
                ->where('max', '>=', $p->peso)
                ->first();

            $unit = 0;
            if ($empresa && $pesoCat) {
                $tarifa = Tarifario::where('empresa', $empresa->id)
                    ->where('peso', $pesoCat->id)
                    ->first();
                $col = strtolower($p->destino);
                if ($tarifa && isset($tarifa->$col)) {
                    $unit = $tarifa->$col;
                }
            }

            // 2.2 Cargos extras
            if ($p->certificacion) {
                $unit += 8;
            }
            if ($p->almacenaje) {
                $unit += 15;
            }

            // 2.3 Multiplicador
            $mult = $p->grupo ? $p->cantidad : 1;

            // 2.4 Total final
            $total = $unit * $mult;

            // 2.5 Guardar total en BD
            $p->update(['total' => $total]);
        }

        // 3) Marcar como INVENTARIO y soft-delete
        Paquete::whereIn('id', $this->selected)
            ->update(['estado' => 'INVENTARIO']);
        Paquete::whereIn('id', $this->selected)->delete();

        // 4) Registrar evento de entrega
        foreach ($packages as $pkg) {
            Evento::create([
                'accion'      => 'ENTREGADO',
                'descripcion' => 'Paquete Entregado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $pkg->codigo,
            ]);
        }

        // 5) Limpiar selección
        $this->selected  = [];
        $this->selectAll = false;

        // 6) Generar PDF de despacho
        $pdf = PDF::loadView('pdf.despacho', ['packages' => $packages]);
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'despacho_' . now()->format('Ymd_His') . '.pdf'
        );
    }

    public function render()
    {
        $empresas = Empresa::orderBy('nombre')->get();

        $paquetes = Paquete::where('estado', 'ALMACEN')
            ->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cuidad', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%")
            )
            ->orderBy('id', 'desc')
            ->paginate(10);

        $empresas = Empresa::orderBy('nombre')->get();


        return view('livewire.almacen', compact('paquetes', 'empresas'));
    }
}
