<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $table = 'conselhos';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public function agenda()
    {
        return $this->hasMany('App\Agenda', 'conselho_id');
    }
}
