<?php

namespace App\Http\Controllers;

use App\Resultado;
use App\RevisionStatus;
use Illuminate\Http\Request;
use Exception;

class ModeracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaPautas()
    {
        $resultados = Resultado::where('revisionstatus_id', '=', 1)
                                 ->orWhere('revisionstatus_id', '=', 2)
            ->orderBy('updated_at')
            ->get();
        return view('moderador.index', compact('resultados'));
    }

    public function showPauta($id)
    {
        $rc = new ResultadoController();
        $resultado = $rc->findResultadoById($id);
        $revision_status = RevisionStatus::all();
        return view('moderador.details', compact('resultado', 'revision_status'));
    }

    public function storeResultado(Request $request)
    {
        $rc = new ResultadoController();
        try {
            $resultado = $rc->store($request);
            return redirect()->action('ModeracaoController@listaPautas')
                ->with(['message' => "Você alterou o Resultado ". $resultado->agenda->list_agenda ."com sucesso.",
                    'alert-type' => 'success']);
        } catch (Exception $e) {
            return $e->getMessage();
        }

    }
}
