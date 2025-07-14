@extends('adminlte::page')
@section('title', 'Inventario')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('inventario')
    @include('footer')
@endsection
