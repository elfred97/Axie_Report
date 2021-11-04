<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TypeModel extends Model
{
    //
    public $table       = 'type';
	public $timestamps  = TRUE;
	protected $fillable = [		
        'name',
        'status',        
	];
}
