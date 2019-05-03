<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegacia extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'delegacias';
    public $timestamps = false;
}
