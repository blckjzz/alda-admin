@extends('layout.master')

@section('page_title', 'Adicionar Pauta')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Edição Conselho
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
                                <label for="name">{{$conselho->ccs}}</label>
{{--                                {{dd($conselho->diretoria)}}--}}
                                <select class="form-control" id="dir" name="id">
                                    <option default> Selecione uma opção</option>
                                    @foreach($conselho->diretoria as $dir)
                                        <option value="{{$dir->id}}"> {{$dir->cargo}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" name="nome"/>
                                <label for="">Início da Gestão</label>
                                <input type="text" class="form-control" name="inicio_gestao"/>
                                <label for="">Fim da Gestão</label>
                                <input type="text" class="form-control" name="fim_gestao">
                            </div>

                            <div class="form-group">
                                <button class="btn btn-danger">Cancelar</button>
                                <button type="submit" class="btn btn-success">Salvar</button>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('javascript')
    <script>
        $("#dir").on('change',function () {
            var id = $("select option:selected").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: '/painel/dir/' + id, // This is the url we gave in the route
                success: function (response) { // What to do if we succeed
                    $("input[name='nome']").val(response.nome);
                    $("input[name='inicio_gestao']").val(response.inicio_gestao);
                    $("input[name='fim_gestao']").val(response.fim_gestao);
                },
                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    </script>
@endsection
