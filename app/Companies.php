<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Companies extends Model
{

    protected $table = 'companies';

    protected $fillable = [
        'name',
        'address',
        'short_name',
        'tax',
    ];

    protected $hidden = [];

    public $timestamps = false;
}
