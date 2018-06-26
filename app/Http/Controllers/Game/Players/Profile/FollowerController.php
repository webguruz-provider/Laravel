<?php

namespace App\Http\Controllers\Game\Players\Profile;

use App\Follower;

use App\Activity;
use App\Debate;
use App\Question;
use App\User;
use App\DebateCategory;
use App\Ad;
use App\DebateCategoryUser;
use App\UserAnswer;
use Carbon\Carbon;
use Auth;
use Exception;
use Session;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
//use Illuminate\Support\Facades\Auth;

class FollowerController extends Controller
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
        //
        $filling_array = array(
            'followerid'=>Auth::user()->id,
            'user_id' => $request->user_id,
            'status' => $request->status,
            'is_favourite' =>'0');
            
        Follower::create($filling_array);
        return \Redirect::back()->withSuccess( 'Details Successfully updated' );
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
    public function update(Request $request, Follower $follower)
    {
        //
        $request->offsetUnset('_method');
        $request->offsetUnset('follow');

        Follower::where('id', $follower->id)->update($request->all());
        return \Redirect::back()->withSuccess( 'Details Successfully updated' );
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

    

    // using ajax call 
    public function follow(Request $request){
        $followerid = Auth::user()->id;

        $follower  = Follower::where('user_id',$request->input('user_id'))->where('followerid', $followerid)->first();

        if($follower){

            if($follower->status == 'follow'){
                $status ="unfollow";
            }else{
                $status ="follow";
            }
            
            Follower::where('id', $follower->id)->update(['status'=>$status]);
            return response()->json(['response'=> ucfirst($status).' successfully!!', 'status'=>'success']);

        }else{
            $filling_array = array(
                'followerid'=>Auth::user()->id,
                'user_id' => $request->user_id,
                'status' => 'follow');
            
            Follower::create($filling_array);
			
			$user = new User();
			$follow_suggestions = $user->follow_suggestion(auth()->user()->id);
			if(count($follow_suggestions) > 0)
			{
				return response()->json(['response_code'=>'1', 'response'=>$follow_suggestions, 'status'=>'success']);  
			}
			else
			{
				return response()->json(['response_code'=>'0', 'response'=>'No more suggesstion.', 'status'=>'success']);    
			}
		
            //return response()->json(['response'=>'Follow successfully!!', 'status'=>'success']);

        }
        return response()->json(['response'=>'Something wrong', 'status'=>'error']);
        
    }



    // using ajax call 
    public function make_favorite(Request $request){

        $followerid = Auth::user()->id;
        $follower  = Follower::where('user_id',$request->input('user_id'))->where('followerid', $followerid)->first();

        if($follower){
            if($follower->is_favourite == '0'){
                $status ="1";
                $msg = "Sided added in your Favorite list.";
            }else{
                $status ="0";
                $msg = "Sided removed from your Favorite list.";
            }
            
            Follower::where('id', $follower->id)->update(['is_favourite'=>$status]);
            return response()->json(['response'=> $msg, 'status'=>'success', '_code'=>$status]);
        }else{
            $filling_array = array(
                'followerid'=>Auth::user()->id,
                'user_id' => $request->input('user_id'),
                'status' => 'unfollow',
                'is_favourite'=>'1'
            );
            
            Follower::create($filling_array);
            return response()->json(['response'=>'Sided added in your Favorite list.', 'status'=>'success','_code'=>'1']);
        }

        
    }






}
