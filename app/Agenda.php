<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTime;
class Agenda extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'agendas';

    protected $fillable = ['data, hora, endereco, conselho_id, status_id, data_hora'];

    protected $dates = ['data'];

    public $additional_attributes = ['id_css_endereco'];

    public function conselho()
    {
        return $this->belongsTo('App\Conselho', 'conselho_id');
    }

    public function resultados()
    {
        return $this->hasMany('App\Resultado', 'agenda_id');
    }

    public function getDataAttribute($data)
    {
        if ($data == null || $data == '')
            return "00/00/0000";
        else
            $date = Carbon::parse($data)->format('d/m/Y');
            return $date;

    }

    public function setDataAttribute($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', $data);
        $this->attributes['data'] = $data;
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }


    public function getIdCssEnderecoAttribute()
    {

        return "[ ID AGENDA $this->id] [ Data/Hora $this->data $this->hora] [{$this->status->status} ] [ {$this->conselho->ccs} ] [{$this->endereco}]";

    }

}
