<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Agenda extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'agendas';

    protected $fillable = ['data, hora, endereco, conselho_id, status_id, data_hora'];

    protected $dates = ['data'];

    public function conselho()
    {
        return $this->belongsTo('App\Conselho', 'conselho_id');
    }

    public function resultados()
    {
        return $this->hasMany('App\Resultado', 'agenda_id');
    }

    public function getDataAttribute($data)
    {
        if ($data == null || $data == '')
            return null;
        else
            return Carbon::parse($data)->format('d/m/Y');
    }

}
