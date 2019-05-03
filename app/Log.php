<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    protected $primaryKey = 'id';
    protected $fillable = ['id','event', 'message'];
}
