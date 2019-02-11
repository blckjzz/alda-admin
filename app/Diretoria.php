<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Diretoria extends Model
{
    protected $table = 'diretorias';

    public $timestamps = false;

    protected $primaryKey = 'id';


    public function conselho()
    {
        return $this->hasOne('App\Conselho', 'conselho_id');
    }
}
