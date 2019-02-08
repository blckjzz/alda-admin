<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use TCG\Voyager\Traits\VoyagerUser;


class User extends \TCG\Voyager\Models\User
{
    use Notifiable;
    use VoyagerUser;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];


    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];


    public function conselho()
    {
        return $this->belongsTo('App\Conselho', 'conselho_id');
    }

    public function meetingList()
    {
        $agendas = $this->conselho->agendas;
        return $agendas->where('status_id',5)->pluck('id', 'list_agenda');
    }




}
