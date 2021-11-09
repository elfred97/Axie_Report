<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
    //
    public $table       = 'type';
	public $timestamps  = TRUE;
	protected $fillable = [
        'name',
        'status',
	];
}
