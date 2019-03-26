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
        @if(Auth::user()->hasRole('conselheiro'))
            {{ menu('Conselheiro','voyager.menu.side-menu') }}
        @endif
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
                                <select class="form-control" id="dir" name="id">
                                    <option default> Selecione uma opção</option>
                                    @foreach($conselho->diretoria as $diretoria)
                                        <option value="{{$diretoria->id}}"> {{$diretoria->nome .' - '. $diretoria->cargo}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Nome</label>
                                <input type="text" class="form-control" name="nome"/>
                                <label for="">Cargo</label>
                                <input type="text" class="form-control" name="cargo">
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
        $("#dir").click(function () {
            var id = $("select option:selected").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route
                url: '/admin/diretoria/' + id, // This is the url we gave in the route
                success: function (response) { // What to do if we succeed
                    //console.log(response)
                    $("input[name='nome']").val(response.nome);
                    $("input[name='cargo']").val(response.cargo);
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