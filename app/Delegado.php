<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Delegado extends Model
{
    protected $table = 'delegados';
    protected $primaryKey = 'id';
    protected $fillable = ['nome'];

}
