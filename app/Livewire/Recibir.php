<?php
// app/Livewire/Recibir.php

namespace App\Livewire;

use App\Models\Paquete;
use App\Models\Empresa;
use App\Models\Peso;
use App\Models\Tarifario;
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
    public $modalDestino     = false;
    public $paqueteDestinoId = null;
    public $modal = false;
    public $paquete_id;
    public $codigo;
    public $destinatario;
    public $cuidad;
    public $peso;
    public $origen;
    public $destino;
    public $observacion;
    public $grupo = false;
    public $almacenaje = false;
    public $ciudad;
    public $users;
    public $aduana;
    public $direccion_paquete;
    public $telefono;
    public $casilla;
    public $correo_destinatario;

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
        'origen'             => 'nullable|string|max:100',
        'observacion'        => 'nullable|string|max:255',
        'grupo'              => 'boolean',
        'almacenaje'         => 'boolean',
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


    /* public function mount()
    {
        $this->searchInput = $this->search;
        $this->cuidad = Auth::user()->city;
        $this->ciudad = Auth::user()->city;
    } */


    public function mount()
    {
        $this->cuidad = Auth::user()->city;
        $this->ciudad = Auth::user()->city;

    }




    public function buscar()
    {
        $this->search = trim($this->searchInput);

        if (! $this->search) {
            session()->flash('message', 'Debe ingresar un código para buscar.');
            return;
        }

        $this->resetPage();  // <--- Esto reinicia la paginación para que filtre bien

        $url = config('services.correos.url') . '/' . $this->search;

        $response = Http::withOptions([
            'verify'           => false,
            'curl'             => [
                CURLOPT_SSLVERSION   => CURL_SSLVERSION_TLSv1_2,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_IPRESOLVE    => CURL_IPRESOLVE_V4,
            ],
        ])
            ->withToken(config('services.correos.token'))
            ->acceptJson()
            ->get($url);

        if (! $response->successful()) {
            session()->flash('message', "Paquete no encontrado o error API ({$response->status()}).");
            return;
        }

        $data = $response->json();

        if (
            ($data['VENTANILLA']) !== 'ECA' ||
            ($data['ESTADO']) !== 'DESPACHO' ||
            strtoupper($data['CUIDAD']) !== strtoupper(Auth::user()->city)
        ) {
            session()->flash('message', 'El paquete no cumple con los criterios de Ventanilla, Estado o Ciudad.');
            return;
        }

        // Actualizamos o creamos el paquete SIN asignar 'destino'
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
        $this->modalDestino     = true;
    }


    public function asignarDestino()
    {
        $this->validateOnly('destino');

        Paquete::findOrFail($this->paqueteDestinoId)
            ->update(['destino' => $this->destino]);

        session()->flash('message', "Destino asignado al paquete {$this->paqueteDestinoId}.");
        $this->modalDestino     = false;
        $this->reset(['destino', 'paqueteDestinoId', 'searchInput', 'search']);
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        $this->selectAll = ! $this->selectAll;
        if ($this->selectAll) {
            $this->selected = Paquete::where('estado', 'RECIBIDO')
                ->where(function ($q) {
                    $q->where('codigo', 'like', '%' . $this->search . '%')
                        ->orWhere('cuidad', 'like', '%' . $this->search . '%')
                        ->orWhere('observacion', 'like', '%' . $this->search . '%');
                })
                ->orderBy('id', 'desc')
                ->paginate(10)
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
            /** @var Paquete $paquete */
            $paquete = Paquete::find($id);

            // Precio fijo de 17 Bs
            $precio = 17;

            // Actualizar estado y precio
            $paquete->update([
                'estado' => 'ALMACEN',
                'precio' => $precio,
            ]);

            Evento::create([
                'accion' => 'RECIBIDO',
                'descripcion' => 'Paquete Recibido',
                'user_id' => Auth::user()->name,
                'codigo' => $paquete->codigo,
            ]);
        }

        $this->selected  = [];
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

    // --- Lógica Crear / Editar ---
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
            'almacenaje'
        ]);
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
        $this->paquete_id  = $p->id;
        $this->codigo      = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->direccion_paquete     = $p->direccion_paquete;
        $this->telefono      = $p->telefono;
        $this->correo_destinatario      = $p->correo_destinatario;
        $this->cuidad      = $p->cuidad;
        $this->aduana       = $p->aduana;
        $this->peso        = $p->peso;
        $this->casilla        = $p->casilla;
        $this->observacion = $p->observacion;
        $this->modal       = true;
        $this->grupo         = (bool) $p->grupo;
        $this->almacenaje   = (bool) $p->almacenaje;
    }

    public function guardar()

    {


        //dd($this->aduana);


        /*  $data = $this->validate();
        dd($data);                              esto sirve para verificar los datos que ese esta guardando*/



        $this->validate();

        // Siempre tomamos la ciudad del usuario autenticado
        $this->cuidad = Auth::user()->city;

        $data = [
            'codigo'       => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'cuidad'       => strtoupper($this->cuidad),
            'direccion_paquete'    => strtoupper($this->direccion_paquete),
            'telefono'     => $this->telefono,
            'correo_destinatario'       => $this->correo_destinatario,
            'aduana'       => strtoupper($this->aduana),
            'peso'         => $this->peso,
            'casilla'         => $this->casilla,
            'observacion'  => strtoupper($this->observacion),
            'grupo'        => $this->grupo ? 1 : 0,
            'almacenaje'   => $this->almacenaje ? 1 : 0,
            'cantidad'     => '1',
        ];

        //dd($this->correo, $data['correo_destinatario']); // 👈 esto mostrará lo que se va a guardar


        $iso = substr($data['codigo'], -2);
        $data['origen'] = $this->getCountryTranslation($iso);

        if ($this->paquete_id) {
            // Edición
            $model = Paquete::findOrFail($this->paquete_id);
            $model->update($data);
            session()->flash('message', 'Paquete actualizado.');

            Evento::create([
                'accion'      => 'EDICION',
                'descripcion' => 'Paquete Editado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $data['codigo'],
            ]);
        } else {
            // Creación
            $data['estado'] = 'RECIBIDO';
            $data['user']   = Auth::user()->name;
            $data['precio'] = 17; // <--- Precio fijo


            Paquete::create($data);



            session()->flash('message', 'Paquete registrado como RECIBIDO.');

            Evento::create([
                'accion'      => 'CREACION',
                'descripcion' => 'Paquete Creado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $data['codigo'],
            ]);
        }

        $this->cerrarModal();
        $this->reset(['paquete_id', 'codigo', 'destinatario', 'cuidad', 'direccion_paquete', 'telefono', 'correo_destinatario', 'peso', 'casilla', 'observacion', 'aduana']);
    }





    /* public function editar($id)
    {
        $p = Paquete::findOrFail($id);
        $this->paquete_id  = $p->id;
        $this->codigo      = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->cuidad      = $p->cuidad;
        $this->destino      = $p->destino;
        $this->peso        = $p->peso;
        $this->observacion = $p->observacion;
        $this->modal       = true;
        $this->grupo         = (bool) $p->grupo;
        $this->almacenaje   = (bool) $p->almacenaje;
    }

    public function guardar()
    {
        $this->validate();

        $data = [
            'codigo'       => strtoupper($this->codigo),
            'destinatario' => strtoupper($this->destinatario),
            'ciudad'       => $this->cuidad,
            'destino'      => $this->destino,
            'peso'         => $this->peso,
            'observacion'  => strtoupper($this->observacion),
            'grupo'         => $this->grupo ? 1 : 0,
            'almacenaje'    => $this->almacenaje ? 1 : 0,
            'cantidad'      => '1',
        ];

        $iso = substr($data['codigo'], -2);
        $data['origen'] = $this->getCountryTranslation($iso);

        if ($this->paquete_id) {
            // Edición
            $model = Paquete::findOrFail($this->paquete_id);
            $model->update($data);
            session()->flash('message', 'Paquete actualizado.');

            Evento::create([
                'accion'      => 'EDICION',
                'descripcion' => 'Paquete Editado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $data['codigo'],
            ]);
        } else {
            // Creación
            $data['estado'] = 'RECIBIDO';
            $data['user']   = Auth::user()->name;
            Paquete::create($data);
            session()->flash('message', 'Paquete registrado como RECIBIDO.');

            Evento::create([
                'accion'      => 'CREACION',
                'descripcion' => 'Paquete Creado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $data['codigo'],
            ]);
        }

        $this->cerrarModal();
        $this->reset(['paquete_id', 'codigo', 'destinatario', 'cuidad', 'peso', 'observacion']);
    } */

    private function getCountryTranslation(string $iso): string
    {
        $translations = [
            'AF' => 'AFGHANISTAN',
            'AL' => 'ALBANIA',
            'DZ' => 'ALGERIA',
            'AS' => 'AMERICAN SAMOA',
            'AD' => 'ANDORRA',
            'AO' => 'ANGOLA',
            'AQ' => 'ANTARCTICA',
            'AG' => 'ANTIGUA AND BARBUDA',
            'AR' => 'ARGENTINA',
            'AM' => 'ARMENIA',
            'AW' => 'ARUBA',
            'AU' => 'AUSTRALIA',
            'AT' => 'AUSTRIA',
            'AZ' => 'AZERBAIJAN',
            'BS' => 'BAHAMAS',
            'BH' => 'BAHRAIN',
            'BD' => 'BANGLADESH',
            'BB' => 'BARBADOS',
            'BY' => 'BELARUS',
            'BE' => 'BELGIUM',
            'BZ' => 'BELIZE',
            'BJ' => 'BENIN',
            'BM' => 'BERMUDA',
            'BT' => 'BHUTAN',
            'BO' => 'BOLIVIA',
            'BA' => 'BOSNIA AND HERZEGOVINA',
            'BW' => 'BOTSWANA',
            'BV' => 'BOUVET ISLAND',
            'BR' => 'BRAZIL',
            'IO' => 'BRITISH INDIAN OCEAN TERRITORY',
            'BN' => 'BRUNEI DARUSSALAM',
            'BG' => 'BULGARIA',
            'BF' => 'BURKINA FASO',
            'BI' => 'BURUNDI',
            'KH' => 'CAMBODIA',
            'CM' => 'CAMEROON',
            'CA' => 'CANADA',
            'CV' => 'CAPE VERDE',
            'KY' => 'CAYMAN ISLANDS',
            'CF' => 'CENTRAL AFRICAN REPUBLIC',
            'TD' => 'CHAD',
            'CL' => 'CHILE',
            'CN' => 'CHINA',
            'CX' => 'CHRISTMAS ISLAND',
            'CC' => 'COCOS (KEELING) ISLANDS',
            'CO' => 'COLOMBIA',
            'KM' => 'COMOROS',
            'CG' => 'CONGO',
            'CD' => 'CONGO, THE DEMOCRATIC REPUBLIC OF THE',
            'CK' => 'COOK ISLANDS',
            'CR' => 'COSTA RICA',
            'CI' => "CÔTE D'IVOIRE",
            'HR' => 'CROATIA',
            'CU' => 'CUBA',
            'CY' => 'CYPRUS',
            'CZ' => 'CZECH REPUBLIC',
            'DK' => 'DENMARK',
            'DJ' => 'DJIBOUTI',
            'DM' => 'DOMINICA',
            'DO' => 'DOMINICAN REPUBLIC',
            'EC' => 'ECUADOR',
            'EG' => 'EGYPT',
            'SV' => 'EL SALVADOR',
            'GQ' => 'EQUATORIAL GUINEA',
            'ER' => 'ERITREA',
            'EE' => 'ESTONIA',
            'ET' => 'ETHIOPIA',
            'FK' => 'FALKLAND ISLANDS (MALVINAS)',
            'FO' => 'FAROE ISLANDS',
            'FJ' => 'FIJI',
            'FI' => 'FINLAND',
            'FR' => 'FRANCE',
            'GF' => 'FRENCH GUIANA',
            'PF' => 'FRENCH POLYNESIA',
            'TF' => 'FRENCH SOUTHERN TERRITORIES',
            'GA' => 'GABON',
            'GM' => 'GAMBIA',
            'GE' => 'GEORGIA',
            'DE' => 'GERMANY',
            'GH' => 'GHANA',
            'GI' => 'GIBRALTAR',
            'GR' => 'GREECE',
            'GL' => 'GREENLAND',
            'GD' => 'GRENADA',
            'GP' => 'GUADELOUPE',
            'GU' => 'GUAM',
            'GT' => 'GUATEMALA',
            'GN' => 'GUINEA',
            'GW' => 'GUINEA-BISSAU',
            'GY' => 'GUYANA',
            'HT' => 'HAITI',
            'HM' => 'HEARD ISLAND AND MCDONALD ISLANDS',
            'HN' => 'HONDURAS',
            'HK' => 'HONG KONG',
            'HU' => 'HUNGARY',
            'IS' => 'ICELAND',
            'IN' => 'INDIA',
            'ID' => 'INDONESIA',
            'IR' => 'IRAN, ISLAMIC REPUBLIC OF',
            'IQ' => 'IRAQ',
            'IE' => 'IRELAND',
            'IL' => 'ISRAEL',
            'IT' => 'ITALY',
            'JM' => 'JAMAICA',
            'JP' => 'JAPAN',
            'JO' => 'JORDAN',
            'KZ' => 'KAZAKHSTAN',
            'KE' => 'KENYA',
            'KI' => 'KIRIBATI',
            'KP' => 'KOREA, DEMOCRATIC PEOPLE\'S REPUBLIC OF',
            'KR' => 'KOREA, REPUBLIC OF',
            'KW' => 'KUWAIT',
            'KG' => 'KYRGYZSTAN',
            'LA' => 'LAO PEOPLE\'S DEMOCRATIC REPUBLIC',
            'LV' => 'LATVIA',
            'LB' => 'LEBANON',
            'LS' => 'LESOTHO',
            'LR' => 'LIBERIA',
            'LY' => 'LIBYAN ARAB JAMAHIRIYA',
            'LI' => 'LIECHTENSTEIN',
            'LT' => 'LITHUANIA',
            'LU' => 'LUXEMBOURG',
            'MO' => 'MACAO',
            'MK' => 'MACEDONIA, THE FORMER YUGOSLAV REPUBLIC OF',
            'MG' => 'MADAGASCAR',
            'MW' => 'MALAWI',
            'MY' => 'MALAYSIA',
            'MV' => 'MALDIVES',
            'ML' => 'MALI',
            'MT' => 'MALTA',
            'MH' => 'MARSHALL ISLANDS',
            'MQ' => 'MARTINIQUE',
            'MR' => 'MAURITANIA',
            'MU' => 'MAURITIUS',
            'YT' => 'MAYOTTE',
            'MX' => 'MEXICO',
            'FM' => 'MICRONESIA, FEDERATED STATES OF',
            'MD' => 'MOLDOVA, REPUBLIC OF',
            'MC' => 'MONACO',
            'MN' => 'MONGOLIA',
            'MS' => 'MONTSERRAT',
            'MA' => 'MOROCCO',
            'MZ' => 'MOZAMBIQUE',
            'MM' => 'MYANMAR',
            'NA' => 'NAMIBIA',
            'NR' => 'NAURU',
            'NP' => 'NEPAL',
            'NL' => 'NETHERLANDS',
            'AN' => 'NETHERLANDS ANTILLES',
            'NC' => 'NEW CALEDONIA',
            'NZ' => 'NEW ZEALAND',
            'NI' => 'NICARAGUA',
            'NE' => 'NIGER',
            'NG' => 'NIGERIA',
            'NU' => 'NIUE',
            'NF' => 'NORFOLK ISLAND',
            'MP' => 'NORTHERN MARIANA ISLANDS',
            'NO' => 'NORWAY',
            'OM' => 'OMAN',
            'PK' => 'PAKISTAN',
            'PW' => 'PALAU',
            'PS' => 'PALESTINIAN TERRITORY, OCCUPIED',
            'PA' => 'PANAMA',
            'PG' => 'PAPUA NEW GUINEA',
            'PY' => 'PARAGUAY',
            'PE' => 'PERU',
            'PH' => 'PHILIPPINES',
            'PN' => 'PITCAIRN',
            'PL' => 'POLAND',
            'PR' => 'PUERTO RICO',
            'QA' => 'QATAR',
            'RE' => 'RÉUNION',
            'RO' => 'ROMANIA',
            'RU' => 'RUSSIAN FEDERATION',
            'RW' => 'RWANDA',
            'SH' => 'SAINT HELENA',
            'KN' => 'SAINT KITTS AND NEVIS',
            'LC' => 'SAINT LUCIA',
            'PM' => 'SAINT PIERRE AND MIQUELON',
            'VC' => 'SAINT VINCENT AND THE GRENADINES',
            'WS' => 'SAMOA',
            'SM' => 'SAN MARINO',
            'ST' => 'SAO TOME AND PRINCIPE',
            'SA' => 'SAUDI ARABIA',
            'SN' => 'SENEGAL',
            'CS' => 'SERBIA AND MONTENEGRO',
            'SC' => 'SEYCHELLES',
            'SL' => 'SIERRA LEONE',
            'SG' => 'SINGAPORE',
            'SK' => 'SLOVAKIA',
            'SI' => 'SLOVENIA',
            'SB' => 'SOLOMON ISLANDS',
            'SO' => 'SOMALIA',
            'ZA' => 'SOUTH AFRICA',
            'GS' => 'SOUTH GEORGIA AND THE SOUTH SANDWICH ISLANDS',
            'ES' => 'SPAIN',
            'LK' => 'SRI LANKA',
            'SD' => 'SUDAN',
            'SR' => 'SURINAME',
            'SJ' => 'SVALBARD AND JAN MAYEN',
            'SZ' => 'SWAZILAND',
            'SE' => 'SWEDEN',
            'CH' => 'SWITZERLAND',
            'SY' => 'SYRIAN ARAB REPUBLIC',
            'TW' => 'TAIWAN, PROVINCE OF CHINA',
            'TJ' => 'TAJIKISTAN',
            'TZ' => 'TANZANIA, UNITED REPUBLIC OF',
            'TH' => 'THAILAND',
            'TL' => 'TIMOR-LESTE',
            'TG' => 'TOGO',
            'TK' => 'TOKELAU',
            'TO' => 'TONGA',
            'TT' => 'TRINIDAD AND TOBAGO',
            'TN' => 'TUNISIA',
            'TR' => 'TURKEY',
            'TM' => 'TURKMENISTAN',
            'TC' => 'TURKS AND CAICOS ISLANDS',
            'TV' => 'TUVALU',
            'UG' => 'UGANDA',
            'UA' => 'UKRAINE',
            'AE' => 'UNITED ARAB EMIRATES',
            'GB' => 'UNITED KINGDOM',
            'US' => 'UNITED STATES',
            'UM' => 'UNITED STATES MINOR OUTLYING ISLANDS',
            'UY' => 'URUGUAY',
            'UZ' => 'UZBEKISTAN',
            'VU' => 'VANUATU',
            'VE' => 'VENEZUELA',
            'VN' => 'VIET NAM',
            'VG' => 'VIRGIN ISLANDS, BRITISH',
            'VI' => 'VIRGIN ISLANDS, U.S.',
            'WF' => 'WALLIS AND FUTUNA',
            'EH' => 'WESTERN SAHARA',
            'YE' => 'YEMEN',
            'ZM' => 'ZAMBIA',
            'ZW' => 'ZIMBABWE',
        ];

        // Normalizamos a mayúsculas
        $iso = strtoupper($iso);

        return $translations[$iso] ?? 'DESCONOCIDO';
    }

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

        // Carga todas las empresas ordenadas por nombre
        $empresas = Empresa::orderBy('nombre')->get();

        return view('livewire.recibir', compact('paquetes', 'empresas'));
    }
}
