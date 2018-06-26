<?php

namespace App\Http\Controllers\Game\Debates;

use App\User;
use App\Debate;
use App\DebateUser;
use App\UserPoint;
use App\Fingerprint;
use DB;

use App\Mail\Challenge;

use App\Mail\DebateJoined;



use App\Helpers\Points;
use App\DebateArgument;
use Session;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

class ChallengeController extends Controller
{

    // send challenge email 
    function challengeForDebate(Request $request){
        // email code 
        // genrate accept / decline link 
        
        $challenges_ids = $request->input('invite');

        if(is_array($challenges_ids) && !empty($challenges_ids)){
            foreach($challenges_ids as $challenge){
                $user = User::findOrFail($challenge);
                $take_a_dare_name = $request->input('take_a_dare_name_'.$challenge);
                if($user)
				{
					$notoficationStatus = DB::table('users')->where('email',$user->email)->first();
					if(!empty($notoficationStatus))
					{
						if($notoficationStatus->go_online!="false")
						{
							Mail::to($user->email)->send(new Challenge($take_a_dare_name , Auth::user())); 
						}
					}
					else
					{
						Mail::to($user->email)->send(new Challenge($take_a_dare_name , Auth::user())); 
					}						
					$points = new Points;
					$points->add_points(4, Auth::user()->id); // arg 1 for type of point; arg 2 who get these points   
                }
            }
        }
        //return redirect()->back()->withErrors(['Challenge Email Sent to selected user(s)']);
        Session::flash('message', "Selected users have been challenged for this debate.");

        return redirect()->back();
        //return redirect('feed');

    }



    // accept challenge email 
    function accept_challenge(Request $request){     
if(!empty(auth()->user()->id))
{   
        $debate_id  = Crypt::decryptString($request->input('debate_id'));
        //$debate     = Debate::findOrFail($debate_id);
        $debate     = Debate::with('question')->where('id',$debate_id)->first();
       //echo  $debate; exit;
       //$debate_arguments = "Testing Jk jkjkjk Arguments";
        //$response   = "Challenge Email Sent to selected user(s)";

        $response   = "Someone already joined the debate. You can vote or comment here.";

        if($debate->status == 'needs_opponent'){
           
            return view('game.debates.accept-challenge-dabate', compact('debate'));
            // if($this->join_debate_extension($debate->id, $debate_arguments)){
            //     Mail::to(auth()->user()->email)->send(new DebateJoined());
            //     $response = "You joined this debate. Add your opinion and find out who sides with you.";
            // }else{
            //     $response = "Problem in joing debate! Please try later.";
            // }
        }else{
            $user_debate = DebateUser::where('debate_id', $debate->id)
                ->where('user_id', auth()->user()->id)
                ->count();
            if($user_debate > 0){
                $response = "You already joined this debate.";
                //return redirect('debates/'.$debate->id)->withErrors(['You already joined this debate']);
            }
        }
        Session::flash('message', $response);
        return redirect('debates/'.$debate->id);
}
else{
    return redirect('feed');
}
    }


function saveChallengeWithArg(Request $request){
    $debateId = $request->input('debate_id');
    $debate_arguments = $request->input('join_debate_argument');
   if($this->join_debate_extension($debateId, $debate_arguments)){
	   $notoficationStatus = DB::table('users')->where('email',auth()->user()->email)->first();
					if(!empty($notoficationStatus))
					{
						if($notoficationStatus->go_online!="false")
						{
							Mail::to(auth()->user()->email)->send(new DebateJoined());
						}
					}
        $response = "You joined this debate. Add your opinion and find out who sides with you.";
    }else{
        $response = "Problem in joing debate! Please try later.";
    }
    Session::flash('message', $response);
    return redirect('debates/'.$debateId);
}

    // decline challanege
    function decline_challenge(Request $request){
        $debate_id = Crypt::decryptString($request->input('debate_id'));
        // $debate = Debate::findOrFail($request['debate_id']);
        
        //return redirect('debates/'.$debate_id)->withErrors(['Challenge Declined.']);
        Session::flash('message', "Challenge Declined");
        return redirect('debates/'.$debate_id);

    }

    // post request from debate show page
    function join_debate(Request $request){
        // echo "<pre>";
        // print_r($request->all());
        // exit;
        $debate_id = $request->input('debate_id');
        $debate_arguments = $request->input('debate_argument');
        if($this->join_debate_extension($debate_id, $debate_arguments)){
            Session::flash('message', "You joined this debate. Add your opinion and find out who sides with you.");


            // give point on join debate 
            $f_query = Fingerprint::where('user_id', auth()->user()->id);
            
            $point_insert = array('event_type'=>'debate_join', 'event_id'=>$debate_id,'visitor_id'=>auth()->user()->id, 'points'=>'50', 'created_at'=>Carbon::now());

            if($f_query->count() > 0){
                $data = $f_query->first();
                $point_insert['fingerprint_id'] = $data->id;
            }
            UserPoint::insert($point_insert);
			$notoficationStatus = DB::table('users')->where('email',auth()->user()->email)->first();
					if(!empty($notoficationStatus))
					{
						if($notoficationStatus->go_online!="false")
						{
							Mail::to(auth()->user()->email)->send(new DebateJoined()); // mail send to own email on joining
						}
					}


            return redirect('debates/'.$debate_id);
        }
        Session::flash('message', "Someone already Joined!!!");
        return redirect('debates/'.$debate_id);
    }


    // join to debate internal use
    private function join_debate_extension($debate_id, $debate_arguments){

        $sql    = DebateUser::where('debate_id', $debate_id);
        if($sql->count() < 2){
            $user_debate = DebateUser::where('debate_id', $debate_id)->first();
            if($user_debate->side == 'Agree'){
                $user_side = "Disagree";
            }else{
                $user_side = "Agree";
            }
            if($user_debate->user_id != auth()->user()->id ){
                DebateUser::insert(array('user_id' => auth()->user()->id,
                        'side'=>$user_side,
                        'debate_id' => $debate_id,
                        'votes' => '0')
                    );
                $debate = Debate::findOrFail($debate_id);
                $debate->status ="active";
                if($debate->save()){
                    DebateArgument::insert(array('debate_id'=>$debate_id,
                        'user_id'=>auth()->user()->id,
                        'argument'=>$debate_arguments,
                        'created_at'=>Carbon::now()
                    ));
                    return true;
                }
            }
            return false;
        }else{
            return false;
        }
    }

}
