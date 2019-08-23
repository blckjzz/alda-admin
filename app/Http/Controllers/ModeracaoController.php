<?php

namespace App\Http\Controllers;

use App\Assunto;
use App\Conselho;
use App\Resultado;
use App\RevisionStatus;
use Illuminate\Http\Request;
use App\User;
use TCG\Voyager\Models\Role;
use Illuminate\Support\Facades\Validator;
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
        $assuntos = Assunto::all();
        $delegados = $cc->getDelegadosByConselhoId($resultado->agenda->conselho->id);
        $comandantes = $cc->getComandantesByConselhoId($resultado->agenda->conselho->id);


        return view('moderador.details', compact('revision_status', 'assuntos', 'delegados', 'comandantes', 'resultado'))->with(['delegados' => $delegados, 'comandantes' => $comandantes]);


    }

    public function storeResultado(Request $request)
    {
        $rc = new ResultadoController();
        $resultado = $rc->store($request);
        if ($resultado) {
            return redirect()->back()
                ->with(['message' => "Suas modificações foram gravadas no banco de dados.",
                    'alert-type' => 'success']);
        }
        return abort(500, 'Algo deu errado.');

    }


    public function viewCadastroCCS()
    {
        $conselheiros = User::where('role_id', 4)
            ->WhereNull('conselho_id')
            ->get(); //conselheiros apenas que não estão associados com nenhum conselho.
        $conselhos = Conselho::all();
        $roles = Role::all();
        return view('admin.associa_conselho', compact('conselheiros', 'conselhos', 'roles'));
    }

    public function salvarConselheiroConselho(Request $request)
    {
        $rules = array(
            'conselheiro' => 'required',
            'conselho' => 'required',
        );

        $messages = [
            'required' => 'O :attribute é obrigatório.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);
        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator->errors()->first());
        }

        $user = User::find($request->input('conselheiro'));
        $conselho = Conselho::find($request->input('conselho'));
        $user->conselho_id = $conselho->id;
        $user->save();
        return redirect()->back()
            ->with(['message' => "Suas modificações foram gravadas no banco de dados.",
                'alert-type' => 'success']);

    }

}
