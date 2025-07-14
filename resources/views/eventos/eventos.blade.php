@extends('adminlte::page')
@section('title', 'Eventos')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('eventos')
    @include('footer')
@endsection
