<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
// use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class UserModel extends Authenticatable
{
    //
    public $table       = 'user';
	public $timestamps  = TRUE;
	protected $fillable = [		
        'first_name',
        'middle_name',
        'last_name',
        'username',
		'password'
	];
}
