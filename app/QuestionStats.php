<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuestionStats extends Model
{
    //
	public $table = 'question_stats';
	protected $fillable = ['question_id', 'event_type', 'visitor_id','fingerprint_string','created_at', 'updated_at'];


}
