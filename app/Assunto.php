<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assunto extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'assuntos';

    #public $timestamps = false;


    public function resultados()
    {
        return $this->belongsToMany('App\Resultado','assunto_resultado');
    }

}
