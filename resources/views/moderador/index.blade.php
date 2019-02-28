@extends('voyager.master')

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
                            <a href="{{ action('ModeracaoController@showPauta', $resultado->id) }}" class="">Ver</a>
                        </th>

                    </tr>
                @endforeach
                </tbody>
            </table>
            @else
                <h1>Não há nenhum Resultado em Análise</h1>
            @endif

        </div>
        <div class="page-content container-fluid">
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
                                <a href="{{ action('ModeracaoController@showPauta', $resultado->id) }}" class="">Ver</a>
                            </th>

                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @else
                <h1>Não há nenhum resultado Aprovado</h1>
        </div>
    @endif
@endsection
