<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RevisionStatus extends Model
{
    protected $primaryKey = 'id';

    protected $table = 'revision_status';

    protected $fillable = ['status'];
    
    public $timestamps = false;

    public function resultado()
    {
        return $this->hasOne('\App\Resultado',  'revisionstatus_id');
    }
}
