<?php

namespace App;

use FontLib\TrueType\Collection;
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
        'name', 'email', 'password','holidays','telephone'
    ];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $appends = ['company_list', 'permission_list', 'permission_list_ids'];


    public function getCompanyListAttribute() {
        return $this->getCompanies();
    }

    /**
     * @author norbi
     * @return
     */
    public function getCompaniesArray(){
        return $this->belongsToMany(Companies::class);
    }

    /**
     * @author norbi
     * @return
     */
    public function getCompanies(){
        return $this->getCompaniesArray()->get();
    }

    /**
     * @author norbi
     * @return
     */
    public function getPermissionArray(){
        return $this->belongsToMany(Permission::class);
    }

    /**
     * @author norbi
     * @return
     */
    public function getPermission(){
        return $this->getPermissionArray()->get();
    }

    public function getPermissionIds(){
        return $this->getPermissionArray()->get()->pluck('id')->toArray();
    }

    /**
     * @author norbi
     * @return
     */
    public function getPermissionListAttribute(){
        $perm = $this->getPermission();
//        dd($perm);
        return ($perm !== null) ? $perm->toArray() : new Collection();
    }

    public function getPermissionListIdsAttribute(){
        return $this->getPermissionIds();
    }



    public function getUsersHolidaysArray() {
        if(isset($this->id))
            $req = $this->getUsersHolidays();
            return ($req->count() > 0) ? $req->get() : null;
        return null;
    }

    public function getUsersHolidays() {
        return $this->hasMany(Holiday::class);
    }

    public function getCompaniesArrayTest($key, $value){
        $req = $this->belongsToMany(Companies::class);
//        dd($key, $value);
        if(is_null($key) || is_null($value))
            return $req;
        else
            return $req->where($key, $value);
    }

    public function getCompaniesTest($key = null, $value = null){
        return $this->getCompaniesArrayTest($key, $value)->get();
    }

    /**
     * @author norbi
     * @return
     */
    public function keres(){
        return [];
    }

    /**
     * @author norbi
     * @return
     */
    public function keres2(){
        return $this->getCompaniesArray()->get();
    }







}

