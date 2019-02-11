<?php

namespace App\Http\Controllers;

use App\Diretoria;
use Illuminate\Http\Request;

class DiretoriaController extends Controller
{
    public function findDiretoriaById($id)
    {
        $dir = Diretoria::find($id);
        return $dir;
    }
}
