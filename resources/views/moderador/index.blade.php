@extends('voyager::master')

@section('page_title', 'Resultados - Moderação')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Resultados
    </h1>

@stop
@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                @if (count($errors) > 0)
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="panel-body">
                    <div class="form-group col-md-12">
                        <div class="page-content container-fluid">
                            @if($resultados->where('revisionstatus_id', 1)->count() > 0)
                                <h1>Em análise</h1>
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
                                    @foreach($resultados->where('revisionstatus_id', 1) as $resultado)
                                        <tr>

                                            <th scope="row">{{$resultado->agenda->conselho->ccs}}</th>

                                            <th scope="row">{{str_limit($resultado->texto, 10)}}</th>

                                            <th scope="row"> {{ $resultado->revisionStatus->status }}</th>

                                            <th scope="row">{{$resultado->agenda->list_agenda }}</th>

                                            <th scope="row">
                                                <a href="{{ action('ModeracaoController@showPauta', $resultado->id) }}"
                                                   class="">Ver</a>
                                            </th>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            @else
                                <h1>Não há nenhum Resultado em Análise</h1>
                            @endif

                        </div>
                        @if($resultados->where('revisionstatus_id', 2)->count() > 0)
                            <h1>Aprovados</h1>
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
                                @foreach($resultados->where('revisionstatus_id', 2) as $resultado)
                                    <tr>
                                        <th scope="row">{{$resultado->agenda->conselho->ccs}}</th>
                                        <th scope="row">{{str_limit($resultado->texto, 10)}}</th>

                                        <th scope="row"> {{ $resultado->revisionStatus->status }}</th>

                                        <th scope="row">{{$resultado->agenda->list_agenda }}</th>

                                        <th scope="row">
                                            <a href="{{ action('ModeracaoController@showPauta', $resultado->id) }}"
                                               class="">Ver</a>
                                        </th>

                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        @else
                            <h1>Não há nenhum resultado Aprovado</h1>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection




