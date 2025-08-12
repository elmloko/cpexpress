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
    public $cuidad;
    public $peso;
    public $observacion;
    public $modal = false;

    // checkbox
    public $selectAll = false;
    public $certificacion = false;
    public $grupo = false;
    public $almacenaje = false;
    public $selected = [];
    public $cantidad = 1;

    public $aduana;
    public $direccion_paquete;
    public $telefono;
    public $casilla;
    public $correo_destinatario;
    public $precio_final;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'       => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad'       => 'nullable|string|max:50',
        'peso'         => 'nullable|numeric',
        'observacion'  => 'nullable|string|max:255',
        'certificacion' => 'boolean',
        'grupo'         => 'boolean',
        'almacenaje'    => 'boolean',
        'cantidad'    => 'required|integer|min:1',
        'direccion_paquete'  => 'required|string|max:99',
        'telefono'           => 'nullable|string|max:25',
        'correo_destinatario'             => 'nullable|string|max:60',
        'casilla'            => 'nullable|numeric',
        'aduana'             => 'required|string|in:SI,NO',
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
            'peso',
            'user',
            'observacion',
            'grupo',
            'certificacion',
            'almacenaje',
            'cantidad',
        ]);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function guardar()
    {
/*         dd($this->paquete_id, $this->codigo, $this->destinatario);
 */        $this->validate();

        $data = [
            'codigo'       => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'cuidad'       => strtoupper($this->cuidad),
            'direccion_paquete' => strtoupper($this->direccion_paquete),
            'telefono'     => $this->telefono,
            'correo_destinatario' => $this->correo_destinatario,
            'aduana'       => strtoupper($this->aduana),
            'peso'         => $this->peso,
            'casilla'      => $this->casilla,
            'observacion'  => strtoupper($this->observacion),
            'grupo'        => $this->grupo ? 1 : 0,
            'almacenaje'   => $this->almacenaje ? 1 : 0,
            'cantidad'     => '1',
        ];

        if ($this->paquete_id) {
            // Actualizar paquete existente
            $paquete = Paquete::find($this->paquete_id);
            if (!$paquete) {
                session()->flash('message', 'Paquete no encontrado para actualizar.');
                return;
            }
            $paquete->update($data);
        } else {
            // Crear nuevo paquete
            $paquete = Paquete::create($data);
        }

        $precio = 0;

        $empresaModel = Empresa::whereRaw('UPPER(nombre) = ?', [strtoupper($paquete->destinatario)])->first();

        $pesoCat = Peso::where('min', '<=', $paquete->peso)
            ->where('max', '>=', $paquete->peso)
            ->first();

        if ($empresaModel && $pesoCat) {
            $tarifa = Tarifario::where('empresa', $empresaModel->id)
                ->where('peso', $pesoCat->id)
                ->first();

            if ($tarifa) {
                $col = strtolower($paquete->destino);
                if (isset($tarifa->$col)) {
                    $precio = $tarifa->$col;
                }
            }
        }

        if ($paquete->almacenaje) {
            $precio += 15;
        }

        $multiplier = $paquete->grupo ? $paquete->cantidad : 1;

        $total = $precio * $multiplier;

        $paquete->update(['total' => $total]);

        Evento::create([
            'accion'      => $this->paquete_id ? 'EDICION' : 'CREACION',
            'descripcion' => $this->paquete_id
                ? 'Paquete editado y precio recalculado'
                : 'Paquete creado e ingresado a inventario',
            'user_id'     => Auth::user()->name,
            'codigo'      => $data['codigo'],
        ]);

        session()->flash('message', $this->paquete_id
            ? 'Paquete actualizado en Inventario.'
            : 'Paquete agregado a Inventario.');

        $this->cerrarModal();

        $this->reset([
            'paquete_id',
            'codigo',
            'destinatario',
            'cuidad',
            'direccion_paquete',
            'telefono',
            'correo_destinatario',
            'peso',
            'casilla',
            'observacion',
            'aduana'
        ]);
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
        $this->certificacion = (bool) $p->certificacion;
        $this->grupo         = (bool) $p->grupo;
        $this->almacenaje   = (bool) $p->almacenaje;
        $this->direccion_paquete     = $p->direccion_paquete;
        $this->telefono      = $p->telefono;
        $this->correo_destinatario      = $p->correo_destinatario;
        $this->aduana       = $p->aduana;
        $this->casilla        = $p->casilla;
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

    public function calcularPrecioFinal($created_at)
    {
        $dias = Carbon::parse($created_at)
            ->startOfDay()
            ->diffInDays(Carbon::now()->startOfDay());

        if ($dias <= 6) {
            $precio = 17;
        } else {
            $precio = 17 + (($dias - 6) * 2);
        }

        return (int) $precio;
    }

    public function diasTranscurridos($created_at)
    {
        return Carbon::parse($created_at)->diffInDays(Carbon::now());
    }

    public function notificar($id)
    {
        $paquete = Paquete::find($id);

        if ($paquete->notificado < 3) {
            $paquete->notificado += 1;
            $paquete->save();

            session()->flash('message', 'Usuario notificado ' . $paquete->notificado . ' veces.');
        } else {
            session()->flash('message', 'El usuario ya fue notificado 3 veces.');
        }
    }

    public function enviarARezago($id)
    {
        $paquete = Paquete::find($id);

        if ($paquete) {
            $paquete->estado = 'REZAGO';
            $paquete->save();

            Evento::create([
                'accion'      => 'REZAGO',
                'descripcion' => 'Paquete enviado a rezago',
                'user_id'     => Auth::user()->name,
                'codigo'      => $paquete->codigo,
            ]);

            session()->flash('message', "Paquete {$paquete->codigo} enviado a REZAGO.");
        } else {
            session()->flash('message', 'Paquete no encontrado.');
        }
    }

    public function darBajaSeleccionados()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No hay paquetes seleccionados.');
            return;
        }

        $packages = Paquete::whereIn('id', $this->selected)->get();

        foreach ($packages as $p) {
            $empresa = Empresa::whereRaw('UPPER(nombre)=?', [strtoupper($p->destinatario)])->first();
            $pesoCat = Peso::where('min', '<=', $p->peso)
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

            $dias = Carbon::parse($p->created_at)->diffInDays(Carbon::now());

            if ($dias <= 6) {
                $precioFinal = 17;
            } else {
                $precioFinal = 17 + (($dias - 6) * 2);
            }

            $mult = $p->grupo ? $p->cantidad : 1;
            $total = ($unit * $mult) + $precioFinal;

            $p->update([
                'total'        => $total,
                'precio_final' => $precioFinal,
            ]);
        }

        Paquete::whereIn('id', $this->selected)->update(['estado' => 'INVENTARIO']);
        Paquete::whereIn('id', $this->selected)->delete();

        foreach ($packages as $pkg) {
            Evento::create([
                'accion'      => 'ENTREGADO',
                'descripcion' => 'Paquete Entregado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $pkg->codigo,
            ]);
        }

        $this->selected  = [];
        $this->selectAll = false;

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
