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
    public function store(Request $request)
    {

        $a = Agenda::find($request->agenda_id);
        if (isset($a->resultado) && isset($a->presenca)) { //update
            return $this->update($request, $a);
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
            $p->diretoria = $request->diretoria; //ajustar
            $p->delegado_id = $request->delegado_id; // ajustar
            $p->comandante_id = $request->comandante_id; // ajustar
            $p->save(); //salva a presença
            return $r;

        }
    }

    /** update existent resultados
     * @param Request $request
     * @param Agenda $a
     * @return mixed
     */

    public function update(Request $request, Agenda $a)
    {
        $a->resultado
            ->update
            (
                [
                    'agenda_id' => (isset($a->resultado->agenda_id)) ? $request->agenda_id : $a->resultado->agenda_id,
                    'texto' => (isset($request->texto)) ? $request->texto : $a->resultado->texto,
                    'pauta_interna' => (isset($request->pauta_interna)) ? $request->pauta_interna : $a->resultado->pauta_interna,
                    'revisionstatus_id' => ($request->revisionstatus_id == null) ? 1 : $request->revisionstatus_id,
                    'present_members' => (isset($request->present_members)) ? $request->present_members : $a->resultado->present_members, //
                    'data' => (isset($request->data)) ? $request->data : $a->resultado->data,
                ]
            );

        if ($request->has('diretoria')) {
            $a->presenca()->update([
                'diretoria' => json_encode($request->diretoria),
            ]);
        }

        if ($request->has('delegado_id') && $request->has('comandante_id')) {
            $a->presenca()->update([
                'delegado_id' => json_encode($request->delegado_id),
                'comandante_id' => json_encode($request->comandante_id)
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
//        dd($agenda->resultado->file_path);
        if ($agenda->resultado->file_path == null) {
            abort(404, 'Não há imagens');
        }
        $files = Storage::disk()->allFiles($agenda->resultado->file_path);
        foreach ($files as $file) {
            $url[] = Storage::url($file);
        }
        return $url;
    }

}
