@extends('layout.master')

@section('page_title', 'Minhas Reuniões')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Minhas Reuniões
    </h1>

@stop

@section('content')

    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>

    <div class="page-content container-fluid">
        <form class="form-edit-add" role="form"
              action="{{ action('ConselheiroController@storeReuniao') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            <!-- PUT Method if we are editing -->
            {{ csrf_field() }}
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
                                <label for="">Reunião</label>
                                <select class="form-control" name="agenda" id="agenda">
                                    <option selected="true" disabled="disabled">Selecione uma reunião</option>
                                    @foreach($agendas->sortByDesc('id') as $a)
                                        <option value="{{$a->id}}">{{$a->listaAgendasConselheiro}}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group col-md-12">
                                <label for="">Data</label>
                                <input type="text" class="form-control" name="data" placeholder="Data"
                                       value="00/00/0000">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="">Hora</label>
                                <input type="time" data-name="Hora" class="form-control" name="hora" placeholder="Hora"
                                       value="">
                            </div>
                            <div class="form-group col-md-12">
                                <label for="name">Endereço</label>
                                <textarea class="form-control" name="endereco" rows="5"></textarea>
                            </div>

                            <div class="form-group  col-md-12">
                                <label for="name">Bairro</label>
                                <input type="text" class="form-control" name="bairro" placeholder="Bairro" value="">
                            </div>

                            <div class="form-group  col-md-12">
                                <label for="name">Ponto Referencia</label>
                                <textarea class="form-control" name="ponto_referencia" rows="5"
                                          placeholder="Próximo a delegacia de polícia..."></textarea>
                            </div>
                            <div class="form-group">
                                <button class="btn btn-danger">Cancelar</button>
                                <button type="submit" class="btn btn-success"> Salvar</button>
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

    <script>
        $("#agenda").on('change', function () {
            var id = $("select option:selected").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route,
                dataType: 'json',
                url: '/painel/agenda/ver/' + id , // This is the url we gave in the route
                success: function (agenda) { // What to do if we succeed
                    console.log(agenda);
                    $("input[name='hora']").val(agenda.hora);
                    $("textarea[name='endereco']").val(agenda.endereco);
                    if ($("input[name='data']").val()) {
                        $(this).val(new Date());
                    }

                    $("input[name='data']").val(agenda.data);
                    $("input[name='bairro']").val(agenda.bairro);
                    $("textarea[name='ponto_referencia']").val(agenda.ponto_referencia);
                },

                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });


    </script>
@endsection
