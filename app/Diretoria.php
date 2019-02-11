<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;

class Diretoria extends Model
{
    protected $table = 'diretorias';

    public $timestamps = false;

    protected $primaryKey = 'id';

    protected $fillable = ['inicio_gestao', 'fim_gestao','cargo', 'nome'];


    public function conselho()
    {
        return $this->hasOne('App\Conselho', 'conselho_id');
    }

    public function getInicioGestaoAttribute($data)
    {
        if ($data == null || $data == '')
            return "00/00/0000";
        else
            $date = Carbon::parse($data)->format('d/m/Y');
        return $date;

    }

    public function getFimGestaoAttribute($data)
    {
        if ($data == null || $data == '')
            return "00/00/0000";
        else
            $date = Carbon::parse($data)->format('d/m/Y');
        return $date;

    }

    public function setInicioDaGestaoAttribute($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', $data);
        $this->attributes['data'] = $data;
    }

    public function setFimGestaoAttribute($data)
    {
        $data = DateTime::createFromFormat('d/m/Y', $data);
        $this->attributes['data'] = $data;
    }
}
