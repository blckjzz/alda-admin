<?php

namespace App\Http\Controllers;

use App\Agenda;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use DateTime;

class AgendaController extends Controller
{
    public function __construct()
    {

    }

    public function findResultadoByAgendaId($agendaId)
    {
        return response()->json(Agenda::find($agendaId)->resultado);

    }

    public function findAgendaPresencaByAgendaId($agendaId)
    {
        return response()->json(Agenda::find($agendaId)->presenca);
    }


    public function findAgendaById($id)
    {
        return Agenda::find($id);
    }

    public function create(Request $request)
    {
        $agenda = new Agenda();
        $agenda->data = DateTime::createFromFormat('d/m/Y', $request->data);
        $agenda->hora = Carbon::parse($request->hora)->format('h:m');
        $agenda->endereco = $request->endereco;
        $agenda->bairro = $request->bairro;
        $agenda->ponto_referencia = $request->ponto_referencia;
        $agenda->conselho_id = Auth::user()->conselho->id;
        $agenda->status_id = 4;
//        dd($request->all());
        foreach ($request->assunto as $assunto) {
            $agenda->assuntos()->sync($assunto);
        }

        $agenda->save();

        return $agenda;
    }

    public function update(Request $request, $agendaId)
    {

        $a = Agenda::find($agendaId);

        $a->data = $request->data;
        $a->hora = $request->hora;
        $a->endereco = $request->endereco;
        $a->bairro = $request->bairro;
        $a->ponto_referencia = $request->ponto_referencia;

        $a->save();

        if ($request->has('assunto') && is_array($request->assunto) && count($request->assunto))
            $a->assuntos()->sync($request->assunto);


        return $a;
    }

}
