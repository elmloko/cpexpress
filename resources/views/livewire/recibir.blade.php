<!-- resources/views/livewire/recibir.blade.php -->
<div class="container-fluid">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Paquetes Recibidos</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Recibir</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header row align-items-center">
                <div class="col-md-6 d-flex">
                    <!-- Botón para crear nuevo paquete -->
                    <button class="btn btn-success ml-2" wire:click="abrirModal">
                        <i class="fas fa-plus-circle"></i> Crear Paquete
                    </button>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" class="form-control" placeholder="Buscar Codigos..."
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
                            <th>Empresa</th>
                            <th>Peso</th>
                            <th>Tarifa</th>
                            <th>Estado</th>
                            <th>Ciudad</th>
                            <th>Observación</th>
                            <th>Fecha recepcion</th>
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
                                <td>{{ $p->destinatario }}</td>
                                <td>{{ $p->peso }} kg</td>
                                <td>{{ strtoupper($p->destino) }}</td>
                                <td>{{ $p->estado }}</td>
                                <td>{{ $p->cuidad }}</td>
                                <td>{{ $p->created_at }}</td>
                                <td>{{ $p->observacion }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-sm btn-warning mr-1"
                                        wire:click="editar({{ $p->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    @hasrole('Administrador')
                                        <button class="btn btn-sm btn-danger"
                                            wire:click="eliminarPaquete({{ $p->id }})"
                                            onclick="return confirm('¿Eliminar este paquete de forma permanente?')">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endhasrole
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="8" class="text-center">No hay resultados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <button class="btn btn-primary" wire:click="recibirSeleccionados"
                onclick="return confirm('¿Estás seguro de recibir los paquetes seleccionados?')">
                <i class="fas fa-inbox"></i> Recibir paquetes
            </button>
            <div class="card-footer clearfix">
                {{ $paquetes->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Crear/Editar -->
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
                            <div class="form-group">
                                <label>Código</label>
                                <input type="text" wire:model.defer="codigo" class="form-control"
                                    style="text-transform: uppercase;">
                                @error('codigo')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Empresa</label>
                                <select wire:model.defer="destinatario" class="form-control"
                                    style="text-transform: uppercase;">
                                    <option value="">SELECCIONE...</option>
                                    @foreach ($empresas as $empresa)
                                        <option value="{{ strtoupper($empresa->nombre) }}">
                                            {{ strtoupper($empresa->nombre) }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('destinatario')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label>Departamento</label>
                                <select wire:model.defer="cuidad" class="form-control"
                                    style="text-transform: uppercase;">
                                    <option value="">SELECCIONE...</option>
                                    <option value="BENI">BENI</option>
                                    <option value="CHUQUISACA">CHUQUISACA</option>
                                    <option value="COCHABAMBA">COCHABAMBA</option>
                                    <option value="LA PAZ">LA PAZ</option>
                                    <option value="ORURO">ORURO</option>
                                    <option value="PANDO">PANDO</option>
                                    <option value="POTOSI">POTOSI</option>
                                    <option value="SANTA CRUZ">SANTA CRUZ</option>
                                    <option value="TARIJA">TARIJA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label>Destino</label>
                                <select wire:model.defer="destino" class="form-control"
                                    style="text-transform: uppercase;">
                                    <option value="">SELECCIONE...</option>
                                    <option value="local">LOCAL</option>
                                    <option value="nacional">NACIONAL</option>
                                    <option value="camiri">CAMIRI</option>
                                    <option value="sud">SUD AMERICA</option>
                                    <option value="centro">CENTRO AMERICA Y CARIBE</option>
                                    <option value="norte">NORTE AMERICA</option>
                                    <option value="euro">EUROPA Y AFRICA</option>
                                    <option value="asia">ASIA Y OCEANIA</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="pda">PDA</label>
                                <input type="text" id="pda" wire:model.defer="pda" class="form-control"
                                    maxlength="100" placeholder="Ingrese PDA (opcional)">
                                @error('pda')
                                    <small class="text-danger">{{ $message }}</small>
                                @enderror
                            </div>
                        </div>
                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Peso (kg)</label>
                                <input type="number" wire:model.defer="peso" step="0.01" class="form-control">
                            </div>
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea wire:model.defer="observacion" class="form-control" rows="4" style="text-transform: uppercase;"></textarea>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="certificacion"
                                    wire:model.defer="certificacion">
                                <label class="form-check-label" for="certificacion">
                                    Taza de Certificación (8 Bs.)
                                </label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" id="almacenaje" wire:model.defer="almacenaje"
                                    class="form-check-input">
                                <label for="almacenaje" class="form-check-label">
                                    Aplicar tarifa de Almacenaje (15 Bs.)
                                </label>
                            </div>
                            <div class="form-group form-check">
                                <input type="checkbox" id="grupo" wire:model.defer="grupo"
                                    class="form-check-input">
                                <label for="grupo" class="form-check-label">
                                    Aplicar tarifa de Agrupacion
                                </label>
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
    <!-- Modal Asignar Destino -->
    <div class="modal fade @if ($modalDestino) show d-block @endif" tabindex="-1"
        style="background: rgba(0,0,0,0.5);" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Asignar Destino</h5>
                    <button type="button" class="close" wire:click="$set('modalDestino', false)">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Destino</label>
                        <select wire:model.defer="destino" class="form-control" style="text-transform: uppercase;">
                            <option value="">SELECCIONE...</option>
                            <option value="local">LOCAL</option>
                            <option value="nacional">NACIONAL</option>
                            <option value="camiri">CAMIRI</option>
                            <option value="sud">SUD AMÉRICA</option>
                            <option value="centro">CENTRO AMÉRICA Y CARIBE</option>
                            <option value="norte">NORTE AMÉRICA</option>
                            <option value="euro">EUROPA Y ÁFRICA</option>
                            <option value="asia">ASIA Y OCEANÍA</option>
                        </select>
                        @error('destino')
                            <small class="text-danger">{{ $message }}</small>
                        @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="asignarDestino" class="btn btn-primary">
                        Guardar Destino
                    </button>
                    <button type="button" class="btn btn-secondary" wire:click="$set('modalDestino', false)">
                        Cancelar
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
