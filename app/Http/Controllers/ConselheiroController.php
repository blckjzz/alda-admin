<?php

namespace App\Http\Controllers;

use App\ConselhoAbrangencia;
use App\Diretoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use \Validator;
use DB;
use Illuminate\Support\Facades\Storage;


class ConselheiroController extends Controller
{

    public function dashboard()
    {
        return view('conselheiro.dashboard');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function viewPauta()
    {
        $user = Auth::user();
        $agendas = $user->conselho->agendas->where('realizada', true);
        $assuntos = Assunto::all();
        $bairros = $user->conselho->abrangencias->pluck('bairro', 'id');
        $delegados = $this->getDelegadosByConselhoId($user->conselho->id);
        $comandantes = $this->getComandantesByConselhoId($user->conselho->id);
        return view('conselheiro.pauta.index', compact('agendas', 'assuntos', 'delegados', 'comandantes'))->with(['bairros' => $bairros, 'delegados' => $delegados, 'comandantes' => $comandantes]);
    }

    public function viewCCS()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.conselho.index', compact('conselho'));
    }

    /**
     * Store a newly created resource in files.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    // TODO Refactor - Method belongs to Diretoria Controller
    public function storeDiretoria(Request $request)
    {

        $this->validate($request, [
            'inicio_gestao' => 'required',
            'fim_gestao' => 'required',
            'nome' => 'required'
        ]);

        Diretoria::find($request->id)
            ->update
            (
                [
                    'inicio_gestao' => $request->inicio_gestao,
                    'fim_gestao' => $request->fim_gestao,
                    'nome' => $request->nome,
                    'cargo' => $request->cargo
                ]
            );

        return redirect()->action('ConselheiroController@viewCCS')
            ->with(['message' => "Diretoria alterada com sucesso!",
                'alert-type' => 'success']);
    }


    public function storePauta(Request $request)
    {


        $rules = array(
            'texto' => 'required|min:30',
            'agenda_id' => 'required',
            "assunto" => "required|array|min:1",
            "assunto.*" => "required|string|distinct|min:1",
//            "membronato" => 'required|array|min:1',
            "assunto.*" => "required|string|distinct|min:1",
            'pauta_interna' => 'required|min:30',
            'present_members' => 'required|integer|min:1',
        );

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator->errors()->first());
        }


        $rc = new ResultadoController();
        $resultado = $rc->store($request); // armazena o Resultado da reunião

//        dd($resultado->agenda->conselho->id);

        $fc = new FileHandleController();


        $pathAta = $fc->getAtaPath($fc->getBasePathResultado($resultado));

        if ($resultado->file_path == null) {
            $rc->updateFilePath($resultado, $pathAta);
        }
        /**
         * Storing img from atas
         */
//        dd(public_path('storage'));
        if ($request->file('img_ata') != null) {
            foreach ($request->file('img_ata') as $img) {
                Storage::putFile($pathAta, $img);
            }
        }

        return redirect()->action('ConselheiroController@viewPauta')
            ->with('success', 'Ata eletrônica registrada com
             sucesso! Após aprovação da equipe, será disponobililizada ao público.');
    }


    public
    function viewMembrosNato()
    {
        $conselho = Auth::user()->conselho;
        return view('conselheiro.membrosnato.index', compact('conselho'));
    }

    public
    function getDelegadosByConselhoId($conselhoId)
    {
        $delegados = DB::table('conselhos as C')
            ->join('abrangencias as AB', 'AB.conselho_id', '=', 'C.id')
            ->join('delegados as D', 'AB.delegado_id', '=', 'D.id')
            ->select('D.*')
            ->groupBy('D.id')
            ->where('AB.conselho_id', $conselhoId)
            ->get()->all();

        return $delegados;
    }

    public
    function getComandantesByConselhoId($conselhoId)
    {
        $cpm = DB::table('conselhos as C')
            ->join('abrangencias as AB', 'AB.conselho_id', '=', 'C.id')
            ->join('comandantes as CPM', 'AB.comandante_id', '=', 'CPM.id')
            ->select('CPM.*')
            ->groupBy('CPM.id')
            ->where('AB.conselho_id', $conselhoId)
            ->get()->all();

        return $cpm;
    }

    public
    function getMembroNatoByAbrangenciaId($id)
    {
        $abrangencia = ConselhoAbrangencia::find($id);
        return ['comandante' => $abrangencia->membrosNatos->comandante, 'delegado' => $abrangencia->membrosNatos->delegado];

    }

    public
    function viewCadastrarReuniao()
    {
        $assuntos = Assunto::all();
        return view('conselheiro.pauta.criar_agenda', compact('assuntos'));
    }


    public
    function viewReuniao()
    {
        $agendas = Auth::user()->conselho->agendas()->where('realizada', 0)->get();
        $assuntos = Assunto::all();
        return view('conselheiro.pauta.edit_agenda',
            compact('agendas', 'assuntos'));
    }

    public
    function storeReuniao(Request $request)
    {
        $rules = array(
            'data' => 'required',
            'hora' => 'required',
            'hora_fim' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'ponto_referencia' => 'nullable|min:5',
            "assunto" => "required|array|min:1",
            "assunto.*" => "required|string|distinct|min:1",
        );


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator->errors()->first());
        }

//        dd($request->all());
        $agendaController = new AgendaController();

        $agendaController->create($request);

//        $pathPresenca = $this->getPresencaPath($fc->getBasePathResultado($resultado));
//        $imgl_ivro_presenca = $request->file('imgl_ivro_presenca');
//
//        /**
//         * Storing img from atas
//         */
//        foreach ($imgl_ivro_presenca as $img) {
//            Storage::putFile($pathPresenca, $img);
//        }


        return redirect()->action('ConselheiroController@viewReuniao')
            ->with(['success' => "Sua agenda foi armazenada com sucesso!", 'alert-type' => 'success']);
    }

    public
    function updateReuniao(Request $request)
    {
        $rules = array(
            'data' => 'required',
            'hora' => 'required',
            'hora_fim' => 'required',
            'endereco' => 'required',
            'bairro' => 'required',
            'ponto_referencia' => 'nullable|min:5',
            "assunto" => "required|array|min:1",
            "assunto.*" => "required|string|distinct|min:1",
        );


        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return back()->withInput($request->all())->withErrors($validator->errors()->first());
        }

        $agendaController = new AgendaController();

//        dd($request->all());
        $agendaController->update($request, $request->agenda);


        return redirect()->action('ConselheiroController@viewReuniao')
            ->with(['success' => "Sua agenda foi armazenada com sucesso!", 'alert-type' => 'success']);
    }

    public
    function getAtaFilesByResultadoId($agendaId)
    {
        $rc = new ResultadoController();
        $files = $rc->getAtaFilesByAgendaId($agendaId);
        if (count($files) > 0) {
            return $files;
        }
        return abort(400);
    }

    public
    function unlinkImages($filePath)
    {
        dd(Storage::disk()->exists($filePath));
        Storage::disk()->delete($filePath);

    }
}
