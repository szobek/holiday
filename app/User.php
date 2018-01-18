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
        return $this->getPermission()->toArray();
    }

    public function getPermissionListIdsAttribute(){
        return $this->getPermissionIds();
    }







}

