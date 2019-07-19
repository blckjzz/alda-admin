<?php

namespace App\Http\Controllers;

use App\MembroNato;
use Illuminate\Http\Request;

class MembrosNatosController extends Controller
{
    public function findMembroNatoById($id)
    {
        $membroNato = MembroNato::find($id);
        return $membroNato;
    }



}
