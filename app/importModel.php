<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class importModel extends Model
{
    //
    public $table       = 'report';
	public $timestamps  = TRUE;
	protected $fillable = [
		'file_name',
		'path',
        'status'
	];
}
