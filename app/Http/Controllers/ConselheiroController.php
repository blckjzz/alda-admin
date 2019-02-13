<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Diretoria;
use App\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use Error;

class ConselheiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPauta()
    {
        $user = Auth::user();
        $agendas = $user->conselho->agendas;
        $assuntos = Assunto::all();
        return view('conselheiro.pauta.index', compact('agendas', 'assuntos'));
    }

    public function viewCCS()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.conselho.index', compact('conselho'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function storeDiretoria(Request $request)
    {

        $this->validate($request, [
            'inicio_gestao' => 'required',
            'fim_gestao' => 'required',
            'cargo' => 'required',
            'nome' => 'required'
        ]);

        Diretoria::find($request->id)
            ->update
            (
                [
                    'inicio_gestao' => $request->inicio_gestao,
                    'fim_gestao' => $request->fim_gestao,
                    'nome' => $request->nome,
                    'cargo' => $request->cargo
                ]
            );

        return redirect()->action('ConselheiroController@viewCCS')->with(['message' => "Diretoria alterada com sucesso!", 'alert-type' => 'success']);


    }

    public function storePauta(Request $request)
    {
        $this->validate($request, [
            'texto' => 'required',
            'agenda_id' => 'required',
        ]);

        try {

            $a = Agenda::find($request->agenda_id);

            if ($a->resultado) {
                $a->resultado
                    ->update
                    (
                        [
                            'agenda_id' => $request->agenda_id,
                            'texto' => $request->texto,
                        ]
                    );
                //FIX - Precisa consertar o metodo para caso de alteração na pivot table
                $a->resultado()->sync(array($request->assunto));

            } else { // cria caso não tenha
                $r = new Resultado();
                $r->agenda_id = $request->agenda_id;
                $r->texto = $request->texto;
                $r->status_id = 5; //Realizada
                $r->revision_status = 1;

                $r->save();
            }

            return redirect()->action('ConselheiroController@viewPauta')->with(['message' => "Pauta atualizada com sucesso! Aguarde a aprovação do membro Interno para publicação na Alda!", 'alert-type' => 'success']);


        } catch (Error $e) {
            abort($e->getMessage());
        }


    }


    public function viewMembrosNato()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.membrosnato.index', compact('conselho'));
    }

    public function editAgenda()
    {

    }


}
