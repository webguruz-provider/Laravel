<?php
namespace App\Helpers;
use App\DebateUser;
use App\Question;
use App\Debate;
use DB;
use Illuminate\Support\Facades\Auth;

class DebateUsers{

   
    function get_user($debate_id){
        return DB::table('debate_user')
            ->leftJoin('users', 'debate_user.user_id', '=', 'users.id')
            ->where('debate_user.debate_id',  $debate_id)
            ->first();
    }

}