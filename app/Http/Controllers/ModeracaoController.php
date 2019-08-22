<?php

namespace App\Http\Controllers;

use App\Assunto;
use App\Resultado;
use App\RevisionStatus;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;

class ModeracaoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function listaPautas()
    {
        $resultados = Resultado::all();
        return view('moderador.index', compact('resultados'));
    }

    public function showPauta($id)
    {
        $rc = new ResultadoController();
        $cc = new ConselheiroController();
        $resultado = $rc->findResultadoById($id);
        $revision_status = RevisionStatus::all();
        $user = Auth::user();
        $assuntos = Assunto::all();
        $delegados = $cc->getDelegadosByConselhoId($resultado->agenda->conselho->id);
        $comandantes = $cc->getComandantesByConselhoId($resultado->agenda->conselho->id);


        return view('moderador.details', compact('revision_status', 'assuntos', 'delegados', 'comandantes', 'resultado'))->with(['delegados' => $delegados, 'comandantes' => $comandantes]);


    }

    public function storeResultado(Request $request)
    {
        $rc = new ResultadoController();

//        dd($request->all());

        $resultado = $rc->store($request);
        if ($resultado) {
            return redirect()->back()
                ->with(['message' => "Suas modificações foram gravadas no banco de dados.",
                    'alert-type' => 'success']);
        }
        return abort(500, 'Algo deu errado.');

    }
}
