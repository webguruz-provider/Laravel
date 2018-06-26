<?php
namespace App\Helpers;
use App\User;
use App\Question;
use App\Debate;
use App\Fingerprint;
use App\UserPoint;

use DB;

use Illuminate\Support\Facades\Auth;

class Points{

	private $point_type;
	private $rank;

    public function __construct() {
        
    	// 
        $this->point_type = array(
        	'1'=>['description'=>'For profile visit', 'point'=>2],// for profile view
        	'2'=>['description'=>'Invite a friend', 'point'=>1],// for profile view
        	'3'=>['description'=>'Share profile', 'point'=>1],// for profile view
            '4'=>['description'=>'Challenge friend', 'point'=>1],// for profile view
        );

        // rank defined array
        $this->rank = array(
        	'0'=>'Lavel 1',
        	'1000'=>'Lavel 2',
        	'2500'=>'Lavel 3',
        	'5000'=>'Lavel 4',
        	'7500'=>'Lavel 5',
        	'10000'=>'Lavel 6',
        	'15000'=>'Lavel 7',
        	'20000'=>'Lavel 8',
        	'25000'=>'Lavel 9',
        	'30000'=>'Lavel 10',
        	'35000'=>'Lavel 11',
        	'40000'=>'Lavel 12',
        	'45000'=>'Lavel 13',
        	'50000'=>'Lavel 14',
        	'55000'=>'Verified User'
        );
    }


	// check helper is working 
	function hello(){
		return "Hello Noora";
	}

	// here define one array where every type points defined for each action 
	// then use it in add_points method to get amount to credit points



	/**
     * Store points to user table
     *
     * @param  $type (here type is defined in )
     * @return \Illuminate\Http\Response
     */
	public function add_points($point_type, $user_id){
		$user= User::findOrFail($user_id);
        //$user->total_points = $user->total_points + $this->point_type[$point_type]['point'];

        $obj = new Fingerprint;

        $sql_points = $obj->with('user_points')->where('user_id', $user_id);
        $total_points = "0";
        if($sql_points->count() > 0){
            $user_points = $sql_points->get();

            foreach($user_points as $point ){

                if(!empty($point->user_points)){
                    foreach ($point->user_points as $row_point) {
                        //echo "<pre>";
                        $total_points = $total_points + $row_point->points;
                        //echo "</pre>";
                        //$data1 = json_decode(json_encode($value,true));
                    }
                }
            }
        }

        $user->total_points = $total_points;
        $user->rank = $this->get_user_rank($total_points);
        $user->save();
	}


	// get rank from earned points
	public function get_user_rank($total_points){
		if($total_points < 1000){
            $user_rank ="Level 1";
        }else if($total_points < 2500){
            $user_rank ="Level 2";
        }else if($total_points < 5000){
            $user_rank ="Level 3";
        }else if($total_points < 7500){
            $user_rank ="Level 4";
        }else if($total_points < 10000){
            $user_rank ="Level 5";
        }else if($total_points < 15000){
            $user_rank ="Level 6";
        }else if($total_points < 20000){
            $user_rank ="Level 7";
        }else if($total_points < 25000){
            $user_rank ="Level 8";
        }else if($total_points < 30000){
            $user_rank ="Level 9";
        }else if($total_points < 35000){
            $user_rank ="Level 10";
        }else if($total_points < 40000){
            $user_rank ="Level 11";
        }else if($total_points < 45000){
            $user_rank ="Level 12";
        }else if($total_points < 50000){
            $user_rank ="Level 13";
        }else{
            $user_rank ="Verified User";
        }
        return $user_rank;
	}




    function get_questions(){
        return Question::all();
    }
    
    
    function get_debates(){
        return DB::table('debates')
            ->leftJoin('debate_user', 'debate_user.debate_id', '=', 'debates.id')
            ->where('debate_user.user_id', Auth::user()->id )
            ->where('debates.status', 'needs_opponent' )
            ->get();

    }

    function get_question($id){
        return Question::findOrFail($id);
    }



}