<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserCompanies extends Model
{

    protected $table = "companies_user";

    public $fillable = ['user_id', 'companies_id'];
}
