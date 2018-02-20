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

    /**
     * @author norbi
     * @return
     */
    public function userList(){
//        dd('itt ', 'app/Companies.php:28');
        $req = $this->userListarray();
        if($req !== null)
            return $this->userListarray()->get();
        else
            return null;
    }

    /**
     * @author norbi
     * @return
     */
    public function userListarray(){
        return $this->belongsToMany(User::class);
    }
}
