@extends('voyager::master')

@section('page_title', 'Resultados em Análise')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Resultados em Análise
    </h1>

@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>

    <div class="page-content container-fluid">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">CCS</th>
                <th scope="col">Texto</th>
                <th scope="col">Status</th>
                <th scope="col">Agenda</th>
                <th scope="col">AÇÕES</th>
            </tr>
            </thead>
            <tbody>
            @foreach($resultados as $resultado)
                <tr>

                    <th scope="row">{{$resultado->agenda->conselho->ccs}}</th>
                    <th scope="row">{{str_limit($resultado->texto, 10)}}</th>

                    <th scope="row"> {{ $resultado->revisionStatus->status }}</th>

                    <th scope="row">{{$resultado->agenda->list_agenda }}</th>

                    <th scope="row">
                        <a href="{{ action('ModeracaoController@showPauta', $resultado->id) }}" class="">Ver</a>
                    </th>

                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection
