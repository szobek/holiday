<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HolidayTypes extends Model
{
    protected $table = 'types';

    protected $fillable = [
        'name'
    ];

    protected $hidden = [];
    public $timestamps = false;
}
