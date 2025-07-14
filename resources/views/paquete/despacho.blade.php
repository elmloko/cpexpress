@extends('adminlte::page')
@section('title', 'Despachos')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('despacho')
    @include('footer')
@endsection
