@extends('adminlte::page')
@section('title', 'Almacen')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('almacen')
    @include('footer')
@endsection
