<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserServey extends Model
{
    protected $table = 'user_serveys';
    protected $fillable = [
       'user_id', 'question_id', 'status'
    ];
}
