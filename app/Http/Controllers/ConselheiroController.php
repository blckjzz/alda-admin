<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\ConselhoAbrangencia;
use App\Diretoria;
use App\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use App\MembroNato;
use App\User;
use \Validator;

class ConselheiroController extends Controller
{

    public function dashboard()
    {
        return view('conselheiro.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPauta()
    {
        $user = Auth::user();
        $agendas = $user->conselho->agendas->where('realizada', true);
        $assuntos = Assunto::all();
        $bairros = $user->conselho->abrangencias->pluck('bairro', 'id');
        return view('conselheiro.pauta.index', compact('agendas', 'assuntos'))->with(['bairros' => $bairros]);
    }

    public function viewCCS()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.conselho.index', compact('conselho'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
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
//
//        $this->validate($request, [
//            'texto' => 'required|min:30',
//            'agenda_id' => 'required',
//            'data' => 'required',
//            "assunto" => "required|array|min:1",
//            "assunto.*" => "required|string|distinct|min:1",
//            "comandante_id" => "required|array|min:1",
//            "delegado_id." => "required|string|distinct|min:1",
//            'data' => 'required',
//            'pauta_interna' => 'required|min:100',
//            'present_members' => 'required|integer|min:1',
//        ]);

        $rules = array(
            'texto' => 'required|min:30',
            'agenda_id' => 'required',
            'data' => 'required',
            "assunto" => "required|array|min:1",
            "assunto.*" => "required|string|distinct|min:1",
            "comandante_id" => 'required_without:delegado_id',
            'delegado_id' => 'required_without:comandante_id',
            'data' => 'required',
            'pauta_interna' => 'required|min:100',
            'present_members' => 'required|integer|min:1',
        );

        $messages = array(
            'comandante_id.required' => 'Você precisa informar qual Comandante estava presente.',
            'delegado_id.required' => 'Você precisa informar qual Delegado estava presente.'
        );

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator->errors()->first());
        }


        $rc = new ResultadoController();
        $rc->store($request); // armazena o Resultado da reunião

        return redirect()->action('ConselheiroController@viewPauta')
            ->with('success', 'Ata eletrônica registrada com
             sucesso! Após aprovação da equipe, será disponobililizada ao público.');
    }


    public function viewMembrosNato()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.membrosnato.index', compact('conselho'));
    }


    public function getMembroNatoByAbrangenciaId($id)
    {
        $abrangencia = ConselhoAbrangencia::find($id);
        return ['comandante' => $abrangencia->membrosNatos->comandante, 'delegado' => $abrangencia->membrosNatos->delegado];

    }
}
