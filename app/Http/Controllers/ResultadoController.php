<?php

namespace App\Http\Controllers;

use App\Presenca;
use App\Resultado;
use App\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ResultadoController extends Controller
{
    public function findResultadoById($id)
    {
        $resultado = Resultado::find($id);
        return $resultado;
    }


    public function findAssuntosByResultadoId($id)
    {
        $resultado = Resultado::find($id);
        return $resultado->assuntos;
    }

    public function show($id)
    {
        $resultado = Resultado::find($id);
        return $resultado;
    }

    /** Store new entries for resultado
     * @param Request $request
     * @return Resultado
     */
    public function store(Request $request, $filePath = null)
    {

        $a = Agenda::find($request->agenda_id);

        if (isset($a->resultado) && isset($a->presenca)) { //update
            return $this->update($request, $a, $filePath);
        } else { //cria novo

            $r = new Resultado();
            $r->agenda_id = $request->agenda_id;
            $r->texto = $request->texto;
            $r->pauta_interna = $request->pauta_interna;
            $r->revisionstatus_id = 1; // Em análise
            $r->present_members = $request->present_members;
            $r->data = $request->data;


            $r->save(); //salva resultado da ata eletronica
            foreach ($request->assunto as $assunto) {
                $r->assuntos()->syncWithoutDetaching($assunto);
            }


            $p = new Presenca(); //cria a presença // ajustar
            $p->agenda_id = $request->agenda_id; // ajustar
            $p->diretoria = json_encode($request->diretoria); //ajustar
            $p->membrosnato = json_encode($request->membrosnato); // ajustar
            $p->save(); //salva a presença
            return $r;

        }
    }

    /** update existent resultados
     * @param Request $request
     * @param Agenda $a
     * @return mixed
     */

    public function update(Request $request, Agenda $a, $filePath = null)
    {
        $a->resultado
            ->update
            (
                [
                    'agenda_id' => (isset($a->resultado->agenda_id)) ? $request->agenda_id : $a->resultado->agenda_id,
                    'texto' => (isset($request->texto)) ? $request->texto : $a->resultado->texto,
                    'pauta_interna' => (isset($request->pauta_interna)) ? $request->pauta_interna : $a->resultado->pauta_interna,
                    'revisionstatus_id' => ($request->revisionstatus_id == null) ? 1 : $request->revisionstatus_id,
                    'present_members' => (isset($$request->present_members)) ? $request->present_members : $a->resultado->present_members, //
                    'data' => (isset($request->data)) ? $request->data : $a->resultado->data,
                    'file_path' => (isset($filePath)) ? $filePath : $a->resultado->filePath,
                ]
            );

        if ($request->has('diretoria')) {
            $a->presenca()->update([
                'diretoria' => json_encode($request->diretoria),
            ]);
        }

//        dd($request->all());
        if ($request->has('membronato')) {
            $a->presenca()->update([
                'membrosnato' => json_encode($request->membronato)
            ]);
        }

        if ($request->has('assunto') && is_array($request->assunto) && count($request->assunto))
            $a->resultado->assuntos()->sync($request->assunto);

        return $a->resultado;
    }

    public function updateFilePath(Resultado $resultado, $filePath)
    {
        $resultado->file_path = $filePath;
        return $resultado->save();
    }


    public function getAtaFilesByAgendaId($agendaId)
    {
        $agenda = Agenda::find($agendaId);
        return $files = Storage::files($agenda->resultado->file_path);
    }
}
