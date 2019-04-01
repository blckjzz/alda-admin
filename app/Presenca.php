<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Presenca extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'presenca_reuniao';

    protected $fillable = ['agenda_id', 'membrosnato', 'diretoria'];

    protected $dates = ['data'];

    protected $casts = [
        'membrosnato' => 'array',
        'diretoria' => 'array',
    ];


    public function agenda()
    {
        return $this->belongsTo('App\Agenda', 'agenda_id');
    }


}
