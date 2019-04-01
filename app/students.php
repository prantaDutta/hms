<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class students extends Model
{
    protected $fillable = [
        'name', 'email', 'password','id',
    ];
}
