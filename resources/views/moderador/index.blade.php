@extends('voyager::master')

@section('page_title', 'Resultados em Análise')
@section('page_header')
    <h1 class="page-title">
        <i class="voyager-calendar"></i> Resultados em Análise
    </h1>

@stop

@section('content')
    <div class="page-content container-fluid">
        @include('voyager::alerts')
    </div>

    <div class="page-content container-fluid">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">CCS</th>
                <th scope="col">Texto</th>
                <th scope="col">Status</th>
                <th scope="col">Agenda</th>
                <th scope="col">AÇÕES</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                @foreach($emAnalise as $resultado)
                    <th scope="row">{{$resultado->agenda->conselho->ccs}}</th>
                    <th scope="row">{{str_limit($resultado->texto, 10)}}</th>
                    @if($resultado->revision_status == 1)
                        <th scope="row"> Em análise </th>
                    @elseif($resultado->revision_status == 2)
                        <th scope="row"> Aprovado </th>
                    @endif
                    <th scope="row">{{$resultado->agenda->list_agenda }}</th>

                    <th scope="row">
                        <a href="{{ action('ResultadoController@show', $resultado->id) }}" class="">Ver</a>
                    </th>
                @endforeach
            </tr>
            </tbody>
        </table>

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
