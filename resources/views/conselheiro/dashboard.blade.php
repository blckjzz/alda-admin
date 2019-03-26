@extends('layout.master')
@section('page_title', 'Adicionar Pauta')

@section('css')
    {{--<link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">--}}
@endsection
@section('page_header')
    <h1 class="">
        Seja bem-vindo ao Painel de Controle do Conselheiro!
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>

