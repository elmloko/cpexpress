<div class="row">
    {{-- Total general --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-info">
            <div class="inner">
                <h3>{{ $totalPaquetes }}</h3>
                <p>Total Paquetes</p>
            </div>
            <div class="icon">
                <i class="fas fa-box"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>

    {{-- Enviando --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-primary">
            <div class="inner">
                <h3>{{ $totalEnviando }}</h3>
                <p>Enviando</p>
            </div>
            <div class="icon">
                <i class="fas fa-paper-plane"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>

    {{-- Despacho --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-warning">
            <div class="inner">
                <h3>{{ $totalDespacho }}</h3>
                <p>Despacho</p>
            </div>
            <div class="icon">
                <i class="fas fa-truck"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>

    {{-- Recibido --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-success">
            <div class="inner">
                <h3>{{ $totalRecibido }}</h3>
                <p>Recibido</p>
            </div>
            <div class="icon">
                <i class="fas fa-inbox"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>

    {{-- Almacén --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-danger">
            <div class="inner">
                <h3>{{ $totalAlmacen }}</h3>
                <p>Almacén</p>
            </div>
            <div class="icon">
                <i class="fas fa-warehouse"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>

    {{-- Inventario --}}
    <div class="col-lg-2 col-6" wire:poll.10s="loadCounts">
        <div class="small-box bg-secondary">
            <div class="inner">
                <h3>{{ $totalInventario }}</h3>
                <p>Inventario</p>
            </div>
            <div class="icon">
                <i class="fas fa-list"></i>
            </div>
            <p class="small-box-footer">
                {{ now()->format('Y-m-d') }}
            </p>
        </div>
    </div>
</div>
