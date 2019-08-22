<?php

namespace App\Http\Controllers;

use App\Comandante;
use App\Delegado;
use App\Diretoria;
use App\MembroNato;
use App\Presenca;
use Illuminate\Http\Request;
use App\Agenda;
use DB;

class PresencaController extends Controller
{
    /**
     * Store a newly created resource in files.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $presenca = new Presenca();
            $presenca->agenda_id = $request->agenda_id;
            $presenca->diretoria = array($request->diretoria);
            $presenca->comandante_id = array($request->comandante_id);
            $presenca->delegado_id = array($request->delegado_id);
            $presenca->save();
            return true;
        } catch (\Exception $e) {
            echo $e->getMessage();
            echo $e->getTrace();
        }
    }

    public function findPresencaByAgendaId($agendaId)
    {
        $agenda = Agenda::find($agendaId);

        if ($agenda->presenca == null) {
            abort(404, "Não há presença");
        }

        return response()->json(
            [
                'comandantes' => Comandante::whereIn('id', $agenda->presenca->comandante_id)->get(),
                'delegados' => Delegado::whereIn('id', $agenda->presenca->delegado_id)->get(),
                'diretoria' => Diretoria::whereIn('id', $agenda->presenca->diretoria)->get()
            ]
        );
    }

}
