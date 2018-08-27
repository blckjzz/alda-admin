<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conselho extends Model
{
    protected $table = 'id_ccs';

    public $timestamps = false;

    protected $primaryKey = 'cod_ccs';
}
