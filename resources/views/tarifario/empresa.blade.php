@extends('adminlte::page')
@section('title', 'Empresas')
@section('template_title')
    Paqueteria Postal
@endsection

@section('content')
@livewire('empresas')
@include('footer')
@endsection
