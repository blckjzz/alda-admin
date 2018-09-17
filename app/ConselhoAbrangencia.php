<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConselhoAbrangencia extends Model
{
    protected $table = 'abrangencias';

    public $timestamps = false;

    protected $primaryKey = 'id';
}
