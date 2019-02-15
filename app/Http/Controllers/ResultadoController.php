<?php

namespace App\Http\Controllers;

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
        $this->validate($request, [
            'texto' => 'required',
            'agenda_id' => 'required',
        ]);

        try {

            $a = Agenda::find($request->agenda_id);

//            dd($request->all());
            if ($a->resultado) { //update
                $a->resultado
                    ->update
                    (
                        [
                            'agenda_id' => $request->agenda_id,
                            'texto' => $request->texto,
                        ]
                    );
                $a->resultado->revisionStatus->resultado
                    ->update(
                            ['revisionstatus_id' => $request->revisionstatus_id]
                    );
                //FIX - Precisa consertar o metodo para caso de alteração na pivot table
                $a->resultado->assuntos()->sync($request->assunto);

                return $a->resultado;

            } else { // cria caso não tenha
                $r = new Resultado();
                $r->agenda_id = $request->agenda_id;
                $r->texto = $request->texto;
                $r->revisionstatus_id = $request->revisionstatus_id;
                $r->save();

                return $r;
            }

        } catch (Error $e) {
            abort($e->getMessage());
        }

    }
}
