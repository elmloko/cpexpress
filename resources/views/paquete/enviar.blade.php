@extends('adminlte::page')
@section('title', 'Enviar')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('enviar')
    @include('footer')
@endsection
