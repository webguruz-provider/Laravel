<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertiser extends Model
{
    protected $table = 'advertisers';
    protected $fillable = [
       'user_id', 'company_name', 'contact_name', 'phone', 'email', 'agreement', 'status'
    ];
}
