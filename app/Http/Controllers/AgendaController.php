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
        $agenda->conselho_id = Auth::user()->conselho->id;
        $agenda->status_id = 4;
//        foreach ($request->assunto as $assunto) {
//            $r->assuntos()->syncWithoutDetaching($assunto);
//        }

        $agenda->save();

        return $agenda;
    }


}
