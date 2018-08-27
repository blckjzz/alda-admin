<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MembroNato extends Model
{
    protected $table = 'membros_natos';

    public $timestamps = false;

    protected $primaryKey = 'cisp';
}
