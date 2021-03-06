<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class NonWorking extends Model
{
    protected $table = 'non-working';

    protected $fillable = [
        'name','year', 'date', 'description', 'type'
    ];

    protected $hidden = [];
    public $timestamps = false;
}
