<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use TCG\Voyager\Traits\VoyagerUser;

class MembroNato extends Model
{
    use VoyagerUser;

    protected $table = 'membros_natos';

    public $timestamps = false;

    protected $primaryKey = 'id';

    public function abrangencias()
    {
        return $this->hasMany('App\ConselhoAbrangencia', 'membronato_id');
    }


}
