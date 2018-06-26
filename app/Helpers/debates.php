<?php
namespace App\Helpers;
use App\Debate;
use App\DebateUser;

class Debates{


	public function getDebateUserSide($debate_id, $user_id){
		return DebateUser::where('debate_id', $debate_id)->where('user_id',$user_id)->first();
	}



}