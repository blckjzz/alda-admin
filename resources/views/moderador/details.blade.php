@extends('voyager.master')

@section('page_title', 'Resultados em Análise')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Detalhes - {{$resultado->agenda->list_agenda}}
    </h1>

@stop
@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ action('ModeracaoController@storeResultado') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            {{ csrf_field() }}
            <div class="row">
                <div class="col-md-8">
                    <div class="panel panel-bordered">
                        {{-- <div class="panel"> --}}
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                    </div>
                    <input type="text" class="hidden" name="agenda_id" value="{{$resultado->agenda->id}}">
                    <div class="panel-body">
                        <div class="form-group">
                            <label for="name">Resumo da reunião</label>
                            <textarea class="form-control" name="texto" rows="10">{{$resultado->texto}}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="">Status</label>
                            <select class="form-control" id="revision" name="revisionstatus_id">
                                <option selected="true" disabled="disabled">Selecione o status</option>
                                @foreach($revision_status as $r)
                                    <option value="{{$r->id}}" {{($r->id == $resultado->revisionstatus_id? 'selected="selected"' : "")}}>
                                        {{$r->status}}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <button type="submit" class="btn-block btn-success"> Salvar</button>
                        </div>
                    </div>
                </div>

            </div>


    </div>
    </form>
    </div>
@endsection

@section('javascript')
    <script src="{{asset('js/jquery-ui.js')}}"></script>
    <script src="{{asset('js/tag-it.js')}}" type="text/javascript" charset="utf-8"></script>
@endsection
