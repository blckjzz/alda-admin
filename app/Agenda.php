<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $table = 'agendas';

    protected $primaryKey = 'id';


    public function conselho()
    {
        return $this->belongsTo('App\Conselho', 'conselho_id');
    }

    public function resultados()
    {
        return $this->hasMany('App\Resultado', 'agenda_id');
    }
}
