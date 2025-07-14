<div class="container-fluid">
    <section class="content-header">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Eventos Registrados</h1>
            </div>
            <div class="col-sm-6">
                <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Inicio</a></li>
                    <li class="breadcrumb-item active">Eventos</li>
                </ol>
            </div>
        </div>
    </section>

    <section class="content">
        <div class="card">

            <!-- Header con botón y buscador -->
            <div class="card-header">
                <div class="row w-100">
                    <div class="col-md-6 d-flex align-items-center">
                        {{-- <button class="btn btn-success" wire:click="abrirModal">
                            <i class="fas fa-plus-circle"></i> Crear Evento
                        </button> --}}
                    </div>
                    <div class="col-md-6 d-flex justify-content-end">
                        <div class="input-group" style="max-width: 300px;">
                            <input type="text" class="form-control" placeholder="Buscar..." wire:model.defer="searchInput">
                            <div class="input-group-append">
                                <button class="btn btn-primary btn-flat" wire:click="buscar">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Mensaje flash -->
            <div class="card-body p-0">
                @if (session()->has('message'))
                    <div class="alert alert-success m-3">{{ session('message') }}</div>
                @endif

                <!-- Tabla -->
                <table class="table table-striped table-hover mb-0">
                    <thead>
                        <tr>
                            <th>Acción</th>
                            <th>Usuario</th>
                            <th>Código</th>
                            <th>Descripción</th>
                            <th>Creado</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($eventos as $e)
                            <tr>
                                <td>{{ $e->accion }}</td>
                                <td>{{ $e->user_id }}</td>
                                <td>{{ $e->codigo }}</td>
                                <td>{{ Str::limit($e->descripcion, 50) }}</td>
                                <td>{{ $e->created_at }}</td>
                                <td>
                                    <button class="btn btn-sm btn-warning" wire:click="editar({{ $e->id }})">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <button class="btn btn-sm btn-danger" wire:click="eliminar({{ $e->id }})"
                                            onclick="return confirm('¿Eliminar este evento?')">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="text-center">No hay eventos.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            <!-- Paginación -->
            <div class="card-footer clearfix">
                {{ $eventos->links() }}
            </div>
        </div>
    </section>

    <!-- Modal Crear/Editar -->
    <div class="modal fade @if($modal) show d-block @endif" style="background: rgba(0,0,0,0.5);">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $evento_id ? 'Editar Evento' : 'Crear Evento' }}</h5>
                    <button type="button" class="close" wire:click="cerrarModal"><span>&times;</span></button>
                </div>
                <div class="modal-body">
                    <!-- Acción -->
                    <div class="form-group">
                        <label>Acción</label>
                        <input type="text" wire:model.defer="accion" class="form-control">
                        @error('accion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Usuario -->
                    <div class="form-group">
                        <label>Usuario</label>
                        <input type="text" wire:model.defer="user_id" class="form-control">
                        @error('user_id') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Código -->
                    <div class="form-group">
                        <label>Código</label>
                        <input type="text" wire:model.defer="codigo" class="form-control">
                        @error('codigo') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                    <!-- Descripción -->
                    <div class="form-group">
                        <label>Descripción</label>
                        <textarea wire:model.defer="descripcion" class="form-control" rows="3"></textarea>
                        @error('descripcion') <small class="text-danger">{{ $message }}</small> @enderror
                    </div>
                </div>
                <div class="modal-footer">
                    <button wire:click="guardar" class="btn btn-primary">
                        {{ $evento_id ? 'Actualizar' : 'Guardar' }}
                    </button>
                    <button class="btn btn-secondary" wire:click="cerrarModal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>
</div>
