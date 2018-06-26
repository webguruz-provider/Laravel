<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserAnswer extends Model
{
    protected $table = 'user_answers';
    protected $fillable = [
       'user_id', 'question_id', 'answer_id', 'other_answer_text'
    ];

    public function answer(){
        return $this->belongsTo(\App\Answer::class, 'answer_id');
    }
    public function user(){
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
