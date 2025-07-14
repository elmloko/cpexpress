@extends('adminlte::page')
@section('title', 'Todos')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
    @livewire('todos')
    @include('footer')
@endsection
