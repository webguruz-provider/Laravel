<?php

namespace App\Http\Controllers\Game\Ontracking;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Fingerprint;
use App\UserPoint;
use App\Question;
use App\QuestionStats;
use App\Debate;

use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;

class FingerprintController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //$fingerprint_obj= new Fingerprint;
        //$_obj_userpoint = new UserPoint;

        $fingerprint    = $request->input('fingerprint_string');
        //echo $request->input('event_type');

        //print_r($request->input('event_id'));
        

        $login_user     = empty(Auth::user()->id)?"0":Auth::user()->id;


        $fstring = $request->session()->get('fingerprint_string');
        if(empty($fstring)){
            $request->session()->put('fingerprint_string', $fingerprint);

            $debate_id   = $request->input('event_id');
            $debate_data = Debate::where('id', $debate_id)->first();

            if($this->addImpression($debate_data->question->id)){

            }

        }else{
            // already fingerprint_string added in session 
            // so DebateClickMiddleware is active to save question impression 
        }


        switch ($login_user) {
            case '0':
                

                return (string)$this->withOutLoginTracking($fingerprint, $request); // send fingerprint

                break;
            default:

                $fingerprint_id = $this->checkUserOnFingerprint($login_user, $fingerprint);
                if(!empty($fingerprint_id)){
                    $this->addOrMergePoints($fingerprint_id, $login_user, $request);
                }else{
                    die('new entry error here');
                }
                break;

        }

    }




    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }




    public function check_valid_point(){
        // 
    }

    

    // check use already on other fingerprint and return fingerprint_id
    public function checkUserOnFingerprint($login_user, $fingerprint){
        $query = Fingerprint::where('fingerprint_string', $fingerprint)->where('user_id', $login_user);
        if($query->count() > 0){
            $data = $query->first();
            return $data->id;
        }else{
            return Fingerprint::insertGetId(['fingerprint_string'=>$fingerprint,'user_id'=>$login_user, 'created_at'=>Carbon::now()]);
        }
    }



    // without login 
    public function withOutLoginTracking($fingerprint, $request){
        $response = Fingerprint::where('fingerprint_string', $fingerprint)->where('user_id', NULL)->first();
        if(empty($response)){
            $fingerprint_id = Fingerprint::insertGetId(['fingerprint_string'=>$fingerprint,'created_at'=>Carbon::now()]);
        }else{
            $fingerprint_id = $response->id;
        }
        if($this->addPointsWithoutLogin($fingerprint_id, $request)){
            return true;
        }
        return false;
        
    }



    // add points to user point table
    public function addPointsWithoutLogin($fingerprint_id, $request){
        $event_type     = $request->input('event_type');
        $event_id       = $request->input('event_id');


        $response = UserPoint::where('fingerprint_id', $fingerprint_id)
                        ->where('event_type', $event_type)
                        ->where('event_id', $event_id);
        
        if($response->count() == 0){

            // give point (new entry)
            $insert_array = array(
                'fingerprint_id'=>$fingerprint_id,
                'event_type'=>$event_type,
                'event_id'=>$event_id,
                'visitor_id'=>NULL,
                'points'=>'1',
                'created_at'=>Carbon::now()
            );
            if(UserPoint::insert($insert_array)){
                return true;
            }
        }
        return false;
    }


    public function addOrMergePoints($fingerprint_id,$login_user, $request){

        // get all points from user_points for userid 1

        //echo $fingerprint_id;
        //echo "<br>";
        $event_type     = $request->input('event_type');
        //echo "<br>";
         $event_id       = $request->input('event_id');
        //echo "<br>";
        //echo $login_user;
        //echo "<br>";
        
        $fingerprint_string = $request->input('fingerprint_string');
        $_tracking_points = $this->getTrackingPoints($fingerprint_string);


        if(!$_tracking_points){
            // no tracking exist

            // now check for my points in user_points
            if($this->checkValidPoint($login_user, $event_type, $event_id)){
                // valid insert into user point table
                $insert_array = array(
                    'fingerprint_id'=>$fingerprint_id,
                    'event_type'=>$event_type,
                    'event_id'=>$event_id,
                    'visitor_id'=>$login_user,
                    'points'=>'50',
                    'created_at'=>Carbon::now()
                );
                if(UserPoint::insert($insert_array)){
                    return true;
                }
            }else{
                return false;
            }
        }else{
            // already some points in tracking .
            // need to update 

            //print_r(json_decode(json_encode($_tracking_points)));
            //die('pppp');

            foreach($_tracking_points as $point){
                /*
                $query = UserPoint::where('fingerprint_id',$fingerprint_id)
                        ->where('event_type',$point->event_type)
                        ->where('event_id', $point->event_id);
                */

                $query = UserPoint::where('visitor_id',$login_user)
                        ->where('event_type',$point->event_type)
                        ->where('event_id', $point->event_id);


                if($query->count() > 0 ){
                    // already point exist
                    UserPoint::where('id', $point->id)->delete();
                    //die('already point exist');
                }else{
                    // update tracking fingerprint_id and visitor id
                    UserPoint::where('id', $point->id)->update(['fingerprint_id'=> $fingerprint_id, 'visitor_id'=>$login_user]);        
                }
            }

            if($this->checkValidPoint($login_user, $event_type, $event_id)){
                // valid insert into user point table
                $insert_array = array(
                    'fingerprint_id'=>$fingerprint_id,
                    'event_type'=>$event_type,
                    'event_id'=>$event_id,
                    'visitor_id'=>$login_user,
                    'points'=>'50',
                    'created_at'=>Carbon::now()
                );
                if(UserPoint::insert($insert_array)){
                    return true;
                }
            }else{
                return false;
            }


            // after update need to delete duplicate

        }

    }



    public function getTrackingPoints($fingerprint_string){
        $_query = Fingerprint::where('fingerprint_string', $fingerprint_string)
            ->where('user_id', NULL);
        if($_query->count() > 0){
            $data = $_query->first();
            return $this->getUserPointsByFId($data->id);
        }
        return false;
    }



    public function getUserPointsByFId($fingerprint_id){
        return UserPoint::where('fingerprint_id', $fingerprint_id)->get();
    }


    public function checkValidPoint($login_user, $event_type, $event_id){
        $isvalid = UserPoint::where('visitor_id', $login_user)->where('event_type', $event_type)
            ->where('event_id', $event_id)->count();
        if($isvalid > 0){
            return false;
        }
        return true;
    }




    // Question impression on debate view (On basis Fingerprint)
    public function addImpression($question_id){
        $fstring = session()->get('fingerprint_string');
        $question = Question::findOrfail($question_id);

        if ($question) {
            $question_stats = QuestionStats::where('question_id',$question_id)
                            ->where('event_type','impression')
                            ->where('visitor_id', NULL)
                            ->where('fingerprint_string', $fstring)
                            ->orderBy('created_at', 'desc')
                            ->first();

            if($question_stats){
                $to = Carbon::now();
                $from = $question_stats->created_at;
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes > 5){
                    QuestionStats::create([
                        'question_id'=> $question_id,
                        'event_type'=>'impression',
                        'visitor_id'=> NULL,
                        'fingerprint_string' => $fstring
                    ]);
                }
            }else{
                QuestionStats::create([
                    'question_id'=>$question_id,
                    'event_type'=>'impression',
                    'visitor_id'=> NULL,
                    'fingerprint_string' => $fstring
                ]);
            }
        }
        return true;

    }

}
