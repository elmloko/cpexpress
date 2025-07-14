{{-- resources/views/dashboard.blade.php --}}

@extends('adminlte::page')

{{-- Carga automática de Chart.js --}}
@section('plugins.Chartjs', true)

@section('title', 'Dashboard')

@section('content_header')
    <h1>Dashboard</h1>
    <form action="{{ route('dashboard.kardex') }}" method="GET" class="form-inline mt-2 mb-4">
        <div class="form-group mr-3">
            <label for="start_date" class="mr-1">Desde:</label>
            <input 
                type="date" 
                name="start_date" 
                id="start_date" 
                class="form-control" 
                value="{{ request('start_date') }}" 
                required
            >
        </div>
        <div class="form-group mr-3">
            <label for="end_date" class="mr-1">Hasta:</label>
            <input 
                type="date" 
                name="end_date" 
                id="end_date" 
                class="form-control" 
                value="{{ request('end_date') }}" 
                required
            >
        </div>
        <button type="submit" class="btn btn-success">
            <i class="fas fa-file-pdf"></i> Generar Kardex PDF
        </button>
    </form>
@stop

@section('content')
    <div class="row">
        {{-- Total general --}}
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

        {{-- Enviando --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-primary">
                <div class="inner">
                    <h3>{{ $totalEnviando }}</h3>
                    <p>Enviando</p>
                </div>
                <div class="icon"><i class="fas fa-paper-plane"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        {{-- Despacho --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-warning">
                <div class="inner">
                    <h3>{{ $totalDespacho }}</h3>
                    <p>Despacho</p>
                </div>
                <div class="icon"><i class="fas fa-truck"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        {{-- Recibido --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-success">
                <div class="inner">
                    <h3>{{ $totalRecibido }}</h3>
                    <p>Recibido</p>
                </div>
                <div class="icon"><i class="fas fa-inbox"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        {{-- Almacén --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-danger">
                <div class="inner">
                    <h3>{{ $totalAlmacen }}</h3>
                    <p>Almacén</p>
                </div>
                <div class="icon"><i class="fas fa-warehouse"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>

        {{-- Inventario --}}
        <div class="col-lg-2 col-6">
            <div class="small-box bg-secondary">
                <div class="inner">
                    <h3>{{ $totalInventario }}</h3>
                    <p>Inventario</p>
                </div>
                <div class="icon"><i class="fas fa-list"></i></div>
                <p class="small-box-footer">{{ now()->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>

    {{-- Gráficos de Paquetes por Destino --}}
    <div class="row mt-4">
        {{-- Línea --}}
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Paquetes por Destino (Línea)</h3>
                </div>
                <div class="card-body" style="position: relative; height:250px;">
                    <canvas id="destinoLineChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    @include('footer')
@stop

@section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const labels = @json($destinoLabels);
            const data   = @json($destinoTotals);

            // Gráfico de línea
            new Chart(
                document.getElementById('destinoLineChart').getContext('2d'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Paquetes',
                            data: data,
                            fill: false,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                }
            );

            // Gráfico de área
            new Chart(
                document.getElementById('destinoAreaChart').getContext('2d'),
                {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: 'Paquetes',
                            data: data,
                            fill: true,
                            tension: 0.4
                        }]
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false
                    }
                }
            );
        });
    </script>
@stop
