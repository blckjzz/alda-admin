<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Presenca extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'presenca_reuniao';

    protected $fillable = ['agenda_id', 'comandante_id', 'delegado_id', 'diretoria'];

    protected $dates = ['data'];

    protected $casts = [
        'comandante_id' => 'array',
        'delegado_id' => 'array',
        'diretoria' => 'array',
    ];


    public function agenda()
    {
        return $this->belongsTo('App\Agenda', 'agenda_id');
    }

}
