<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Scholar extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'email',
        'first_name',
        'middle_name',
        'last_name',
        'username',
        'password',
        'date_started',
        'status',
        'type_id'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password'
    ];

    public function player()
    {
        return $this->hasOneThrough(Player::class,PlayerScholarHistory::class,'player_id','id','id','scholar_id')->latest('created_at');
    }
}
