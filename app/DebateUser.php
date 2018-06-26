<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DebateUser extends Model
{
	protected $table = 'debate_user';

    protected $fillable = [
        'debate_id',
        'user_id',
        'question_ID',
        'votes',
        'side'
    ];



    public function arguments()
    {
        return $this->belongsTo(\App\DebateArgument::class, 'debate_users', 'user_id');
    }


    public function users()
    {
        return $this->belongsTo(\App\User::class, 'user_id');
    }
}
