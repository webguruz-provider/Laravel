<?php

namespace App\Http\Controllers\Game\Debates\Votes;

use Auth;
use Carbon\Carbon;
use App\Vote;
use App\DebateUser;

use Exception;
use Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class VoteController extends Controller
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
        try{
            if($request->isMethod('post')){

                
                $debate_id  = $request->input('debate_id');
                $user_id    = $request->input('user_id');
                $voter_id   = Auth::Id();

                $debateUsers = DebateUser::where('debate_id', $debate_id)
                        ->where('user_id', $voter_id)
                        ->count();
               
                if($debateUsers > 0){
                    throw new Exception("You can't vote on your own debate.","1"); 
                }else{
                    $checkVote = Vote::where('debate_id', $debate_id )
                        ->where('voter_id', $voter_id)
                        ->count();
                    // user vote already voted
                    if($checkVote > 0 ){
                        if($checkVote['user_id'] != $request->input('user_id')){
                            $this->switch_vote($debate_id, $user_id, $voter_id);
                        }else{
                            throw new Exception("Already voted","1"); 
                        }
                    }else{
                        $this->create_vote($request);
                    }
                }

                Session::flash('message', "Voted successfully!!");
                return response()->json(['response'=>'Voted successfully!!', 'status'=>'success']);

            }else{
                throw new Exception("Invalid Request");
            }
        }catch(Exception $e){
            if($e->getCode() =='23000'){
                return response()->json(['response' => 'You already voted on this debate', 'status'=>'error', 'code'=>$e->getCode()]);
            }else{
                return response()->json(['response' => $e->getMessage(), 'status'=>'error', 'code'=>$e->getCode()]);
            }
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

    /*
    Internal use methods
    */


    // switch vote
    private function switch_vote($debate_id, $user_id, $voter_id){


        //print_r($request->input('debate_id'));

        // create new debate in Votes table
        Vote::where('debate_id', $debate_id)
                    ->where('voter_id',$voter_id)
                    ->update(['user_id'=>$user_id]);


        // increment votes in Debate user account
        DebateUser::where('debate_id',$debate_id)
                    ->where('user_id',$user_id)
                    ->increment('votes');
        // decrement from other user vote
        DebateUser::where('debate_id',$debate_id)
                    ->where('user_id','!=',$user_id)
                    ->decrement('votes');
        
    }






    // create new vote
    private function create_vote($request){
        $debate_id  = $request->input('debate_id');
        $voter_id    = Auth::Id();
        $fingerprint_string = $request->input('fingerprint_string');

        // create new debate in Votes table
        Vote::create([
            'debate_id' => $request->input('debate_id'),
            'user_id' => $request->input('user_id'),
            'voter_id' => $voter_id,
            'created_at' => Carbon::now()
        ]);

        // increment votes in Debate user account
        DebateUser::where('debate_id',$request->input('debate_id'))
                    ->where('user_id',$request->input('user_id'))
                    ->increment('votes');

        $this->add_point($voter_id,$fingerprint_string, 'give_vote', $debate_id, '10');

        // UserPoint::create([]);
    }

    //vote by third user
    public function voteByThirdUser(Request $request){
       
        $debate_id = $request->input('debate_id');
        $voter_id = Auth::Id();
        $fingerprint_string = $request->input('fingerprint_string');
        $redirectUrl = $request->input('redirect_url');

        if($request->has('user_id')){
            if($request->input('user_id') == 'none'){
                return redirect($redirectUrl);
            }else{
                Vote::create([
                    'debate_id' => $debate_id,
                    'user_id' => $request->input('user_id'),
                    'voter_id' => $voter_id,
                    'created_at' => Carbon::now()
                ]);

                DebateUser::where('debate_id',$request->input('debate_id'))
                ->where('user_id',$request->input('user_id'))
                ->increment('votes');

                $this->add_point($voter_id,$fingerprint_string, 'give_vote', $debate_id, '10');
                Session::flash('message', "You have voted to selected user.");
                return redirect()->back();
            }
        }else{
            return redirect($redirectUrl);
        }
    }


}
