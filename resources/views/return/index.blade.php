@extends('adminlte::page')

@section('title', 'Return')

@section('content_header')
    <h1>Return</h1>
@stop

@section('content')
    @livewire('return-package') {{-- Aquí monta el componente Livewire --}}
@stop
