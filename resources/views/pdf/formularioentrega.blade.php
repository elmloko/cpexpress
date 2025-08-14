<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie-11">
    <title>Formulario de Entrega</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css">
    <style>
        * {
            margin: 0%;
            padding: 0%;
        }

        .center-text {
            text-align: center;
        }

        .small-text {
            font-size: 14px;
        }

        .special-text {
            text-align: center;
            font-size: 12px;
        }

        .normal-text {
            font-size: 12px;
        }

        .centro {
            margin-top: 0%;
            margin-bottom: 0%;
            margin-left: 12%
        }

        table {
            width: 100%;
        }

        table td {
            width: 100%;
        }

        p {
            margin: 0;
            padding: 0;
        }
    </style>
</head>

<body>
    @foreach ($packages as $package)
        <div class="container">
            <div class="modal-body">
                <div class="logo" style="text-align: center; margin-bottom: 10px;">
                    @php
                        $path = public_path('images/images.png');
                        $type = pathinfo($path, PATHINFO_EXTENSION);
                        $data = file_get_contents($path);
                        $base64 = 'data:image/' . $type . ';base64,' . base64_encode($data);
                    @endphp
                    <img src="{{ $base64 }}" alt="Logo" width="100" height="50">
                </div>
                <div class="center-text">
                    <h2 class="normal-text" style="margin-top: 0;">FORMULARIO DE ENTREGA</h2>
                    <h3 class="normal-text">AGENCIA BOLIVIANA DE CORREOS</h3>
                </div>
                <table class="centro">
                    <tr> 
                        <td>
                            <br>
                            <br>
                            <br>
                            <p class="barcode">
                                {!! $package->codigo ? DNS1D::getBarcodeHTML($package->codigo, 'C128', 1.25, 25) : '' !!}
                            </p>
                            <p class="small-text"><strong>Código Rastreo:</strong> {{ $package->codigo }}</p>
                            <p class="small-text"><strong>Destinatario:</strong> {{ $package->destinatario }}</p>
                            <p class="small-text"><strong>Ciudad:</strong> {{ $package->cuidad }}</p>
                            <p class="small-text"><strong>Dirección:</strong> {{ $package->direccion_paquete ?? 'N/A' }}
                            </p>
                            <p class="small-text"><strong>Ventanilla:</strong>
                                {{ $package->ventanilla ?? 'ENCOMIENDAS' }}</p>
                            <p class="small-text"><strong>Aduana:</strong> {{ $package->aduana ?? 'NO' }}</p>
                        </td>
                        <td>
                            <br>
                            <br>
                            <p class="small-text"><strong>Nro. Factura:</strong> {{ $package->id }}</p>
                            <p class="small-text"><strong>Usuario:</strong> {{ $package->user ?? auth()->user()->name }}
                            </p>
                            <p class="small-text"><strong>Tipo:</strong> {{ $package->tipo ?? 'N/A' }}</p>
                            <p class="small-text"><strong>Peso:</strong> {{ $package->peso ?? 0 }} gr.</p>
                            <p class="small-text"><strong>Precio:</strong> {{ $package->precio_final ?? 0 }} Bs.</p>
                            <p class="small-text"><strong>Entrega:</strong> {{ $package->estado ?? 'N/A' }}</p>
                            <p class="small-text"><strong>Fecha Entrega:</strong> {{ now()->format('Y-m-d H:i') }}</p>
                        </td>
                    </tr>
                </table>
                <br>
                <table>
                    <td>
                        <p class="special-text">__________________________</p>
                        <p class="special-text">RECIBIDO POR</p>
                        <p class="special-text">{{ $package->destinatario }}</p>
                    </td>
                    <td>
                        <p class="special-text">__________________________</p>
                        <p class="special-text">ENTREGADO POR</p>
                        <p class="special-text">{{ auth()->user()->name }}</p>
                    </td>
                </table>
            </div>
        </div>
    @endforeach
</body>


</html>
