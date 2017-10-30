<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','company'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['company_data'];



    public function getCompanyDataAttribute() {
        return (Companies::find($this->company) !== null) ? Companies::find($this->company) : 'n/a';
    }
}

