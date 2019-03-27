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
            'texto' => 'required|min:30',
            'agenda_id' => 'required',
            'data' => 'required',
            "assunto"    => "required|array|min:1",
            "assunto.*"  => "required|string|distinct|min:1",
            'data' => 'required',
            'present_members' => 'required|integer|min:1',
        ]);

        try {

            $a = Agenda::find($request->agenda_id);


            if ($a->resultado) { //update
                $a->resultado
                    ->update
                    (
                        [
                            'agenda_id' => $request->agenda_id,
                            'texto' => $request->texto,
                            'revisionstatus_id' => ($request->revisionstatus_id == null)? 1 : $request->revisionstatus_id
                        ]
                    );
                $a->resultado->assuntos()->sync($request->assunto);

                return $a->resultado;

            } else { // cria caso não tenha
                dd($request->all());
                $r = new Resultado();
                $r->agenda_id = $request->agenda_id;
                $r->texto = $request->texto;
                $r->revisionstatus_id = 1; // Em análise
                $r->save();

                return $r;
            }

        } catch (Error $e) {
            abort($e->getMessage());
        }

    }
}
