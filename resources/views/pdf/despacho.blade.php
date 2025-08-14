<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manifiesto ECA</title>
    <style>
        @page {
            size: portrait;
            margin: 10mm;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: center;
            line-height: .8;
        }

        thead {
            background-color: #f2f2f2;
        }

        .header {
            display: flex;
            align-items: center;
            line-height: 0.5;
        }

        .header .title {
            flex: 1;
            text-align: center;
        }

        .title h2,
        .title h3 {
            margin: 0;
            line-height: .8;
            margin-bottom: 10px;
        }

        .first-table tfoot td {
            background-color: #f2f2f2;
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="header">
        <div>
            <img src="{{ public_path('images/images.png') }}" width="150" height="50">
        </div>
        <div class="title">
            <h2>Manifiesto de Entrega</h2>
            <h2>Envíos de Correspondencia Agrupada / Pliegos</h2>
            <h3>AGENCIA BOLIVIANA DE CORREOS</h3>
        </div>
    </div>

    <table style="margin-top:10px; border:none;">
        <tr>
            <td style="border:none; text-align:left;">
                <strong>Usuario:</strong> {{ auth()->user()->name }}
            </td>
            <td style="border:none; text-align:left;">
                <strong>Regional:</strong> {{ auth()->user()->city }}
            </td>
        </tr>
        <tr>
            <td style="border:none; text-align:left;">
                <strong>Fecha:</strong> {{ now()->format('Y-m-d H:i') }}
            </td>
            <td style="border:none;"></td>
        </tr>
    </table>
    @php
        // ¿Algún paquete tiene PDA no vacío?
        /*         $showPDA = $packages->filter(fn($p) => !empty($p->pda))->isNotEmpty();
         */
        // ¿Algún paquete tiene almacenaje == 1?
        /*         $showAlmacen = $packages->filter(fn($p) => $p->almacenaje == 1)->isNotEmpty();
         */
        // ¿Algún paquete tiene certificación == 1?
        /*         $showCert = $packages->filter(fn($p) => $p->certificacion == 1)->isNotEmpty();
         */
        // Para el footer: calcula cuántas columnas hay antes de “Precio Total”
        // (sin contar “PDA”, “Almac.” y “Certif.”)
        $staticCols = 7;
        // Total columnas antes del “Precio Total” = columnas fijas + las dinámicas mostradas
        $colspan = $staticCols -1;/*+  ($showAlmacen ? 1 : 0) */ /* + ($showCert ? 1 : 0) - 1 */ // restamos 1 para dejar la última celda del precio
    @endphp
    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Cantidad</th>
                <th>Código</th>
                <th>Destinatario</th>
                {{-- @if ($showPDA)
                    <th>PDA</th>
                @endif --}}
                <th>Peso Neto (kg)</th>
                {{-- <th>Origen</th> --}}
                <th>Destino</th>
                {{-- <th>Tarifa</th> --}}
                {{-- @if ($showAlmacen)
                    <th>Almac.</th>
                @endif
                @if ($showCert)
                    <th>Certif.</th>
                @endif --}}
                <th>Precio (Bs)</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $i => $pkg)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $pkg->cantidad }}</td>
                    <td>{{ $pkg->codigo }}</td>
                    <td>{{ $pkg->destinatario }}</td>
                    {{-- @if ($showPDA)
                        <td>{{ $pkg->pda }}</td>
                    @endif --}}
                    <td>{{ number_format($pkg->peso, 2) }}</td>
                    {{--   <td>{{ $pkg->origen }}</td> --}}
                    <td>{{ $pkg->cuidad }}</td>
                    {{--     --}}
                    {{-- @if ($showAlmacen)
                        <td>
                            @if ($pkg->almacenaje == 1)
                                {{ number_format(15, 2, '.', '') }}
                            @endif
                        </td>
                    @endif --}}

                    {{-- @if ($showCert)
                        <td>
                            @if ($pkg->certificacion == 1)
                                {{ number_format(8, 2, '.', '') }}
                            @endif
                        </td>
                    @endif --}}
                    <td>{{ number_format((int) $pkg->precio_final, 2, '.', '') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="{{ $colspan }}" style="text-align: right;">
                    Total Precio (Bs):
                </td>
                <td>{{ number_format((int) $packages->sum('precio_final'), 2, '.', '') }}</td>
            </tr>
        </tfoot>
    </table>

    <br>

    <table style="border:none; width:100%; text-align:center;">
        <tr>
            <td style="border:none;">
                __________________________<br>RECIBIDO POR
            </td>
            <td style="border:none;">
                __________________________<br>ENTREGADO POR<br>{{ auth()->user()->name }}
            </td>
        </tr>
    </table>
</body>

</html>
