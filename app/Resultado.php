<?php

namespace App;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use DateTime;

class Resultado extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'resultados';

    protected $fillable = ['agenda_id', 'texto', 'pauta_interna', 'status_id', 'data', 'present_members', 'revisionstatus_id'];

    protected $dates = ['data'];


    public function agenda()
    {
        return $this->belongsTo('\App\Agenda', 'agenda_id');
    }


    public function assuntos()
    {
        return $this->belongsToMany('App\Assunto', 'assunto_resultado');
    }

    public function revisionStatus()
    {
        return $this->belongsTo('App\RevisionStatus', 'revisionstatus_id');
    }

    public function getDataAttribute($value)
    {
        $date = Carbon::parse($value)->format('d/m/Y');
        return $date;

    }

    public function setDataAttribute($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', $data);
        $this->attributes['data'] = $data;
    }

}
