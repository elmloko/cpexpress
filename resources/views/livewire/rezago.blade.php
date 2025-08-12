<div class="container-fluid">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Paquetes en Rezago</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Rezago</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header row">
                <div class="col-md-6 d-flex align-items-center">
                    <div class="col-md-3">
                        <input type="date" wire:model="dateFrom" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="date" wire:model="dateTo" class="form-control">
                    </div>
                    <div class="col-md-2 ml-2">
                        <button class="btn btn-success" wire:click="exportarExcel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" class="form-control" placeholder="Buscar..." wire:model.defer="searchInput">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-flat" wire:click="buscar">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="card-body p-0">
                @if (session()->has('message'))
                    <div class="alert alert-success m-3">{{ session('message') }}</div>
                @endif

                <table class="table table-striped mb-0">
                    <thead>
                        <tr>
                            @hasrole('Administrador')
                                <th><input type="checkbox" wire:click="toggleSelectAll" @if($selectAll) checked @endif></th>
                            @endhasrole
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Peso</th>
                            <th>Días</th>
                            <th>Teléfono</th>
                            <th>Ciudad</th>
                            <th>Observaciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paquetes as $p)
                            <tr>
                                @hasrole('Administrador')
                                    <td><input type="checkbox" wire:model="selected" value="{{ $p->id }}"></td>
                                @endhasrole
                                <td>{{ $p->codigo }}</td>
                                <td>{{ $p->destinatario }}</td>
                                <td>{{ $p->peso }} kg</td>
                                <td>{{ (int) $this->diasTranscurridos($p->created_at) }} días</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->cuidad }}</td>
                                <td>{{ $p->observacion }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay paquetes en rezago.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @hasrole('Administrador')
                <button class="btn btn-success ml-2" wire:click="enviarAlmacenSeleccionados"
                    onclick="return confirm('¿Enviar los paquetes seleccionados a ALMACEN?')">
                    <i class="fas fa-warehouse"></i> Enviar a ALMACEN
                </button>
            @endhasrole

            <div class="card-footer clearfix">
                {{ $paquetes->links() }}
            </div>
        </div>
    </section>
</div>
