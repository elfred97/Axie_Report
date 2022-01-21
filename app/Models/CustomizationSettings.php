<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomizationSettings extends Model
{
    public $table       = 'customization_settings';
    public $timestamps  = TRUE;
    protected $fillable = [
        'options',
        'user_id',
    ];

    protected $casts = [
        'options' => 'array',
    ];
}
