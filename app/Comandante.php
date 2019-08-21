<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comandante extends Model
{
    protected $table = 'comandantes';
    protected $primaryKey = 'id';
    protected $fillable = ['nome'];

}
