<div class="container-fluid">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Paquetes Resagados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Resago</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">
            <div class="card-header row align-items-center">
                <div class="col-md-6 d-flex">
                    <button class="btn btn-success ml-2" wire:click="abrirModal">
                        <i class="fas fa-plus-circle"></i> Crear Paquete Resagado
                    </button>
                </div>
                <div class="col-md-6 d-flex justify-content-end">
                    <div class="input-group" style="max-width: 400px;">
                        <input type="text" class="form-control" placeholder="Buscar Código, Ciudad u Observación..."
                            wire:model="search" wire:keydown.enter="$refresh">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-flat" wire:click="$refresh">
                                <i class="fas fa-search"></i>
                            </button>
                            <button class="btn btn-secondary btn-flat" wire:click="$set('search', '')"
                                title="Limpiar búsqueda">
                                <i class="fas fa-times"></i>
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
                                <input type="checkbox" wire:model="selectPage">
                            </th>
                            <th>Código</th>
                            <th>Nombre</th>
                            <th>Peso</th>
                            <th>Estado</th>
                            <th>Ciudad</th>
                            <th>Aduana</th>
                            <th>Observación</th>
                            <th>Fecha Recepción</th>
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
                                <td>{{ $p->estado }}</td>
                                <td>{{ $p->cuidad }}</td>
                                <td>{{ $p->aduana }}</td>
                                <td>{{ $p->observacion }}</td>
                                <td>{{ $p->created_at->format('d/m/Y H:i') }}</td>
                                <td class="d-flex">
                                    <button class="btn btn-sm btn-warning mr-1" wire:click="editar({{ $p->id }})">
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
                                <td colspan="10" class="text-center">No hay paquetes resagados.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <div class="card-footer d-flex justify-content-between align-items-center">
                <button class="btn btn-primary" wire:click="enviarSeleccionadosAAlmacen"
                    onclick="return confirm('¿Enviar paquetes seleccionados a ALMACÉN?')"
                    @if(count($selected) == 0) disabled @endif>
                    <i class="fas fa-arrow-right"></i> Enviar a ALMACÉN
                </button>
                <div>
                    {{ $paquetes->links() }}
                </div>
            </div>
        </div>
    </section>

    <!-- Modal Crear/Editar -->
    <div class="modal fade @if ($modal) show d-block @endif" tabindex="-1"
        style="background: rgba(0,0,0,0.5);" role="dialog" aria-modal="true">
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
                                <input type="text" wire:model.defer="codigo" class="form-control" style="text-transform: uppercase;">
                                @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Nombre</label>
                                <input type="text" wire:model.defer="destinatario" class="form-control" style="text-transform: uppercase;" placeholder="Escriba el nombre...">
                                @error('destinatario') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Ciudad</label>
                                <input type="text" wire:model.defer="cuidad" class="form-control" style="text-transform: uppercase;" readonly>
                                @error('cuidad') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Dirección</label>
                                <input type="text" wire:model.defer="direccion_paquete" class="form-control" style="text-transform: uppercase;" placeholder="Escriba la dirección...">
                                @error('direccion_paquete') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Teléfono</label>
                                <input type="text" wire:model.defer="telefono" class="form-control">
                                @error('telefono') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Correo</label>
                                <input type="email" wire:model.defer="correo_destinatario" class="form-control" style="text-transform: uppercase;">
                                @error('correo_destinatario') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                        </div>
                        <!-- Columna derecha -->
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Peso (kg)</label>
                                <input type="number" wire:model.defer="peso" step="0.01" class="form-control">
                                @error('peso') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Casilla</label>
                                <input type="text" wire:model.defer="casilla" class="form-control" style="text-transform: uppercase;">
                                @error('casilla') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Aduana</label>
                                <select wire:model.defer="aduana" class="form-control" style="text-transform: uppercase;">
                                    <option value="">SELECCIONE...</option>
                                    <option value="SI">SI</option>
                                    <option value="NO">NO</option>
                                </select>
                                @error('aduana') <small class="text-danger">{{ $message }}</small> @enderror
                            </div>
                            <div class="form-group">
                                <label>Observación</label>
                                <textarea wire:model.defer="observacion" class="form-control" rows="4" style="text-transform: uppercase;"></textarea>
                                @error('observacion') <small class="text-danger">{{ $message }}</small> @enderror
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
