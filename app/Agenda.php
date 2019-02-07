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
            return Carbon::parse($data)->format('d/m/Y');
    }

    public function setDataAttribute($data)
    {
        $this->attributes['data'] = DateTime::createFromFormat('d/m/Y', $data);
    }

    public function status()
    {
        return $this->belongsTo('App\Status', 'status_id');
    }


    public function getIdCssEnderecoAttribute()
    {

        return "[ ID AGENDA $this->id] [{$this->status->status} ] [ {$this->conselho->ccs} ] [{$this->endereco}]";

    }

}
