@extends('voyager::master')

@section('page_title', 'Adicionar Pauta')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Cadastro de Pauta de Reunião
    </h1>
@stop

@section('content')
    <div class="page-content container-fluid">
    @include('voyager::alerts')
    </div>

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ action('ConselheiroController@storeDiretoria') }}"
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

                        <div class="panel-body">
                            <div class="form-group">
                                <label for="name">Reunião</label>
                                @foreach($agendas->where('status_id', 5) as $agenda)
                                <select class="form-control" name="agenda">
                                    <option value="{{$agenda->id}}"> {{$agenda->list_agenda}} </option>
                                </select>
                                @endforeach
                            </div>
                            <div class="form-group">
                                <label for="resumo">Resumo</label>
                                <textarea class="form-control" name="resumo"></textarea>
                            </div>

                            <div class="form-group">
                                <label for="resumo">Assuntos</label>
                                <input type="text" class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="resumo">Data</label>
                                <input type="text" value="{{ Carbon\Carbon::now()->format('d/m/Y')  }}" class="form-control">
                            </div>

                            <div class="form-group">

                                <button type="" class="btn btn-danger"> Cancelar</button>
                                <button type="submit" class="btn btn-success"> Salvar </button>

                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
@endsection

