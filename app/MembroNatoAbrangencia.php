<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembroNatoAbrangencia extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'membrosnatos_abrangencia';


    public function delegado()
    {
        return $this->belongsTo('App\MembroNato', 'delegado_id');
    }

    public function comandante()
    {
        return $this->belongsTo('App\MembroNato', 'comandante_id');
    }

}
