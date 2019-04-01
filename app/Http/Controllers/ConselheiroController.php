<?php

namespace App\Http\Controllers;

use App\Agenda;
use App\Diretoria;
use App\Resultado;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use App\MembroNato;
use App\User;

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
        $membrosnatos = MembroNato::whereIn('id', $user->conselho->abrangencias
            ->pluck('membronato_id')->unique())
            ->get();
        return view('conselheiro.pauta.index', compact('agendas', 'assuntos', 'membrosnatos'));
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

        $this->validate($request, [
            'texto' => 'required|min:30',
            'agenda_id' => 'required',
            'data' => 'required',
            "assunto" => "required|array|min:1",
            "assunto.*" => "required|string|distinct|min:1",
            'data' => 'required',
            'present_members' => 'required|integer|min:1',
        ]);

        try {
            $rc = new ResultadoController();
            $rc->store($request); // armazena o Resultado da reunião

            return redirect()->action('ConselheiroController@viewPauta')
                ->with('success', 'Ata eletrônica registrada com
             sucesso! Em breve estará disponível na Alda!');
//                ->with(['message' => "Ata eletrônica registrada com sucesso! Em breve estará disponível na Alda!",
//                    'alert-type' => 'success']);

        } catch (\Exception $e) {
            $e->getTrace();
        }


    }


    public
    function viewMembrosNato()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.membrosnato.index', compact('conselho'));
    }

    public
    function editAgenda()
    {

    }
}
