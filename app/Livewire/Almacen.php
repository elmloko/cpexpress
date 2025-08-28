<?php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Evento;
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
    public $selected = [];
    public $cantidad = 1;

    public $aduana;
    public $direccion_paquete;
    public $telefono;
    public $casilla;
    public $correo_destinatario;
    public $precio_final;
    public $factura;
    public $numero_factura;
    public $mostrarModalFactura = false;


    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'       => 'required|string|max:50',
        'destinatario' => 'required|string|max:100',
        'cuidad'       => 'nullable|string|max:50',
        'peso'         => 'nullable|numeric',
        'observacion'  => 'nullable|string|max:255',
        'cantidad'     => 'required|integer|min:1',
        'direccion_paquete'  => 'required|string|max:99',
        'telefono'           => 'nullable|string|max:25',
        'correo_destinatario' => 'nullable|string|max:60',
        'casilla'            => 'nullable|numeric',
        'aduana'             => 'required|string|in:SI,NO',
    ];

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
            'cuidad',
            'peso',
            'observacion',
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
        $this->validate();

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
            'cantidad'     => $this->cantidad,
        ];

        if ($this->paquete_id) {
            $paquete = Paquete::find($this->paquete_id);
            if (!$paquete) {
                session()->flash('message', 'Paquete no encontrado para actualizar.');
                return;
            }
            $paquete->update($data);
        } else {
            Paquete::create($data);
        }

        Evento::create([
            'accion'      => $this->paquete_id ? 'EDICION' : 'CREACION',
            'descripcion' => $this->paquete_id
                ? 'Paquete editado'
                : 'Paquete creado e ingresado a inventario',
            'user_id'     => Auth::user()->name,
            'codigo'      => $data['codigo'],
        ]);

        session()->flash('message', $this->paquete_id
            ? 'Paquete actualizado en Almacen.'
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
        $p = Paquete::withTrashed()->findOrFail($id);

        $this->paquete_id   = $p->id;
        $this->codigo       = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->cuidad       = $p->cuidad;
        $this->peso         = $p->peso;
        $this->observacion  = $p->observacion;
        $this->modal        = true;
        $this->direccion_paquete     = $p->direccion_paquete;
        $this->telefono      = $p->telefono;
        $this->correo_destinatario = $p->correo_destinatario;
        $this->aduana        = $p->aduana;
        $this->casilla       = $p->casilla;
        $this->cantidad      = $p->cantidad;
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

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

    public function calcularPrecioFinal($created_at, $codigo = null)
    {
        // Si el código empieza con "UM" -> precio fijo
        if ($codigo && strtoupper(substr($codigo, 0, 2)) === 'UM') {
            return 15;
        }

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

    public function confirmarDarBaja()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No hay paquetes seleccionados.');
            return;
        }
        $this->mostrarModalFactura = true;
    }


    public function darBajaSeleccionados()
    {
        $this->validate([
            'numero_factura' => 'required|string|max:50',
        ], [
            'numero_factura.required' => 'Debe ingresar un número de factura.',
        ]);

        $packages = Paquete::whereIn('id', $this->selected)->get();

        foreach ($packages as $p) {
            if (strtoupper(substr($p->codigo, 0, 2)) === 'UM') {
                $precioFinal = 15;
            } else {
                $dias = Carbon::parse($p->created_at)->diffInDays(Carbon::now());
                $precioFinal = $dias <= 6 ? 17 : 17 + (($dias - 6) * 2);
            }


            $p->update([
                'precio_final' => $precioFinal,
                'factura'      => $this->numero_factura, // ✅ se guarda la factura
            ]);
        }

        Paquete::whereIn('id', $this->selected)->update(['estado' => 'INVENTARIO']);
        Paquete::whereIn('id', $this->selected)->delete();

        foreach ($packages as $pkg) {
            Evento::create([
                'accion'      => 'ENTREGADO',
                'descripcion' => 'Paquete Entregado con Factura ' . $this->numero_factura,
                'user_id' => Auth::user()->name,
                'codigo'      => $pkg->codigo,
            ]);
        }

        $this->selected = [];
        $this->selectAll = false;
        $this->mostrarModalFactura = false;
        $this->numero_factura = null;

        // PDF duplicando paquetes con aduana = SI
        $packagesDuplicados = collect();
        foreach ($packages as $p) {
            $packagesDuplicados->push($p);
            if (strtoupper($p->aduana) === 'SI') {
                $packagesDuplicados->push($p);
            }
        }

        $formulario = 'pdf.formularioentrega';
        $pdf = PDF::loadView($formulario, ['packages' => $packagesDuplicados]);

        return response()->streamDownload(
            fn() => print($pdf->output()),
            'Despacho_Encomiendas_' . now()->format('Ymd_His') . '.pdf'
        );
    }


    public function render()
    {
        $paquetes = Paquete::where('estado', 'ALMACEN')
            ->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cuidad', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%")
            )
            ->orderBy('id', 'desc')
            ->paginate(10);

        return view('livewire.almacen', compact('paquetes'));
    }
}
