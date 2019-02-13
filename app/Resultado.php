<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'resultados';

    protected $fillable = ['agenda_id', 'texto', 'status_id', 'revision_status'];

    public function agenda()
    {
        return $this->belongsTo('\App\Agenda',  'agenda_id');
    }


    public function assuntos()
    {
        return $this->belongsToMany('App\Assunto','assunto_resultado');
    }

}
