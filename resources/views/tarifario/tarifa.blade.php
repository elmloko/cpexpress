@extends('adminlte::page')
@section('title', 'Tarifario')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
@livewire('tarifas')
@include('footer')
@endsection
