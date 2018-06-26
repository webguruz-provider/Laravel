<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContestStats extends Model
{
    protected $fillable = ['contest_id', 'event_type','visitor_id','f_string','created_at'];
}
