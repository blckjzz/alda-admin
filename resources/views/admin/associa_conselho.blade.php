@extends('voyager::master')

@section('page_title', 'Cadastrar Conselheiro CCS')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-people"></i> Cadastrar Conselheiro CCS
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
                            <form action="{{action("ModeracaoController@salvarConselheiroConselho")}}" method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <label for="">Selecione um Conselho</label>
                                    <select class="form-control" name="conselho" id="">
                                        <option selected="true" disabled="disabled">Selecione um CCS</option>
                                        @foreach($conselhos as $conselho)
                                            <option value="{{$conselho->id}}">{{$conselho->ccs}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <label for="">Selecione um Conselheiro</label>
                                    <select class="form-control" name="conselheiro" id="">
                                        <option selected="true" disabled="disabled">Selecione um Conselheiro</option>
                                        @foreach($conselheiros as $conselheiro)
                                            <option
                                                value="{{$conselheiro->id}}">{{$conselheiro->name .' - '.  $conselheiro->email}}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input type="submit" value="Salvar" class="btn btn-success">
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection




