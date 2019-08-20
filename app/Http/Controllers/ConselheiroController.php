<?php

namespace App\Http\Controllers;

use App\ConselhoAbrangencia;
use App\Diretoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Assunto;
use Intervention\Image\Image;
use \Validator;
use DB;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use http\Client\Response;


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
        $membrosNatos = $this->getMembrosNatosByConselhoId($user->conselho->id);
        return view('conselheiro.pauta.index', compact('agendas', 'assuntos'))->with(['bairros' => $bairros, 'membrosNatos' => $membrosNatos]);
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
            'cargo' => 'required',
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
            "membronato" => 'required|array|min:1',
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


        /**
         * Storing img from atas
         */
//        dd(public_path('storage'));
        if ($request->file('img_ata') != null) {
            foreach ($request->file('img_ata') as $img) {
                Storage::putFile($pathAta, $img);
            }
            $rc->updateFilePath($resultado, $pathAta);
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
    function getMembrosNatosByConselhoId($conselhoId)
    {
        $cpm = DB::table('membrosnatos_abrangencia')
            ->join('abrangencias', 'abrangencias.membronato_id', '=', 'membrosnatos_abrangencia.id')
            ->join('membros_natos as mn1', 'mn1.id', '=', 'membrosnatos_abrangencia.comandante_id')
            ->select('mn1.*')
            ->where('conselho_id', $conselhoId)
            ->get()->unique('id')->all();

        $delegados = DB::table('membrosnatos_abrangencia')
            ->join('abrangencias', 'abrangencias.membronato_id', '=', 'membrosnatos_abrangencia.id')
            ->join('membros_natos as mn2', 'mn2.id', '=', 'membrosnatos_abrangencia.delegado_id')
            ->select('mn2.*')
            ->where('conselho_id', $conselhoId)
            ->get()->unique('id')->all();

        return array_merge($delegados, $cpm);
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

    public function getAtaFilesByResultadoId($agendaId)
    {
        $rc = new ResultadoController();
        $files = $rc->getAtaFilesByAgendaId($agendaId);
        if (count($files) > 0) {
            return $files;
        }
        return abort(400);
    }

    public function unlinkImages($filePath)
    {
        dd(Storage::disk()->exists($filePath));
        Storage::disk()->delete($filePath);

    }
}
