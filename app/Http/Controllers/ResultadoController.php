<?php

namespace App\Http\Controllers;

use App\Resultado;
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
}
