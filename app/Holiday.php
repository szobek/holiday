<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Holiday extends Model
{
    protected $table = 'user_holidays';

    protected $fillable = [
        "from_date",
        "to_date",
        "user_id",
        "type_id",
        "company_id",
        "google_id",
    ];

}
