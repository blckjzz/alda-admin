<?php

namespace App\Http\Controllers;

use App\Http\Middleware\CheckConselheiro;
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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request->all());
    }

    public function viewCCS()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.conselho.index', compact ('conselho'));
    }

    public function editCCS(Request $request)
    {
        dd($request);
        return $conselho;

    }

}
