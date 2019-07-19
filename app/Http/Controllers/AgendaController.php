<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function findResultadoByAgendaId($agendaId)
    {
        return response()->json(Agenda::find($agendaId)->resultado);

    }


    public function findAgendaPresencaByAgendaId($agendaId)
    {
        return response()->json(Agenda::find($agendaId)->presenca);
    }
}
