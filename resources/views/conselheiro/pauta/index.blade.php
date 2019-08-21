@extends('layout.master')

@section('page_title', 'Adicionar Ata Eletrônica')

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Cadastro de Ata Eletrônica de reunião
    </h1>

@stop
@section('css')
    <link rel="stylesheet" href="{{asset("/admin/bower_components/bootstrap-fileinput/css/fileinput.css")}}">
    <link rel="stylesheet" href="{{asset("/admin/bower_components/bootstrap-fileinput/css/fileinput-rtl.css")}}">

@endsection
@section('content')
    <div class="page-content container-fluid">
        <form id="form" class="form-edit-add" role="form"
              action="{{ action('ConselheiroController@storePauta') }}"
              method="POST" enctype="multipart/form-data" autocomplete="off">
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
                                    <span style="color:red">*</span> são campos obrigatórios para envio da ata
                                    eletrônica.
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="name">Reunião</label> <span style="color:red">*</span>
                                <select class="form-control" id="agenda" name="agenda_id">
                                    <option selected="true" disabled="disabled">Selecione uma reunião</option>
                                    @foreach($agendas as $agenda)
                                        <option
                                            value="{{ $agenda->id }}" {{ (collect(old('agenda_id'))->contains($agenda->id)) ? 'selected':'' }} > {{$agenda->listaAgendasConselheiro}} </option>
                                    @endforeach
                                </select>
                            </div>

                            {{--                            <div class="form-group">--}}
                            {{--                                <label for="">Data</label> <span style="color:red">*</span>--}}
                            {{--                                <input type="input" name="data"--}}
                            {{--                                       value="{{(collect(old('data'))->contains($agenda->data)) ? $agenda->data : \Carbon\Carbon::today()->format('d/m/Y') }}"--}}
                            {{--                                       class="form-control">--}}
                            {{--                            </div>--}}

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
                                @foreach($agenda->conselho->diretoria->sort() as $diretor)
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="dir{{$diretor->id}}"
                                               value="{{$diretor->id}}" name="diretoria[]">
                                        <label class="form-check-label" for="dir{{$diretor->id}}">{{$diretor->nome}}
                                            - {{$diretor->cargo}}</label>
                                    </div>
                                @endforeach

                            </div>
                            <div class="form-group">
                                <label for="">Membros Natos presentes </label> <span style="color:red">*</span>
                                <div id="membro-nato">
                                    <label for="">Comandante(s): </label>
                                    <div class="form-check form-check-inline">
                                        @foreach($comandantes as $comandante)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                       id="comandante{{$comandante->id}}"
                                                       value="{{$comandante->id}}"
                                                       name="comandante_id[]">

                                                <label class="form-check-label"
                                                       for="comandante{{$comandante->id}}">{{$comandante->nome}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                    <label for="">Delegado(s): </label>
                                    <div class="form-check form-check-inline">
                                        @foreach($delegados as $delegado)
                                            <div class="form-check form-check-inline">
                                                <input class="form-check-input" type="checkbox"
                                                       id="delegado{{$delegado->id}}"
                                                       value="{{$delegado->id}}"
                                                       name="delegado_id[]">

                                                <label class="form-check-label"
                                                       for="delegado{{$delegado->id}}">{{$delegado->nome}}</label>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-12">
                                    <div class="panel panel-bordered">
                                        <div class="panel-body">
                                            <div class="form-group">
                                                <label for="">Selecione Ata física (Fotos)</label>
                                                <input class="form-control" id="fileupload" type="file" name="img_ata[]"
                                                       multiple="multiple">

                                            </div>
                                            <div class="form-group">
                                                <label for="">Arquivos Armazenados</label>
                                                <div class="form-inline" id="uploaded-files">

                                                </div>
                                            </div>


                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-danger">Cancelar</button>
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

        // $(document).ready(function(){
        //     $('.remover').on('click', function(e){
        //         e.preventDefault();
        //         alert("Handling link click");
        //     });
        //
        // });

        $("#fileupload").fileinput();

        $("#agenda").on('change', function () {
            var id = $("select option:selected").val();
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
                            // console.log(presenca);
                            $.each(presenca.delegados, function (key, value) {
                                // console.log('#mn' + value.id);
                                if ($('#delegado' + value.id).val() == value.id) {
                                    $('#delegado' + value.id).prop('checked', true);
                                }
                            });

                            $.each(presenca.comandantes, function (key, value) {
                                // console.log('#mn' + value.id);
                                if ($('#comandante' + value.id).val() == value.id) {
                                    $('#comandante' + value.id).prop('checked', true);
                                }
                            });

                            $.each(presenca.diretoria, function (key, value) {
                                // console.log('#dir' + value.id);
                                if ($('#dir' + value.id).val() == value.id) {
                                    $('#dir' + value.id).prop('checked', true);
                                }
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
                                    // button = $('<input value='+ agenda.agenda_id +' class="btn btn-danger remover"/>');
                                    var img = $('<img>'); //Equivalent: $(document.createElement('img'))
                                    img.attr('src', url);
                                    img.attr('class', 'img-thumbnail');
                                    img.height(150);
                                    img.width(150);
                                    img.appendTo('#uploaded-files');
                                    // button.appendTo(img);
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
            })
            ;
        })
        ;


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
