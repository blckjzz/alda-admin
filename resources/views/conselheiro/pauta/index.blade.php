@extends('voyager.master')

@section('page_title', 'Adicionar Pauta')

@section('css')
    {{--<link href="{{asset('css/jquery.tagit.css')}}" rel="stylesheet" type="text/css">--}}
@endsection
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
              action="{{ action('ConselheiroController@storePauta') }}"
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
                                <select class="form-control" id="agenda" name="agenda_id">
                                    <option selected="true" disabled="disabled">Selecione uma reunião</option>
                                    @foreach($agendas->where('status_id', 5) as $agenda)
                                        <option value="{{$agenda->id}}"> {{$agenda->list_agenda}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="resumo">Resumo da reunião</label>
                                <textarea class="form-control" name="texto"></textarea>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[]" id="assunto0">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto0'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[]" id="assunto1">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto1'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[]" id="assunto2">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto2'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Data</label>
                                <input type="text" name="date" value="{{ Carbon\Carbon::now()->format('d/m/Y')  }}"
                                       class="form-control">
                            </div>

                            <div class="form-group-lg">
                                {{--<button type="" class="btn-block btn-danger"> Cancelar</button>--}}
                                {{--<a href="">--}}
                                {{--<button type="submit" class="btn btn-success"> Editar</button>--}}
                                {{--</a>--}}
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

    <script>

        $("#agenda").click(function () {
            var id = $("select option:selected").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route,
                dataType: 'json',
                url: '/admin/agenda/' + id + '/resultado/', // This is the url we gave in the route
                success: function (response) { // What to do if we succeed
                    $("textarea[name='texto']").val(response.texto);
                    //console.log(response) debugg only

                    $.ajax({
                        method: 'GET', // Type of response and matches what we said in the route
                        dataType: 'json',
                        url: '/admin/resultado/' + response.id + '/assuntos/', // This is the url we gave in the route
                        success: function (assunto) { // What to do if we succeed
                            //console.log(assunto) debugg only
                            $.each(assunto, function (key, value) {
                                $('#assunto' + key + ' option[value=' + value.id + ']').attr('selected', 'selected');
                            });
                        }
                    });
                },

                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });

    </script>





@endsection
