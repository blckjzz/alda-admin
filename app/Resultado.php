<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'resultados';

    protected $fillable = ['agenda_id', 'texto', 'status_id', 'revisionstatus_id'];

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

}
