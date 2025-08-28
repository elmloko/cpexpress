<?php
// app/Livewire/Recibir.php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Empresa;
use App\Models\Evento;
use Livewire\Component;
use Livewire\WithPagination;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;

class Recibir extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $selectAll = false;
    public $selected = [];
    public $modalDestino = false;
    public $paqueteDestinoId = null;
    public $modal = false;

    public $paquete_id;
    public $codigo;
    public $destinatario;
    public $cuidad;
    public $peso;
    public $destino;
    public $observacion;
    public $ciudad;
    public $aduana;
    public $direccion_paquete;
    public $telefono;
    public $casilla;
    public $correo_destinatario;

    public $isSacaM = false;

    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'             => 'required|string|max:50',
        'destinatario'       => 'required|string|max:100',
        'cuidad'             => 'required|string|max:50',
        'direccion_paquete'  => 'required|string|max:99',
        'telefono'           => 'nullable|string|max:25',
        'correo_destinatario' => 'nullable|email|max:60',
        'peso'               => 'required|numeric',
        'casilla'            => 'nullable|numeric',
        'aduana'             => 'required|string|in:SI,NO',
        'observacion'        => 'nullable|string|max:255',
    ];

    protected $messages = [
        'peso.required' => 'El campo Peso es obligatorio.',
        'codigo.required' => 'El campo Código es obligatorio.',
        'destinatario.required' => 'El campo Nombre es obligatorio.',
        'direccion_paquete.required' => 'La Dirección es obligatoria.',
        'aduana.required' => 'Debe seleccionar si pasa por Aduana.',
        'cuidad.required' => 'Debe seleccionar una ciudad.',
        'correo_destinatario.email' => 'El correo debe ser válido y contener el símbolo @.',
    ];

    public function mount()
    {
        $this->cuidad = Auth::user()->city;
        $this->ciudad = Auth::user()->city;
    }

    // ======================
    // BÚSQUEDA DE PAQUETE API
    // ======================
    public function buscar()
    {
        $this->search = trim($this->searchInput);

        if (!$this->search) {
            session()->flash('message', 'Debe ingresar un código para buscar.');
            return;
        }

        $this->resetPage();

        $url = config('services.correos.url') . '/' . $this->search;
        $response = Http::withOptions([
            'verify' => false,
            'curl'   => [
                CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
            ],
        ])->withToken(config('services.correos.token'))
            ->acceptJson()
            ->get($url);

        if (!$response->successful()) {
            session()->flash('message', "Paquete no encontrado o error API ({$response->status()}).");
            return;
        }

        $data = $response->json();

        if (($data['VENTANILLA'] ?? '') !== 'ECA' ||
            ($data['ESTADO'] ?? '') !== 'DESPACHO' ||
            strtoupper($data['CUIDAD'] ?? '') !== strtoupper(Auth::user()->city)
        ) {
            session()->flash('message', 'El paquete no cumple con los criterios de Ventanilla, Estado o Ciudad.');
            return;
        }

        // Actualizar o crear paquete sin asignar 'destino'
        $paquete = Paquete::updateOrCreate(
            ['codigo' => $data['CODIGO']],
            [
                'destinatario' => strtoupper($data['DESTINATARIO']),
                'estado'       => 'RECIBIDO',
                'cuidad'       => strtoupper($data['CUIDAD']),
                'peso'         => floatval($data['PESO']),
                'user'         => Auth::user()->name,
            ]
        );

        Evento::create([
            'accion' => 'ENCONTRADO',
            'descripcion' => 'Paquete Registrado',
            'user_id' => Auth::user()->name,
            'codigo' => $paquete->codigo,
        ]);

        $this->paqueteDestinoId = $paquete->id;
        $this->modalDestino = true;
    }

    // ======================
    // SELECCIÓN MÚLTIPLE
    // ======================
    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;

        if ($this->selectAll) {
            $this->selected = Paquete::where('estado', 'RECIBIDO')
                ->where(function ($q) {
                    $q->where('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('cuidad', 'like', '%' . $this->search . '%')
                        ->orWhere('observacion', 'like', '%' . $this->search . '%');
                })
                ->orderBy('id', 'desc')
                ->pluck('id')
                ->toArray();
        } else {
            $this->selected = [];
        }
    }

    public function recibirSeleccionados()
    {
        if (empty($this->selected)) {
            session()->flash('message', 'No hay paquetes seleccionados.');
            return;
        }

        foreach ($this->selected as $id) {
            $paquete = Paquete::find($id);
            if ($paquete) {
                $paquete->update([
                    'estado' => 'ALMACEN',
                    'precio' => 17,
                ]);

                Evento::create([
                    'accion' => 'RECIBIDO',
                    'descripcion' => 'Paquete Recibido',
                    'user_id' => Auth::user()->name,
                    'codigo' => $paquete->codigo,
                ]);
            }
        }

        $this->selected = [];
        $this->selectAll = false;
        session()->flash('message', 'Paquetes recibidos y marcados como ALMACEN correctamente.');
        $this->resetPage();
    }

    public function eliminarPaquete($id)
    {
        $p = Paquete::findOrFail($id);
        $p->forceDelete();
        $this->resetPage();

        session()->flash('message', 'Paquete eliminado permanentemente.');

        Evento::create([
            'accion' => 'ELIMINADO',
            'descripcion' => 'Paquete Eliminado',
            'user_id' => Auth::user()->name,
            'codigo' => $p->codigo,
        ]);
    }

    // ======================
    // MODAL CREAR / EDITAR
    // ======================
    public function abrirModal()
    {
        $this->resetModalFields();
        $this->cuidad = Auth::user()->city;
        $this->aduana = null;
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function editar($id)
    {
        $p = Paquete::findOrFail($id);
        $this->paquete_id = $p->id;
        $this->codigo = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->direccion_paquete = $p->direccion_paquete;
        $this->telefono = $p->telefono;
        $this->correo_destinatario = $p->correo_destinatario;
        $this->cuidad = $p->cuidad;
        $this->aduana = $p->aduana;
        $this->peso = $p->peso;
        $this->casilla = $p->casilla;
        $this->observacion = $p->observacion;
        $this->modal = true;
    }

    public function guardar()
    {
        $this->validate();
        $this->cuidad = Auth::user()->city;

        $data = $this->prepareData();
        $data['ciudad_origen'] = $this->getPaisOrigen($this->codigo);

        if ($this->paquete_id) {
            $model = Paquete::findOrFail($this->paquete_id);
            $model->update($data);
            session()->flash('message', 'Paquete actualizado.');

            Evento::create([
                'accion' => 'EDICION',
                'descripcion' => 'Paquete Editado',
                'user_id' => Auth::user()->name,
                'codigo' => $data['codigo'],
            ]);
        } else {
            $data['estado'] = 'RECIBIDO';
            $data['user'] = Auth::user()->name;
            $data['precio'] = 17;

            Paquete::create($data);

            session()->flash('message', 'Paquete registrado como RECIBIDO.');

            Evento::create([
                'accion' => 'CREACION',
                'descripcion' => 'Paquete Creado',
                'user_id' => Auth::user()->name,
                'codigo' => $data['codigo'],
            ]);
        }

        $this->cerrarModal();
        $this->resetModalFields();
    }

    // ======================
    // HELPER PRIVADOS
    // ======================
    private function resetModalFields()
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
            'aduana',
        ]);
    }

    private function prepareData(): array
    {
        $codigoUpper = strtoupper($this->codigo);
        return [
            'codigo' => $codigoUpper,
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
            'ciudad_origen' => $this->getPaisOrigen($codigoUpper),

        ];
    }

    private function getPaisOrigen(string $codigo): string
    {
        $paises = [
            'AF' => 'Afganistán',
            'AL' => 'Albania',
            'DZ' => 'Argelia',
            'AS' => 'Samoa Americana',
            'AD' => 'Andorra',
            'AO' => 'Angola',
            'AI' => 'Anguila',
            'AQ' => 'Antártida',
            'AG' => 'Antigua y Barbuda',
            'AR' => 'Argentina',
            'AM' => 'Armenia',
            'AW' => 'Aruba',
            'AU' => 'Australia',
            'AT' => 'Austria',
            'AZ' => 'Azerbaiyán',
            'BS' => 'Bahamas',
            'BH' => 'Bahrein',
            'BD' => 'Bangladesh',
            'BB' => 'Barbados',
            'BY' => 'Bielorrusia',
            'BE' => 'Bélgica',
            'BZ' => 'Belice',
            'BJ' => 'Benín',
            'BM' => 'Bermudas',
            'BT' => 'Bután',
            'BO' => 'Bolivia',
            'BA' => 'Bosnia y Herzegovina',
            'BW' => 'Botsuana',
            'BR' => 'Brasil',
            'BN' => 'Brunéi',
            'BG' => 'Bulgaria',
            'BF' => 'Burkina Faso',
            'BI' => 'Burundi',
            'CV' => 'Cabo Verde',
            'KH' => 'Camboya',
            'CM' => 'Camerún',
            'CA' => 'Canadá',
            'KY' => 'Islas Caimán',
            'CF' => 'República Centroafricana',
            'TD' => 'Chad',
            'CL' => 'Chile',
            'CN' => 'China',
            'CX' => 'Isla Christmas',
            'CC' => 'Islas Cocos',
            'CO' => 'Colombia',
            'KM' => 'Comoras',
            'CG' => 'Congo',
            'CD' => 'Congo, República Democrática del',
            'CR' => 'Costa Rica',
            'CI' => 'Costa de Marfil',
            'HR' => 'Croacia',
            'CU' => 'Cuba',
            'CY' => 'Chipre',
            'CZ' => 'Chequia',
            'DK' => 'Dinamarca',
            'DJ' => 'Yibuti',
            'DM' => 'Dominica',
            'DO' => 'República Dominicana',
            'EC' => 'Ecuador',
            'EG' => 'Egipto',
            'SV' => 'El Salvador',
            'GQ' => 'Guinea Ecuatorial',
            'ER' => 'Eritrea',
            'EE' => 'Estonia',
            'SZ' => 'Esuatini',
            'ET' => 'Etiopía',
            'FJ' => 'Fiyi',
            'FI' => 'Finlandia',
            'FR' => 'Francia',
            'GA' => 'Gabón',
            'GM' => 'Gambia',
            'GE' => 'Georgia',
            'DE' => 'Alemania',
            'GH' => 'Ghana',
            'GR' => 'Grecia',
            'GD' => 'Granada',
            'GT' => 'Guatemala',
            'GN' => 'Guinea',
            'GW' => 'Guinea-Bisáu',
            'GY' => 'Guyana',
            'HT' => 'Haití',
            'HN' => 'Honduras',
            'HU' => 'Hungría',
            'IS' => 'Islandia',
            'IN' => 'India',
            'ID' => 'Indonesia',
            'IR' => 'Irán',
            'IQ' => 'Iraq',
            'IE' => 'Irlanda',
            'IL' => 'Israel',
            'IT' => 'Italia',
            'JM' => 'Jamaica',
            'JP' => 'Japón',
            'JO' => 'Jordania',
            'KZ' => 'Kazajistán',
            'KE' => 'Kenia',
            'KI' => 'Kiribati',
            'KP' => 'Corea del Norte',
            'KR' => 'Corea del Sur',
            'KW' => 'Kuwait',
            'KG' => 'Kirguistán',
            'LA' => 'Laos',
            'LV' => 'Letonia',
            'LB' => 'Líbano',
            'LS' => 'Lesoto',
            'LR' => 'Liberia',
            'LY' => 'Libia',
            'LI' => 'Liechtenstein',
            'LT' => 'Lituania',
            'LU' => 'Luxemburgo',
            'MG' => 'Madagascar',
            'MW' => 'Malaui',
            'MY' => 'Malasia',
            'MV' => 'Maldivas',
            'ML' => 'Malí',
            'MT' => 'Malta',
            'MH' => 'Islas Marshall',
            'MQ' => 'Martinica',
            'MR' => 'Mauritania',
            'MU' => 'Mauricio',
            'MX' => 'México',
            'FM' => 'Micronesia',
            'MD' => 'Moldavia',
            'MC' => 'Mónaco',
            'MN' => 'Mongolia',
            'ME' => 'Montenegro',
            'MA' => 'Marruecos',
            'MZ' => 'Mozambique',
            'MM' => 'Myanmar',
            'NA' => 'Namibia',
            'NR' => 'Nauru',
            'NP' => 'Nepal',
            'NL' => 'Países Bajos',
            'NZ' => 'Nueva Zelanda',
            'NI' => 'Nicaragua',
            'NE' => 'Níger',
            'NG' => 'Nigeria',
            'NO' => 'Noruega',
            'OM' => 'Omán',
            'PK' => 'Pakistán',
            'PW' => 'Palau',
            'PA' => 'Panamá',
            'PG' => 'Papúa Nueva Guinea',
            'PY' => 'Paraguay',
            'PE' => 'Perú',
            'PH' => 'Filipinas',
            'PL' => 'Polonia',
            'PT' => 'Portugal',
            'QA' => 'Catar',
            'RO' => 'Rumania',
            'RU' => 'Rusia',
            'RW' => 'Ruanda',
            'KN' => 'San Cristóbal y Nieves',
            'LC' => 'Santa Lucía',
            'VC' => 'San Vicente y las Granadinas',
            'WS' => 'Samoa',
            'SM' => 'San Marino',
            'ST' => 'Santo Tomé y Príncipe',
            'SA' => 'Arabia Saudita',
            'SN' => 'Senegal',
            'RS' => 'Serbia',
            'SC' => 'Seychelles',
            'SL' => 'Sierra Leona',
            'SG' => 'Singapur',
            'SK' => 'Eslovaquia',
            'SI' => 'Eslovenia',
            'SB' => 'Islas Salomón',
            'SO' => 'Somalia',
            'ZA' => 'Sudáfrica',
            'ES' => 'España',
            'LK' => 'Sri Lanka',
            'SD' => 'Sudán',
            'SR' => 'Surinam',
            'SE' => 'Suecia',
            'CH' => 'Suiza',
            'SY' => 'Siria',
            'TW' => 'Taiwán',
            'TJ' => 'Tayikistán',
            'TZ' => 'Tanzania',
            'TH' => 'Tailandia',
            'TL' => 'Timor-Leste',
            'TG' => 'Togo',
            'TO' => 'Tonga',
            'TT' => 'Trinidad y Tobago',
            'TN' => 'Túnez',
            'TR' => 'Turquía',
            'TM' => 'Turkmenistán',
            'TV' => 'Tuvalu',
            'UG' => 'Uganda',
            'UA' => 'Ucrania',
            'AE' => 'Emiratos Árabes Unidos',
            'GB' => 'Reino Unido',
            'US' => 'Estados Unidos',
            'UY' => 'Uruguay',
            'UZ' => 'Uzbekistán',
            'VU' => 'Vanuatu',
            'VE' => 'Venezuela',
            'VN' => 'Vietnam',
            'YE' => 'Yemen',
            'ZM' => 'Zambia',
            'ZW' => 'Zimbabue'
        ];


        $codigoUpper = strtoupper($codigo);

        if ($codigoUpper === 'SACA M') {
            return 'SACA M';
        }

        if (strlen($codigoUpper) >= 2) {
            $lastTwo = substr($codigoUpper, -2);
            return $paises[$lastTwo] ?? 'N/A';
        }

        return 'N/A';
    }

    public function toggleSacaM()
    {
        $this->codigo = $this->isSacaM ? 'SACA M' : '';
    }

    // ======================
    // RENDER
    // ======================
    public function render()
    {
        $paquetes = Paquete::where('estado', 'RECIBIDO')
            ->where(function ($query) {
                $query->where('codigo', 'like', '%' . $this->search . '%')
                    ->orWhere('cuidad', 'like', '%' . $this->search . '%')
                    ->orWhere('observacion', 'like', '%' . $this->search . '%');
            })
            ->orderBy('id', 'desc')
            ->paginate(10);

        $empresas = Empresa::orderBy('nombre')->get();

        return view('livewire.recibir', compact('paquetes', 'empresas'));
    }
}
