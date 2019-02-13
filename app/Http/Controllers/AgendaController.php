<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;

class AgendaController extends Controller
{
    public function findResultadoById($id)
    {
        return response()->json(Agenda::find($id)->resultado);

    }
}
