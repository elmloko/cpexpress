@extends('adminlte::page')
@section('title', 'Paquetes')

@section('content_header')
<h1>Gestión de Paquetes</h1>
@stop

@section('content')
<button class="btn btn-primary mb-3" data-toggle="modal" data-target="#crearPaquete">Crear Paquete</button>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>ID</th><th>Codigo</th><th>Destinatario</th><th>Destino</th><th>Peso</th><th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($paquetes as $paquete)
            <tr>
                <td>{{ $paquete->id }}</td>
                <td>{{ $paquete->codigo }}</td>
                <td>{{ $paquete->destinatario }}</td>
                <td>{{ $paquete->destino }}</td>
                <td>{{ $paquete->peso }} kg</td>
                <td>
                    <button class="btn btn-sm btn-warning" data-toggle="modal" data-target="#editarPaquete{{ $paquete->id }}">Editar</button>
                </td>
            </tr>

            @include('paquetes.modal_edit', ['paquete' => $paquete])
        @endforeach
    </tbody>
</table>

{{ $paquetes->links() }}
@include('paquetes.modal_create')
@stop