<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AssuntoAta extends Model
{
    protected $table = 'assunto_ata';

    public $timestamps = false;

    protected $primaryKey = 'id';
}
