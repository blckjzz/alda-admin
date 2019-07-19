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
        return $this->hasMany('App\Agenda', 'conselho_id')->orderBy('data', 'DESC');
    }

    public function user()
    {
        return $this->hasOne('App\User');
    }

    public function diretoria()
    {
        return $this->hasMany('App\Diretoria', 'conselho_id');
    }

    public function abrangencias()
    {
        return $this->hasMany('App\ConselhoAbrangencia', 'conselho_id');
    }
    
}
