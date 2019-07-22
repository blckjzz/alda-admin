<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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
        $agenda->data = $request->data;
        $agenda->hora = $request->hora;
        $agenda->endereco = $request->endereco;
        $agenda->bairro = $request->bairro;
        $agenda->conselh_id = Auth::user()->conselho->id;
        $agenda->status_id = 4;

        $agenda->save();

        return $agenda;
    }


}
