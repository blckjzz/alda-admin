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

//    public function membrosNato()
//    {
//        return $this->belongsTo('\App\MembroNato','membronato_id');
//    }

    public function membrosNatos()
    {
        return $this->belongsTo('App\MembroNatoAbrangencia', 'membronato_id');
    }

//    public function delegado()
//    {
//        return $this->hasOne('App\MembroNato', 'delegado_id');
//    }
//
//    public function comandante()
//    {
//        return $this->belongsTo('App\MembroNato', 'comandante_id');
//    }

}


