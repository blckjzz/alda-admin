<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Resultado extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'resultados';

    public function agenda()
    {
        return $this->hasOne('\App\Agenda');
    }

}