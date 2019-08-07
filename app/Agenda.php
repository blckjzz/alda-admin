<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTime;
class Agenda extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'agendas';

    protected $fillable = ['data, hora, hora_fim, endereco, conselho_id, status_id, data_hora', 'bairro'];

    protected $dates = ['data'];

    public $additional_attributes = ['id_css_endereco', 'list_agenda'];

    public function conselho()
    {
        return $this->belongsTo('App\Conselho', 'conselho_id');
    }

    public function resultado()
    {
        return $this->hasOne('App\Resultado', 'agenda_id');
    }
//
//    public function getDataAttribute($data)
//    {
//        if ($data == null || $data == '')
//            return "00/00/0000";
//        else
//            $date = Carbon::parse($data)->format('d/m/Y');
//            return $date;
//
//    }
//
//    public function setDataAttribute($value)
//    {
//        $this->attributes['data'] = Carbon::createFromFormat('d/m/Y', $value);
//    }

    public function getDataAttribute($value)
    {
        $date = Carbon::parse($value)->format('d/m/Y');
        return $date;

    }

    public function setDataAttribute($value)
    {
        $this->attributes['data'] = Carbon::createFromFormat('d/m/Y', $value);
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }

    public function presenca()
    {
        return $this->hasOne('App\Presenca','agenda_id');
    }

    public function assuntos()
    {
        return $this->belongsToMany('App\Assunto', 'assunto_agenda', 'agenda_id');
    }



    public function getIdCssEnderecoAttribute()
    {

        return "[ ID AGENDA $this->id] [ Data/Hora $this->data $this->hora] [{$this->status->status} ] [ {$this->conselho->ccs} ] [{$this->endereco}]";

    }

    public function getListAgendaAttribute()
    {
        return "{$this->id} - [{$this->conselho->ccs}] [Data/Hora $this->data $this->hora] [{$this->status->status} ] [{$this->endereco}] ";
    }

    public function getListaAgendasConselheiroAttribute()
    {
        return "{$this->id} - [Data/Hora $this->data $this->hora] [{$this->status->status} ] [{$this->endereco}] ";
    }
}
