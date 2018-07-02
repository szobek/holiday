<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class WorkHours extends Model
{

    protected $table = "workhours";

    public $fillable = ['user_id', 'incoming', 'outgoing'];

    public function getUsersArray(){
        return $this->belongsToMany(User::class);
    }

    public function getUsers(){
        return $this->getUsersArray()->get();
    }

    public function getUserObject(){
        return $this->hasOne(User::class );
    }

    public function getUser(){
        return $this->getUserObject()->get();
    }





}
