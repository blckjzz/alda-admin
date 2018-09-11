<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class IdCc extends Model
{
    protected $table = 'id_ccs';

    public $timestamps = false;

    protected $primaryKey = 'cod_ccs';

    public function agenda()
    {
        return $this->hasMany('App\Agenda', 'id_ccs_cod_ccs');
    }
}
