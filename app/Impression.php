<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Impression extends Model
{
    //
    protected $fillable = array('user_id','question_id','debate_id','visitor_id');



    public function question()
    {
        return $this->belongsTo(\App\Question::class);
    }



}
