<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Resultado;

class FileHandleController extends Controller
{
    // TODO - REFACTOR - MOVE TO CODE ABOVE TO NEW CLASS

    /**
     * @param Resultado $resultado
     * @return string
     */
    public function getBasePathResultado(Resultado $resultado): string
    {
        $basePath = '/'.$resultado->agenda->conselho->id . '/' . $resultado->agenda->id . '/' . $resultado->id;
        return $basePath;
    }

    public function getAtaPath($basePath)
    {
        return $basePath . '/ata/';
    }

    public function getPresencaPath($basePath)
    {
        return $basePath . '/presenca/';
    }
}
