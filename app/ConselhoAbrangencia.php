<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ConselhoAbrangencia extends Model
{
    protected $table = 'abrangencias';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public function conselho()
    {
        return $this->belongsTo('\App\Conselho','conselho_id');
    }

    public function membrosNato()
    {
        return $this->belongsTo('\App\MembroNato','membronato_id');
    }
}


