<?php

namespace App\Http\Controllers;

use App\Agenda;
use Illuminate\Http\Request;

class AssuntoController extends Controller
{
    public function getAssuntoAgendaByAgendaId($id)
    {
        return Agenda::find($id)->assuntos;
    }
}
