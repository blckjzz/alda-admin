<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConselhoAbrangencia extends Model
{
    protected $table = 'abrangencias';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public function conselho()
    {
        return $this->belongsTo('\App\Conselho', 'conselho_id');
    }

    public function delegado()
    {
        return $this->belongsTo('App\Delegado', 'delegado_id');
    }

    public function comandante()
    {
        return $this->belongsTo('App\Comandante', 'comandante_id');
    }

}


