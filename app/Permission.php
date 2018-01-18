<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{



    public function getUsersArray(){
        return $this->belongsToMany(User::class);
    }

    public function getUsers(){
        return $this->getUsersArray()->get();
    }

}
