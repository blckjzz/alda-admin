@extends('voyager::master')

@section('page_title', 'Resultados em Análise')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Detalhes - {{$resultado->agenda->list_agenda}}
    </h1>

@stop
@section('css')
    <link rel="stylesheet" href="{{asset("/admin/bower_components/bootstrap-fileinput/css/fileinput.css")}}">
    <link rel="stylesheet" href="{{asset("/admin/bower_components/bootstrap-fileinput/css/fileinput-rtl.css")}}">

@endsection
@section('content')

    <div class="page-content container-fluid">
        <form id="form" class="form-edit-add" role="form"
              action="{{ action('ModeracaoController@storeResultado') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
            {{ csrf_field() }}
            <input type="hidden" id="agenda" name="agenda_id" value="{{$resultado->agenda->id}}">
            <div class="row">
                <div class="col-md-10">
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
                            <div class="form-text">
                                <div class="text-right">
                                    <span style="color:red">*</span> são campos obrigatórios para envio da ata
                                    eletrônica.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="resumo">Resumo da reunião</label> <span class="text-right"
                                                                                    style="color:red"> (Este é um resumo público que aparecerá na Alda.)</span>
                                <div class="text-right">
                                    <div id="charNum0"></div>
                                </div>

                                <textarea class="form-control"
                                          name="texto" id="resumo" rows="10">{{ old('texto')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label for="pauta">Pauta completa da reunião</label> <span class="text-right"
                                                                                           style="color:red">
                            (Texto completo. Apenas ISP terá acesso.)</span>
                                <div class="text-right">
                                    <div id="charNum1"></div>
                                </div>
                                <textarea class="form-control"
                                          name="pauta_interna" id="pauta" rows="10">{{ old('pauta_interna')}}</textarea>
                            </div>

                            <div class="form-group">
                                <label> Assuntos </label> <span style="color:red">*</span>
                                <select class="form-control" name="assunto[0]" id="assunto0">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option
                                            value="{{ $assunto->id }}" {{ (collect(old('assunto.0'))->contains($assunto->id)) ? 'selected':'' }}>
                                            {{ $assunto->assunto }}
                                        </option>

                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[1]" id="assunto1">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option
                                            value="{{ $assunto->id }}" {{ (collect(old('assunto.1'))->contains($assunto->id)) ? 'selected':'' }}>
                                            {{ $assunto->assunto }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <select class="form-control" name="assunto[2]" id="assunto2">
                                    <option selected="true" disabled="disabled">Selecione um assunto</option>
                                    @foreach($assuntos as $assunto)
                                        <option
                                            value="{{ $assunto->id }}" {{ (collect(old('assunto.2'))->contains($assunto->id)) ? 'selected':'' }}>
                                            {{ $assunto->assunto }}
                                        </option>                                    @endforeach
                                </select>
                            </div>

                            <div class="form-group">
                                <label for="">Selecione status: * Apenas aprovados irão aparecer na Alda.</label>
                                <select class="form-control" id="revision" name="revisionstatus_id">
                                    <option selected="true" disabled="disabled">Selecione o status</option>
                                    @foreach($revision_status as $r)
                                        <option
                                            value="{{$r->id}}" {{($r->id == $resultado->revisionstatus_id? 'selected="selected"' : "")}}>
                                            {{$r->status}}
                                        </option>
                                    @endforeach
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
                                <label for="">Quantos participantes estavam presentes?</label> <span
                                    style="color:red">*</span>
                                <input type="number" class="form-control" name="present_members"
                                       value="{{ old('present_members') }}">
                            </div>
                            <div class="form-group" id="diretoria">
                                <label for="">Quais membros da Diretoria estavam presentes?</label>
                                @foreach($resultado->agenda->conselho->diretoria->sort() as $diretor)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="dir{{$diretor->id}}"
                                               value="{{$diretor->id}}" name="diretoria[]">
                                        <label class="form-check-label" for="dir{{$diretor->id}}">{{$diretor->nome}}
                                            - {{$diretor->cargo}}</label>
                                    </div>
                                @endforeach

                            </div>
                            <div class="form-group" id="membros-natos">
                                <label for="">Membros Natos presentes </label> <span style="color:red">*</span>
                                <div id="comandante">
                                    <label for="">Comandante(s): </label>
                                    <div class="form-check form-check-inline">
                                        @foreach($comandantes as $comandante)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                       id="com{{$comandante->id}}"
                                                       value="{{$comandante->id}}"
                                                       name="comandante_id[]">

                                                <label class="form-check-label"
                                                       for="com{{$comandante->id}}">{{$comandante->nome}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <div id="delegados">
                                        <label for="">Delegado(s): </label>
                                        <div class="form-check form-check-inline">
                                            @foreach($delegados as $delegado)
                                                <div class="form-check form-check-inline">
                                                    <input class="form-check-input" type="checkbox"
                                                           id="del{{$delegado->id}}"
                                                           value="{{$delegado->id}}"
                                                           name="delegado_id[]">

                                                    <label class="form-check-label"
                                                           for="del{{$delegado->id}}">{{$delegado->nome}}</label>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label for="">Arquivos Armazenados</label>
                                <div class="form-inline" id="uploaded-files">
                                </div>
                            </div>

                            <div class="form-group">
                                <button type="submit" id="btnSubmit" class="btn btn-success"> Salvar</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@endsection
@section('javascript')

    <script src="{{asset("/admin/bower_components/bootstrap-fileinput/js/fileinput.js")}}"></script>
    <script src="{{asset("/admin/bower_components/bootstrap-fileinput/js/plugins/piexif.js")}}"></script>
    <script src="{{asset("/admin/bower_components/bootstrap-fileinput/js/plugins/purify.js")}}"></script>
    <script src="{{asset("/admin/bower_components/bootstrap-fileinput/js/plugins/sortable.js")}}"></script>

    <script>


        $('#btnSubmit').on('click', function (e) {
            e.preventDefault();
            var answer = window.confirm("Deseja salvar alterações?")
            if (answer) {
                $('#form').submit();
            }
        });


        $(document).ready(function () {
            var id = $("#agenda").val();
            $.ajax({
                method: 'GET', // Type of response and matches what we said in the route,
                dataType: 'json',
                url: '/painel/agenda/' + id + '/resultado', // This is the url we gave in the route
                success: function (agenda) { // What to do if we succeed
                    // console.log(agenda);
                    $("textarea[name='texto']").val(agenda.texto);
                    $("textarea[name='pauta_interna']").val(agenda.pauta_interna);
                    $("input[name='present_members']").val(agenda.present_members);

                    $.ajax({
                        method: 'GET', // Type of response and matches what we said in the route
                        dataType: 'json',
                        url: '/painel/resultado/' + agenda.id + '/assuntos/', // This is the url we gave in the route
                        success: function (assunto) { // What to do if we succeed
                            // console.log(assunto); //debugg only
                            $.each(assunto, function (key, value) {
                                $('#assunto' + key + ' option[value=' + value.id + ']').attr('selected', 'selected');
                            });
                        }
                    });

                    $.ajax({
                        method: 'GET', // Type of response and matches what we said in the route
                        dataType: 'json',
                        url: '/painel/presenca/' + agenda.agenda_id, // This is the url we gave in the route
                        success: function (presenca) { // What to do if we succeed

                            $.each(presenca.diretoria, function (key, value) {
                                $('#dir' + value.id).prop('checked', true);
                            });

                            $.each(presenca.delegados, function (key, value) {
                                $('#del' + value.id).prop('checked', true);
                            });

                            $.each(presenca.comandantes, function (key, value) {
                                $('#com' + value.id).prop('checked', true);
                            });
                        }
                    });
                    $.ajax({
                        method: 'GET', // Type of response and matches what we said in the route
                        dataType: 'json',
                        url: '/painel/conselheiro/getAllFilesByAgendaId/' + agenda.agenda_id, // This is the url we gave in the route
                        success: function (files) { // What to do if we succeed
                            $('#uploaded-files', function () {
                                $.each(files, function (key, url) {
                                    var img = $('<img>'); //Equivalent: $(document.createElement('img'))
                                    img.attr('src', url);
                                    img.attr('class', 'img-thumbnail');
                                    img.height(150);
                                    img.width(150);
                                    img.appendTo('#uploaded-files');
                                })

                            });
                        }
                    })

                },
                error:

                    function (jqXHR, textStatus, errorThrown) { // What to do if we fail
                        console.log(JSON.stringify(jqXHR));
                        console.log("AJAX error: " + textStatus + ' : ' + errorThrown);
                    }
            });
        });


    </script>

    <script>
        $(document).ready(function () {
            $("#charNum0").text("Caracteres restantes: " + 300);
            $("#resumo").on('keyup paste change focus', function () {

                var Characters = $("#resumo").val().replace(/(<([^>]+)>)/ig, "").length; // '$' is missing from the selector

                $("#charNum0").text("Caracteres restantes: " + (300 - Characters));
            });
            $("#charNum1").text("Caracteres restantes: " + (3000));

            $("#pauta").on('keyup paste change focus', function () {

                var Characters = $("#pauta").val().replace(/(<([^>]+)>)/ig, "").length; // '$' is missing from the selector

                $("#charNum1").text("Caracteres restantes: " + (3000 - Characters));
            });


        });


    </script>


@endsection

