@extends('adminlte::page')

@section('title', 'Objetos')

@section('content_header')
    <h1>Gestión de Objetos</h1>
@stop

@section('content')

@if(session('success'))
    <div class="alert alert-success">{{ session('success') }}</div>
@endif

<!-- Botón para abrir modal de nuevo objeto -->
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#modalNuevoObjeto">Añadir Objeto</button>

<!-- Formulario de búsqueda -->
<form method="GET" action="{{ route('objetos.index') }}" class="mb-4">
    <div class="input-group">
        <input type="text" name="buscar" class="form-control" placeholder="Buscar por código o nombre" value="{{ request('buscar') }}">
        <div class="input-group-append">
            <button class="btn btn-outline-secondary" type="submit">Buscar</button>
            <a href="{{ route('objetos.index') }}" class="btn btn-outline-danger">Limpiar</a>
        </div>
    </div>
</form>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Cantidad</th>
            <th>Área</th>
            <th>Ubicación</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($objetos as $objeto)
        <tr>
            <td>{{ $objeto->codigo_activo }}</td>
            <td>{{ $objeto->nombre }}</td>
            <td>{{ $objeto->cantidad }}</td>
            <td>{{ $objeto->area }}</td>
            <td>{{ $objeto->ubicacion_fisica }}</td>
            <td>
                <!-- Botón para modal de editar cantidad -->
                <button class="btn btn-warning btn-sm" data-toggle="modal" data-target="#modalEditarCantidad{{ $objeto->id_activo }}">
                    Editar Cantidad
                </button>
            </td>
        </tr>

        <!-- Modal editar cantidad -->
        <div class="modal fade" id="modalEditarCantidad{{ $objeto->id_activo }}" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <form action="{{ route('objetos.update', $objeto->id_activo) }}" method="POST">
              @csrf
              @method('PUT')
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title">Editar Cantidad</h5>
                  <button type="button" class="close" data-dismiss="modal">&times;</button>
                </div>
                <div class="modal-body">
                  <div class="form-group">
                    <label for="cantidad">Nueva Cantidad</label>
                    <input type="number" name="cantidad" class="form-control" value="{{ $objeto->cantidad }}" min="1" required>
                  </div>
                </div>
                <div class="modal-footer">
                  <button type="submit" class="btn btn-success">Guardar</button>
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                </div>
              </div>
            </form>
          </div>
        </div>

        @endforeach
    </tbody>
</table>

<!-- Modal nuevo objeto -->
<div class="modal fade" id="modalNuevoObjeto" tabindex="-1" role="dialog" aria-labelledby="modalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <form action="{{ route('objetos.store') }}" method="POST">
      @csrf
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Registrar Nuevo Objeto</h5>
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <div class="form-group">
            <label>Código</label>
            <input type="text" name="codigo_activo" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Cantidad</label>
            <input type="number" name="cantidad" class="form-control" required min="1">
          </div>
          <div class="form-group">
            <label>Área</label>
            <input type="text" name="area" class="form-control" required>
          </div>
          <div class="form-group">
            <label>Ubicación Física</label>
            <input type="text" name="ubicacion_fisica" class="form-control">
          </div>
          <div class="form-group">
            <label>Empleado Asignado</label>
            <input type="text" name="empleado_asignado" class="form-control">
          </div>
          <div class="form-group">
            <label>Estado</label>
            <input type="text" name="estado" class="form-control">
          </div>
          <div class="form-group">
            <label>Observaciones</label>
            <textarea name="observaciones" class="form-control"></textarea>
          </div>
        </div>
        <div class="modal-footer">
          <button type="submit" class="btn btn-primary">Guardar</button>
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        </div>
      </div>
    </form>
  </div>
</div>

@stop
