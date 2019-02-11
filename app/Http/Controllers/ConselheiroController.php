<?php

namespace App\Http\Controllers;

use App\Diretoria;
use App\Http\Middleware\CheckConselheiro;
use App\Http\Requests\StoreConselheiro;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class ConselheiroController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        $agendas = $user->conselho->agendas;
        return view('conselheiro.pauta.browser', compact('agendas'));
    }

    public function viewCCS()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.conselho.index', compact ('conselho'));
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
        dd($request->all());
    }





}
