<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Contacts extends Model
{
    protected $table = 'user_contacts';

    protected $fillable = [
        'user_id',
        'contact_name',
        'contact_email',
        'contact_phone',
        'contact_address',
    ];


    /**
     * @author norbi
     * @return
     */
    public function getUserContacts($uid){
        return $this->where('user_id',$uid)->get();
    }
}
