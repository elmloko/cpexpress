<div class="container-fluid">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Paquetes Registrados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Paquetes</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header row">
                <div class="col-md-6 d-flex">
                    {{-- <button class="btn btn-success" wire:click="abrirModal">
                        <i class="fas fa-plus-circle"></i> Crear Paquete
                    </button> --}}
                    <div class="col-md-3">
                        <input type="date" wire:model="dateFrom" class="form-control">
                    </div>
                    <div class="col-md-3">
                        <input type="date" wire:model="dateTo" class="form-control">
                    </div>
                    <!-- Botón Exportar -->
                    <div class="col-md-2">
                        <button class="btn btn-success" wire:click="exportarExcel">
                            <i class="fas fa-file-excel"></i> Excel
                        </button>
                    </div>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" class="form-control" placeholder="Buscar..."
                            wire:model.defer="searchInput">
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
                            <th>
                                <input type="checkbox" wire:click="toggleSelectAll"
                                    @if ($selectAll) checked @endif>
                            </th>
                            <th>Código</th>
                            {{-- <th>PDA</th> --}}
                            <th>Nombre</th>
                            <th>Peso</th>
                            {{-- <th>Tarifa</th> --}}
                            <th>Precio base</th>
                            <th>Precio final</th>
                            <th>Dias transcurridos</th>
                            <th>Telefono</th>
                            <th>Ciudad</th>
                            <th>Observaciones</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($paquetes as $p)
                            <tr>
                                <td>
                                    <input type="checkbox" wire:model="selected" value="{{ $p->id }}">
                                </td>
                                <td>{{ $p->codigo }}</td>
                                {{--  <td>{{ $p->pda }}</td> --}}
                                <td>{{ $p->destinatario }}</td>
                                <td>{{ $p->peso }} kg</td>
                                {{-- <td>{{ strtoupper($p->destino) }}</td> --}}
                                <td>{{ $p->precio }} Bs</td>
                                <td>{{ intval($this->calcularPrecioFinal($p->created_at)) }} Bs</td>
                                <td>{{ (int) $this->diasTranscurridos($p->created_at) }} Dias</td>
                                <td>{{ $p->telefono }}</td>
                                <td>{{ $p->cuidad }}</td>
                                <td>{{ $p->observacion }}</td>
                                <td>


                                    <button class="btn btn-sm {{ $p->notificado >= 3 ? 'btn-danger' : 'btn-info' }}"
                                        wire:click="notificar({{ $p->id }})"
                                        title="Usuario notificado {{ $p->notificado }} veces"
                                        @if ($p->notificado >= 3) disabled @endif>
                                        <i class="fas fa-bell"></i> Notificado ({{ $p->notificado ?? 0 }})
                                    </button>

                                    <button class="btn btn-sm btn-warning" wire:click="editar({{ $p->id }})">
                                        <i class="fas fa-edit"></i> Editar
                                    </button>


                                    <button class="btn btn-sm btn-danger"
                                        wire:click="enviarARezago({{ $p->id }})">
                                        <i class="fas fa-clock"></i> Rezago
                                    </button>
                                </td>


                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center">No hay resultados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button class="btn btn-danger ml-2" wire:click="darBajaSeleccionados"
                onclick="return confirm('¿Estás seguro de eliminar los paquetes seleccionados?')">
                <i class="fas fa-box-open"></i> Dar de baja
            </button>
            <div class="card-footer clearfix">
                {{ $paquetes->links() }}
            </div>
        </div>
    </section>

    <!-- Modal -->
    <div class="modal fade @if ($modal) show d-block @endif" tabindex="-1"
        style="background: rgba(0,0,0,0.5);" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $paquete_id ? 'Editar Paquete' : 'Crear Paquete' }}</h5>
                    <button type="button" class="close" wire:click="cerrarModal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <!-- Columna izquierda -->
                        <div class="col-md-6">

                            @hasrole('Administrador')
                                <div class="form-group">
                                    <label>Código</label>
                                    <input type="text" wire:model.defer="codigo" class="form-control"
                                        style="text-transform: uppercase;">
                                    @error('codigo')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="form-group">
                                    <label>Nombre</label>
                                    <input type="text" wire:model.defer="destinatario" class="form-control"
                                        style="text-transform: uppercase;" placeholder="Escriba el nombre...">
                                    @error('destinatario')
                                        <small class="text-danger">{{ $message }}</small>
                                    @enderror
                                </div>
                            @endhasrole

                            <div class="form-group">
                                <label>Direccion</label>
                                <input type="text" wire:model.defer="direccion_paquete" class="form-control"
                                    style="text-transform: uppercase;" placeholder="Escriba la direccion...">
                                @error('direccion_paquete')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="telefono">Teléfono</label>
                                <input type="text" id="telefono" wire:model.defer="telefono" class="form-control">
                                @error('telefono')
                                    <span class="text-danger">{{ $message }}</span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label>Correo</label>
                                <input type="text" wire:model.defer="correo_destinatario" class="form-control"
                                    style="text-transform: uppercase;" placeholder="">
                                @error('correo_destinatario')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>

                        <!-- Columna derecha -->
                        <div class="col-md-6">

                            @hasrole('Administrador')
                                <div class="form-group">
                                    <label>Peso (kg)</label>
                                    <input type="number" wire:model.defer="peso" step="0.01" class="form-control">
                                </div>
                                @error('peso')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            @endhasrole

                            <div class="form-group">
                                <label>Casilla</label>
                                <input type="text" wire:model.defer="casilla" class="form-control"
                                    style="text-transform: uppercase;" placeholder="">
                                @error('casilla')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>

                            @hasrole('Administrador')
                                <div class="form-group">
                                    <label>Aduana</label>
                                    <select wire:model.defer="aduana" class="form-control"
                                        style="text-transform: uppercase;">
                                        <option value="">SELECCIONE...</option>
                                        <option value="SI">SI</option>
                                        <option value="NO">NO</option>
                                    </select>
                                </div>
                            @endhasrole

                            <div class="form-group">
                                <label>Observación</label>
                                <textarea wire:model.defer="observacion" class="form-control" rows="4" style="text-transform: uppercase;"></textarea>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="guardar" class="btn btn-primary">
                        {{ $paquete_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button type="button" class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
