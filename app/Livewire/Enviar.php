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
use PDF;

class Enviar extends Component
{
    use WithPagination;

    public $search = '';
    public $searchInput = '';
    public $selectAll = false;
    public $selected = [];

    // Modal único
    public $modal = false;
    public $paquete_id = null;

    // Campos del formulario
    public $codigo;
    public $destinatario;
    public $cuidad;
    public $origen;
    public $destino;
    public $peso;
    public $cantidad = 1;
    public $observacion;
    public $certificacion = false;
    public $grupo = false;
    public $almacenaje = false;
    public $pda;


    protected $paginationTheme = 'bootstrap';

    protected $rules = [
        'codigo'        => 'required|string|max:50',
        'destinatario'  => 'required|string|max:100',
        'cuidad'        => 'nullable|string|max:50',
        'origen'        => 'nullable|string|max:100',
        'destino'       => 'required|string|max:50',
        'peso'          => 'nullable|numeric',
        'cantidad'      => 'required|integer|min:1',
        'observacion'   => 'nullable|string|max:255',
        'pda'           => 'nullable|numeric',
        'certificacion' => 'boolean',
        'grupo'         => 'boolean',
        'almacenaje'    => 'boolean',
    ];

    public function mount()
    {
        $this->searchInput = $this->search;
    }

    public function buscar()
    {
        $this->search = trim($this->searchInput);
        if (!$this->search) {
            session()->flash('message', 'Debe ingresar un código o término para buscar.');
            return;
        }
        $this->resetPage();
    }

    public function toggleSelectAll()
    {
        $this->selectAll = !$this->selectAll;
        if ($this->selectAll) {
            $this->selected = Paquete::where('estado', 'ENVIANDO')
                ->where(function ($q) {
                    $q->where('codigo', 'like', "%{$this->search}%")
                        ->orWhere('cuidad', 'like', "%{$this->search}%")
                        ->orWhere('observacion', 'like', "%{$this->search}%");
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

        $packages = Paquete::whereIn('id', $this->selected)->get();

        foreach ($packages as $p) {
            // 1) Buscamos empresa y categoría de peso
            $empresa = Empresa::whereRaw('UPPER(nombre)=?', [strtoupper($p->destinatario)])->first();
            $pesoCat = Peso::where('min', '<=', $p->peso)
                ->where('max', '>=', $p->peso)
                ->first();

            // 2) Obtenemos tarifa base
            $unit = 0;
            if ($empresa && $pesoCat) {
                $tarifa = Tarifario::where('empresa', $empresa->id)
                    ->where('peso', $pesoCat->id)
                    ->first();

                if ($tarifa && isset($tarifa->{strtolower($p->destino)})) {
                    $unit = $tarifa->{strtolower($p->destino)};
                }
            }

            // 3) Extra 
            if ($p->certificacion) {
                $unit += 8;
            }

            if ($p->almacenaje) {
                $unit += 15;
            }

            // 4) Determinamos cuántas unidades multiplicar:
            //    - Si grupo == 1: multiplicamos por la cantidad real
            //    - Si grupo == 0: multiplicamos solo por 1
            $multiplier = $p->grupo ? $p->cantidad : 1;

            // 5) Cálculo final
            $total = $unit * $multiplier;

            // 6) Actualizamos el paquete y registramos evento
            $p->update([
                'estado' => 'DESPACHADO',
                'precio' => $total,
            ]);

            Evento::create([
                'accion'      => 'DESPACHADO',
                'descripcion' => 'Paquete Despachado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $p->codigo,
            ]);
        }

        // 7) Reset de selección y paginación
        $this->selected  = [];
        $this->selectAll = false;
        $this->resetPage();

        // 8) Generación de PDF
        $pdf = PDF::loadView('pdf.despacho', ['packages' => $packages]);
        return response()->streamDownload(
            fn() => print($pdf->output()),
            'recepcion_' . now()->format('Ymd_His') . '.pdf'
        );
    }


    public function eliminarPaquete($id)
    {
        $p = Paquete::findOrFail($id);
        $p->forceDelete();
        Evento::create([
            'accion'      => 'ELIMINADO',
            'descripcion' => 'Paquete Eliminado',
            'user_id'     => Auth::user()->name,
            'codigo'      => $p->codigo,
        ]);
        session()->flash('message', 'Paquete eliminado permanentemente.');
        $this->resetPage();
    }

    public function abrirModal()
    {
        $this->reset(['paquete_id', 'codigo', 'destinatario', 'cuidad', 'destino', 'peso', 'cantidad', 'observacion', 'grupo', 'certificacion', 'almacenaje', 'pda']);
        $this->modal = true;
    }

    public function cerrarModal()
    {
        $this->modal = false;
    }

    public function editar($id)
    {
        $p = Paquete::findOrFail($id);
        $this->paquete_id   = $p->id;
        $this->codigo       = $p->codigo;
        $this->destinatario = $p->destinatario;
        $this->cuidad       = $p->cuidad;
        $this->destino      = $p->destino;
        $this->peso         = $p->peso;
        $this->cantidad     = $p->cantidad;
        $this->observacion  = $p->observacion;
        $this->pda          = $p->pda;
        $this->certificacion = (bool)$p->certificacion;
        $this->grupo         = (bool) $p->grupo;
        $this->almacenaje   = (bool) $p->almacenaje;
        $this->modal        = true;
    }

    public function guardar()
    {
        $this->validate();

        // Preparamos el array de datos
        $data = [
            'codigo'        => strtoupper($this->codigo),
            'destinatario'  => strtoupper($this->destinatario),
            'cuidad'        => strtoupper($this->cuidad),
            'destino'       => $this->destino,
            'peso'          => $this->peso,
            'cantidad'      => $this->cantidad,
            'pda'           => $this->pda,
            'observacion'   => strtoupper($this->observacion),
            'certificacion' => $this->certificacion ? 1 : 0,
            'grupo'         => $this->grupo ? 1 : 0,
            'almacenaje'    => $this->almacenaje ? 1 : 0,
        ];

        // 1) Extraemos las dos últimas letras del código
        $iso = substr($data['codigo'], -2);

        // 2) Traducimos a nombre de país
        $data['origen'] = $this->getCountryTranslation($iso);

        if ($this->paquete_id) {
            // Actualización existente
            $p = Paquete::findOrFail($this->paquete_id);
            $p->update($data);
            Evento::create([
                'accion'      => 'EDICION',
                'descripcion' => 'Paquete Editado',
                'user_id'     => Auth::user()->name,
                'codigo'      => $p->codigo,
            ]);
            session()->flash('message', 'Paquete actualizado.');
        } else {
            // Nuevo registro
            $data['estado'] = 'ENVIANDO';
            $data['user']   = Auth::user()->name;
            $p = Paquete::create($data);
            Evento::create([
                'accion'      => 'ENVIANDO',
                'descripcion' => 'Paquete asignado para envío',
                'user_id'     => Auth::user()->name,
                'codigo'      => $p->codigo,
            ]);
            session()->flash('message', 'Paquete registrado como ENVIANDO.');
        }

        $this->cerrarModal();
    }


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
        $paquetes = Paquete::where('estado', 'ENVIANDO')
            ->where(
                fn($q) =>
                $q->where('codigo', 'like', "%{$this->search}%")
                    ->orWhere('cuidad', 'like', "%{$this->search}%")
                    ->orWhere('observacion', 'like', "%{$this->search}%")
            )
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        $empresas = Empresa::orderBy('nombre')->get();

        return view('livewire.enviar', compact('paquetes', 'empresas'));
    }
}
