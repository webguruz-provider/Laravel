<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EventStats extends Model
{
    protected $fillable = ['event_id', 'event_type','visitor_id','f_string','created_at'];
}
