<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $table = 'conselhos';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public function agendas()
    {
        return $this->hasMany('App\Agenda', 'conselho_id');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }
}
