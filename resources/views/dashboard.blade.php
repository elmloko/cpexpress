@extends('adminlte::page')
@section('plugins.Chartjs', true)
@section('title', 'Dashboard')

@section('content_header')
    <h1>Sistema de encomiendas</h1>
    <form action="{{ route('dashboard.kardex') }}" method="GET" class="form-inline mt-2 mb-4">
        <div class="form-group mr-3">
            <label for="start_date" class="mr-1">Desde:</label>
            <input type="date" name="start_date" id="start_date" class="form-control" value="{{ request('start_date') ?? now()->subDays(14)->format('Y-m-d') }}" required>
        </div>
        <div class="form-group mr-3">
            <label for="end_date" class="mr-1">Hasta:</label>
            <input type="date" name="end_date" id="end_date" class="form-control" value="{{ request('end_date') ?? now()->format('Y-m-d') }}" required>
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Generar Kardex PDF
        </button>
    </form>
@stop

@section('content')
    <div class="row">
        {{-- Total --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-info">
                <div class="inner">
                    <h3>{{ $totalPaquetes }}</h3>
                    <p>Total Paquetes</p>
                </div>
                <div class="icon"><i class="fas fa-box"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        {{-- Recibido --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success state-box" data-state="RECIBIDO" title="Ver histograma RECIBIDO" style="cursor:pointer;">
                <div class="inner">
                    <h3>{{ $totalRecibido }}</h3>
                    <p>Recibido</p>
                </div>
                <div class="icon"><i class="fas fa-inbox"></i></div>
                <a class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Inventario --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-secondary state-box" data-state="INVENTARIO" title="Ver histograma INVENTARIO" style="cursor:pointer;">
                <div class="inner">
                    <h3>{{ $totalInventario }}</h3>
                    <p>Inventario</p>
                </div>
                <div class="icon"><i class="fas fa-list"></i></div>
                <a class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Rezago --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning state-box" data-state="REZAGO" title="Ver histograma REZAGO" style="cursor:pointer;">
                <div class="inner">
                    <h3>{{ $totalRezago }}</h3>
                    <p>Rezago</p>
                </div>
                <div class="icon"><i class="fas fa-clock"></i></div>
                <a class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Almacén --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger state-box" data-state="ALMACEN" title="Ver histograma ALMACEN" style="cursor:pointer;">
                <div class="inner">
                    <h3>{{ $totalAlmacen }}</h3>
                    <p>Almacén</p>
                </div>
                <div class="icon"><i class="fas fa-warehouse"></i></div>
                <a class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>

        {{-- Despacho --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-primary state-box" data-state="DESPACHO" title="Ver histograma DESPACHO" style="cursor:pointer;">
                <div class="inner">
                    <h3>{{ $totalDespacho }}</h3>
                    <p>Despacho</p>
                </div>
                <div class="icon"><i class="fas fa-truck"></i></div>
                <a class="small-box-footer">Ver detalle <i class="fas fa-arrow-circle-right"></i></a>
            </div>
        </div>
    </div>

    {{-- Area del histograma --}}
    <div class="row mt-4">
        <div class="col-12">
            <div class="card" id="stateChartCard">
                <div class="card-header">
                    <h3 id="stateChartTitle" class="card-title">Seleccione un estado para ver el histograma</h3>
                </div>
                <div class="card-body" style="position: relative; height:350px;">
                    <div id="chartLoader" style="display:none; text-align:center; padding-top:90px;">
                        <i class="fas fa-spinner fa-spin fa-2x"></i>
                        <p>Cargando...</p>
                    </div>
                    <canvas id="stateHistogramChart"></canvas>
                    <div id="noDataMessage" style="display:none; text-align:center; padding-top:90px;">
                        <p class="text-muted">No hay datos en el rango seleccionado.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('footer')
@stop

@section('js')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Elementos
    const startEl = document.getElementById('start_date');
    const endEl   = document.getElementById('end_date');
    const loader   = document.getElementById('chartLoader');
    const noData   = document.getElementById('noDataMessage');
    const titleEl  = document.getElementById('stateChartTitle');

    // Inicializar Chart.js (vacío)
    const ctx = document.getElementById('stateHistogramChart').getContext('2d');
    const histogramChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: [],
            datasets: [{
                label: 'Paquetes',
                data: [],
                backgroundColor: [], // set colors dynamically
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                x: { title: { display: true, text: 'Fecha' } },
                y: { beginAtZero: true, title: { display: true, text: 'Cantidad' } }
            }
        }
    });

    // Colores simples por estado (puedes ajustar)
    const stateColors = {
        'RECIBIDO':    'rgba(75, 192, 192, 0.7)',
        'INVENTARIO':  'rgba(153, 102, 255, 0.7)',
        'REZAGO':      'rgba(255, 159, 64, 0.8)',
        'ALMACEN':     'rgba(255, 99, 132, 0.8)',
        'DESPACHO':    'rgba(54, 162, 235, 0.8)'
    };

    function showLoader(show = true) {
        loader.style.display = show ? 'block' : 'none';
        noData.style.display = 'none';
    }

    function updateChart(labels, data, state) {
        if (!labels || labels.length === 0 || data.every(v => v === 0)) {
            histogramChart.data.labels = [];
            histogramChart.data.datasets[0].data = [];
            histogramChart.update();
            noData.style.display = 'block';
            titleEl.textContent = `Histograma: ${state} (sin datos)`;
            return;
        }

        histogramChart.data.labels = labels;
        histogramChart.data.datasets[0].data = data;
        histogramChart.data.datasets[0].label = `${state} - Paquetes`;
        histogramChart.data.datasets[0].backgroundColor = labels.map(_ => stateColors[state] || 'rgba(100,100,100,0.7)');
        histogramChart.update();
        noData.style.display = 'none';
        titleEl.textContent = `Histograma: ${state}`;
    }

    async function fetchStateData(state) {
        const startDate = startEl.value;
        const endDate   = endEl.value;

        if (!startDate || !endDate) {
            alert('Selecciona un rango de fechas.');
            return;
        }

        showLoader(true);

        const url = new URL("{{ route('dashboard.stateStats') }}", window.location.origin);
        url.searchParams.set('state', state);
        url.searchParams.set('start_date', startDate);
        url.searchParams.set('end_date', endDate);

        try {
            const resp = await fetch(url.toString(), {
                headers: { 'X-Requested-With': 'XMLHttpRequest' }
            });

            if (!resp.ok) {
                const err = await resp.json().catch(()=>({message:resp.statusText}));
                console.error('Error', err);
                alert('Error al obtener datos.');
                showLoader(false);
                return;
            }

            const json = await resp.json();
            updateChart(json.labels, json.data, json.state);
        } catch (e) {
            console.error(e);
            alert('Error de conexión.');
        } finally {
            showLoader(false);
        }
    }

    // Eventos click en los small-box
    document.querySelectorAll('.state-box').forEach(el => {
        el.addEventListener('click', () => {
            const state = el.getAttribute('data-state');
            fetchStateData(state);
        });
    });

    // (Opcional) cargar por defecto el histograma de RECIBIDO al abrir
    // fetchStateData('RECIBIDO');
});
</script>
@stop
