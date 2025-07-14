<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Manifiesto Despacho</title>
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

    <table class="first-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Código</th>
                <th>Destinatario</th>
                <th>Cantidad</th>
                <th>Tarifa</th>
                <th>Tarifa</th>
                <th>Estado</th>
                <th>Peso (kg)</th>
                <th>Precio (Bs)</th>
                <th>Fecha envio</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($packages as $i => $pkg)
                <tr>
                    <td>{{ $i + 1 }}</td>
                    <td>{{ $pkg->codigo }}</td>
                    <td>{{ $pkg->destinatario }}</td>
                    <td>{{ $pkg->cantidad }}</td>
                    <td>{{ $pkg->cuidad }}</td>
                    <td>{{ $pkg->destino }}</td>
                    <td>
                        @if ($pkg->estado === 'INVENTARIO')
                            RECEPCIONADO
                        @elseif($pkg->estado === 'DESPACHO')
                            ENVIADO
                        @else
                            {{ $pkg->estado }}
                        @endif
                    </td>
                    <td>{{ number_format($pkg->peso, 2) }}</td>
                    <td>{{ number_format($pkg->precio, 2) }}</td>
                    <td>{{ $pkg->updated_at }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="2" style="text-align: right;">
                </td>
                <td colspan="1" style="text-align: right;">
                    Total Cantidad Paquetes:
                </td>
                <td>
                    {{ number_format($packages->sum('cantidad'), 2) }}
                </td>
                <td colspan="4" style="text-align: right;">
                    Total Precio (Bs):
                </td>
                <td>
                    {{ number_format($packages->sum('precio'), 2) }}
                </td>
                <td colspan="1" style="text-align: right;">
                </td>
            </tr>
        </tfoot>
    </table>

    <br>
    <br>
    <table style="border:none; width:100%; text-align:center;">
        <tr>
            <td style="border:none;">
                __________________________<br>REPORTE GENERADO:<br>{{ auth()->user()->name }}
            </td>
        </tr>
    </table>
</body>

</html>
