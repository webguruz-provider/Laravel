<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

use Carbon\Carbon;

use Exception;
use App\UserPoint;
use App\Fingerprint;

use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    // add point
    function add_point($user_id,$fingerprint_string, $event_type, $event_id, $points){
    	$f_query 		= Fingerprint::where('user_id', $user_id)->where('fingerprint_string', $fingerprint_string);

    	$point_insert 	= array('event_type'=>$event_type, 'event_id'=>$event_id,'visitor_id'=>$user_id, 'points'=>$points, 'created_at'=>Carbon::now());

    	if($f_query->count() > 0){
            $data = $f_query->first();
            $point_insert['fingerprint_id'] = $data->id;
        }else{
        	$fingerprint_id = Fingerprint::insertGetId(['fingerprint_string'=>$fingerprint_string, 'user_id'=>$user_id, 'created_at'=>Carbon::now() ]);
          	$point_insert['fingerprint_id'] = $fingerprint_id;
        }
        if(UserPoint::insert($point_insert)){
        	return true;
        }
        return false;
    }


    public function add_point_once($fingerprint_string, $event_type, $event_id, $points, $visitor_id){
        $user_id = $visitor_id;
        $point_insert   = array(
            'event_type'=>$event_type,
            'event_id'=>$event_id,
            'visitor_id'=>$visitor_id,
            'points'=>$points,
            'created_at'=>Carbon::now()
        );

        $sql = Fingerprint::where('user_id', $user_id)->where('fingerprint_string', $fingerprint_string);
        if($sql->count() > 0){
            $data = $sql->first();
            $point_insert['fingerprint_id'] = $data->id;
        }else{
            $fingerprint_id = Fingerprint::insertGetId(['fingerprint_string'=>$fingerprint_string, 'user_id'=>$user_id, 'created_at'=>Carbon::now() ]);
            $point_insert['fingerprint_id'] = $fingerprint_id;
        }
        $_check_point = UserPoint::where('visitor_id', $visitor_id)
                                ->where('event_type', $event_type)
                                ->where('event_id', $event_id)->count();

        if($_check_point == 0){
            if(UserPoint::insert($point_insert)){
                return true;
            }
            return false;
        }
        return true;
    }


}
