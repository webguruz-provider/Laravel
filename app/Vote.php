<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vote extends Model
{
    //
	protected $table = 'votes';
    protected $fillable = ['debate_id', 'user_id', 'voter_id','created_at', 'updated_at'];

    

    public function voter()
    {
        return $this->belongsTo(\App\User::class, 'voter_id');
    }

}
