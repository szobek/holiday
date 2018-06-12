<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkHours extends Model
{

    protected $table = "workhours";

    public $fillable = ['user_id', 'type'];


}
