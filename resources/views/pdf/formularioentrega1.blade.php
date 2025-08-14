<body>
    @foreach ($packages as $package)
        <div class="container" style="page-break-inside: avoid; margin-bottom: 20px;">
            <div class="modal-body">
                <div class="logo">
                    <img src="{{ public_path('images/images.png') }}" alt="" width="100" height="50">
                </div>
                <div class="center-text">
                    <h2 class="normal-text" style="margin-top: 0;">FORMULARIO DE ENTREGA</h2>
                    <h3 class="normal-text">AGENCIA BOLIVIANA DE CORREOS</h3>
                </div>
                <table class="centro">
                    <tr>
                        <td>
                            <p class="barcode">{!! DNS1D::getBarcodeHTML($package->codigo, 'C128', 1.25, 25) !!}</p>
                            <p class="small-text"><strong>Código Rastreo:</strong> {{ $package->codigo }}</p>
                            <p class="small-text"><strong>Destinatario:</strong> {{ $package->destinatario }}</p>
                            <p class="small-text"><strong>Ciudad:</strong> {{ $package->cuidad }}</p>
                            <p class="small-text"><strong>Origen:</strong> {{ $package->destino ?? 'N/A' }}</p>
                            <p class="small-text"><strong>Aduana:</strong> {{ $package->aduana }}</p>
                        </td>
                        <td>
                            <p class="small-text"><strong>Usuario:</strong> {{ $package->user }}</p>
                            <p class="small-text"><strong>Peso:</strong> {{ $package->peso }} gr.</p>
                            <p class="small-text"><strong>Precio:</strong> {{ $package->precio_final ?? $package->precio }} Bs.</p>
                            <p class="small-text"><strong>Entrega:</strong> {{ $package->estado }}</p>
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
                        <p class="special-text">__________________________ </p>
                        <p class="special-text">ENTREGADO POR</p>
                        <p class="special-text">{{ auth()->user()->name }}</p>
                    </td>
                </table>
            </div>
        </div>
    @endforeach
</body>
