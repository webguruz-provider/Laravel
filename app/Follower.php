<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Follower extends Model
{
    protected $fillable = array('user_id', 'followerid', 'status','is_favourite');


    /*
    public function users(){
    	return $this->belongsTo(\App\User::class, 'followerid');
    }
    */

	
    public function user(){
    	//return $this->hasOne(\App\User::class, 'user_id');
    	return $this->belongsTo(\App\User::class, 'followerid');
    }
    public function followedUser(){
    	return $this->belongsTo(\App\User::class, 'user_id');
    }
    



}
