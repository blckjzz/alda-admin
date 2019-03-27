@extends('layout.master')

@section('page_title', 'Adicionar Ata Eletrônica')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Cadastro de Ata Eletrônica de reunião
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
                <div class="col-md-10">
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
                            <div class="form-text">
                                <div class="text-right">
                                    <span style="color:red">*</span> são campos obrigatórios para envio da ata eletrônica.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Reunião</label> <span style="color:red">*</span>
                                <select class="form-control" id="agenda" name="agenda_id">
                                    <option selected="true" disabled="disabled">Selecione uma reunião</option>
                                    @foreach($agendas as $agenda)
                                        <option value="{{ $agenda->id }}" {{ (collect(old('agenda_id'))->contains($agenda->id)) ? 'selected':'' }} > {{$agenda->list_agenda}} </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Data</label> <span style="color:red">*</span>
                                <input type="text" name="data" value="{{ Carbon\Carbon::now()->format('d/m/Y')  }}"
                                       class="form-control">
                            </div>

                            <div class="form-group">
                                <label for="resumo">Resumo da reunião</label> <span style="color:red">*</span>
                                <textarea class="form-control" name="texto">{{old('texto')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label> Assuntos </label> <span style="color:red">*</span>
                                <select class="form-control" name="assunto[0]" id="assunto0">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto.0'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[1]" id="assunto1">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto.1'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[2]" id="assunto2">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option value="{{ $assunto->id }}" {{ (collect(old('assunto.2'))->contains($assunto->id)) ? 'selected':'' }}>{{ $assunto->assunto }}</option>                                    @endforeach
                                </select>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-10">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <div class="form-group">
                                <label for="">Haviam quantos presentes na reunião?</label> <span style="color:red">*</span>
                                <input type="number" class="form-control" name="present_members">
                            </div>
                            <div class="form-group">
                                <label for="">Quais membros da Diretoria estavam presentes?</label>
                                @foreach($agenda->conselho->diretoria->sort() as $diretor)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="{{$diretor->id}}"
                                               value="{{$diretor->id}}" name="diretoria[]">
                                        <label class="form-check-label" for="{{$diretor->id}}">{{$diretor->nome}}
                                            - {{$diretor->cargo}}</label>
                                    </div>
                                @endforeach
                            </div>

                            <div class="form-group">
                                <label for="">Membros Natos Presentes: </label> <span style="color:red">*</span>
                                @foreach( $membrosnatos->sort() as $membroNato)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="{{$membroNato->id}}"
                                               value="{{$membroNato->id}}" name="membronato[]">
                                        <label class="form-check-label"
                                               for="{{$membroNato->id}}">{{$membroNato->cmd_bpm . ' - ' .$membroNato->delegado}}</label>
                                    </div>
                                @endforeach
                            </div>


                            <div class="form-group">
                                <button class="btn btn-danger">Cancelar</button>
                                {{--<a href="">--}}
                                {{--<button type="submit" class="btn btn-dark"> Editar</button>--}}
                                {{--</a>--}}
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

        $("#agenda").click(function () {
            var id = $("select option:selected").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route,
                dataType: 'json',
                url: '/painel/agenda/' + id + '/resultado', // This is the url we gave in the route
                success: function (response) { // What to do if we succeed
                    $("textarea[name='texto']").val(response.texto);

                    if (response.id != null) {
                        $("#target :input").prop("disabled", true);
                        $.ajax({
                            method: 'GET', // Type of response and matches what we said in the route
                            dataType: 'json',
                            url: '/painel/resultado/' + response.id + '/assuntos/', // This is the url we gave in the route
                            success: function (assunto) { // What to do if we succeed
                                //console.log(assunto) debugg only
                                $.each(assunto, function (key, value) {
                                    $('#assunto' + key + ' option[value=' + value.id + ']').attr('selected', 'selected');
                                });
                            }
                        });
                    }

                },

                error: function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                    console.log(JSON.stringify(jqXHR));
                    console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                }
            });
        });

    </script>


    {{--<script>--}}
    {{--$("input:checkbox[name=type]:checked").each(function(){--}}
    {{--diretorias.push($(this).val());--}}
    {{--});--}}
    {{--</script>--}}



@endsection
