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

    // TODO Refactor - Method belongs to Diretoria Controller
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

        return redirect()->action('ConselheiroController@viewCCS')
                            ->with(['message' => "Diretoria alterada com sucesso!",
                                    'alert-type' => 'success']);
    }



    public function storePauta(Request $request)
    {
        $rc = new ResultadoController();
        $rc->store($request);
        return redirect()->action('ConselheiroController@viewPauta')
            ->with(['message' => "Resultado atualizado com sucesso! Aguarde a aprovação do membro Interno para publicação na Alda!",
                'alert-type' => 'success']);
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
