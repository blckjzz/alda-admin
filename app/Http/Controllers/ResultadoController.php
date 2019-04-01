<?php

namespace App\Http\Controllers;

use App\Presenca;
use App\Resultado;
use App\Agenda;
use Illuminate\Http\Request;

class ResultadoController extends Controller
{
    public function findResultadoById($id)
    {
        $resultado = Resultado::find($id);
        return $resultado;
    }

    public function findAssuntosByResultadoId($id)
    {
        $resultado = Resultado::find($id);
        return $resultado->assuntos;
    }

    public function show($id)
    {
        $resultado = Resultado::find($id);
        return $resultado;
    }


    public function store(Request $request)
    {

        try {

            $a = Agenda::find($request->agenda_id);


            if ($a->resultado) { //update
                $a->resultado
                    ->update
                    (
                        [
                            'agenda_id' => $request->agenda_id,
                            'texto' => $request->texto,
                            'revisionstatus_id' => ($request->revisionstatus_id == null) ? 1 : $request->revisionstatus_id,
                            'present_members' => $request->present_members,
                            'data' => $request->data,
                        ]
                    );
                $a->presenca// update
                ->update
                (
                    [
                        'diretoria' => array($request->diretoria),
                        'membrosnato' => array($request->membrosnato),
                    ]
                );

                $a->resultado->assuntos()->sync($request->assunto);

                return $a->resultado;

            } else { // cria caso não tenha
                $r = new Resultado();
                $r->agenda_id = $request->agenda_id;
                $r->texto = $request->texto;
                $r->revisionstatus_id = 1; // Em análise
                $r->present_members = $request->present_members;
                $r->data = $request->data;
                $r->save(); //salva resultado da ata eletronica

                $p = new Presenca(); //cria a presença
                $p->diretoria = $request->diretoria;
                $p->membrosnato = $request->membrosnato;
                $p->save(); //salva a presença
                return $r;
            }

        } catch (Error $e) {
            abort($e->getMessage());
        }

    }
}
