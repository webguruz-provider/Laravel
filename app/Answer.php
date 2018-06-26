<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model
{
    protected $table = 'answers';
    protected $fillable = [
       'question_id', 'answer'
    ];
    public function serveyAnswers(){
        return $this->hasMany(\App\UserAnswer::class, 'answer_id', 'id');
    }
}
