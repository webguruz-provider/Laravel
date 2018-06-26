<?php

namespace App\Http\Controllers\Game\Players;

use App\User;
use App\Follower;
use App\Debate;
use App\DebateUser;
use App\DebateCategory;
use App\UserPoint;
use App\Fingerprint;
use App\Contest;

use App\DebateCategoryUser;
use App\ContestStats;

use DB;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\Helpers\Points;

use App\Mail\Offerfeedback;
use App\Mail\Proposequestion;
use Carbon;

use Exception;
use Session;
use Validator;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class PlayerController extends Controller
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($handle)
    {
        $category_obj = new DebateCategory;
        $categories = $category_obj->where('status', 'live')->get();

        $handle_obj = new User;
        $user = $handle_obj->where('handle', $handle)->first();
        $prousers = $handle_obj->where('is_admin', 1)->get();


        $contests = Contest::where('publish_at', '<=', Carbon\Carbon::now())->where([['expire_at', '>=', Carbon\Carbon::now()], ['partner_id', '=', $user->id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')->get();


        $userpoints = DB::select('select year(created_at) as y, month(created_at) as m, sum(points) as p from user_points where visitor_id = "'.$user->id.'" group by year(created_at), month(created_at)');

        $obj = new Fingerprint;
        $sql_points = $obj->with('user_points')->where('user_id', $user->id);
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

        $follower_count = Follower::where('user_id',$user->id)->where('status', 'follow')->count();

        $_debateObj = new DebateUser();
        $debates1 = $_debateObj->where('user_id', $user->id)->select('debate_id')->get();
        $my_debate_ids = array();
        
        foreach($debates1 as $debate){
            $my_debate_ids[] = $debate['debate_id'];
        }

        $debates = Debate::whereIn('id',$my_debate_ids)->orderby('id','desc')->get();

        if(!empty(Auth::user()->id)){
            
            // earn point after visit
            if($user->id != Auth::user()->id ){
                $points = new Points;
                $points->add_points(1, Auth::user()->id); // arg 1 for type of point; arg 2 who get these points
            }
            
            $followerid = Auth::user()->id;
            $follower = Follower::where('user_id',$user->id)->where('followerid', $followerid)->first();

            $is_fav_view = '0';
            $is_favourite = '0';

            if($follower){
                
                $is_favourite = $follower->is_favourite;

                if($follower->status == 'follow'){
                    $is_fav_view = '1';
                    $action = route('followers.update', $follower->id);
                    $method = "PUT";
                    $btn_text = "Unfollow";
                    $status ="unfollow";
                }else{
                    $is_fav_view = '0';
                    $action = route('followers.update', $follower->id);
                    $method = "PUT";
                    $btn_text = "Follow";
                    $status ="follow";
                }
            }else{
                $is_fav_view = '0';
                $action = route('followers.store');
                $method = "POST";
                $btn_text = "Follow";
                $status = "follow";

            }
            return view('game.players.show', compact('user','method','action', 'btn_text', 'status','follower_count','debates', 'is_fav_view', 'is_favourite','total_points','categories','prousers','userpoints','contests'));
        }else{

            return view('game.players.show', compact('user','follower_count','debates','total_points'));

            // return view('game.players.nonlogin', compact('user','follower_count'));
            // die('non login user');
        }
        // return view('game.players.show', compact('user','follower_count','debates'));
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
	
	/**
     * propose question mail.
     *
     * @param  int  $email
     * @return \Illuminate\Http\Response
     */
    public function proposequestionemail(Request $request)
    {
		try{
			
        Mail::to($request->pro_email)->send(new Proposequestion());
            
        Session::flash('message', "Propose question successfully sent.");
         return redirect('feed');
		 }catch(\Exception $e){
            DB::rollback();

            echo $e->getMessage().' on line number in store debate '.$e->getLine();

            die($e->getMessage());
        }
    }
	
	/**
     * feedback mail.
     *
     * @param  int  $email
     * @return \Illuminate\Http\Response
     */
    public function offerfeedbackemail(Request $request)
    {
		
        try{
        Mail::to($request->pro_email)->send(new Offerfeedback());
            
        Session::flash('message', "Offerfeedback successfully sent.");
        
         return redirect('feed');
		 }catch(\Exception $e){
            DB::rollback();

            echo $e->getMessage().' on line number in store debate '.$e->getLine();

            die($e->getMessage());
        }
    }
    


    // not in use currently
    public function contests($player_id){
        //print_r($player_id);
        $query = User::where('id',$player_id)->where('is_admin', '1');
        if($query->count() > 0){
            $contests = Contest::where('publish_at', '<=', Carbon\Carbon::now())->where([['expire_at', '>=', Carbon\Carbon::now()], ['partner_id', '=', $player_id], ['status', '!=', 'draft'],])->where('status', '!=', 'deactive')->get();
            return view('game.contests.show', compact('contests'));
        }else{
            return view('errors.404');    
        }
    }



    function showChangePasswordForm(){
        return view('auth.changepassword');
    }


    public function changePassword(Request $request){
 
        if (!(\Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
            return redirect()->back()->with("error","Your current password does not matches with the password you provided. Please try again.");
        }
 
        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            //Current password and new password are same
            return redirect()->back()->with("error","New Password cannot be same as your current password. Please choose a different password.");
        }
 
        $validatedData = $this->validate($request, [
            'current-password' => 'required',
            'new-password' => 'required|string|min:6|confirmed',
        ]);
        
        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();
 
        return redirect()->back()->with("success","Password changed successfully !");
 
    }


	
    /*My category and update category*/
    public function myCategory(){
        $catId = array();
        $myCategories = DebateCategoryUser::where('user_id',Auth::user()->id)->get();
        if(count($myCategories)){
            foreach ($myCategories as $cat) {
                array_push($catId, $cat->category_id);
            }
        }
        $categories = DebateCategory::where('status','live')->orderBy('name', 'asc')->get();
        return view('game.players.my-category', compact('categories','catId'));
    }
    public function updateMyCategory(Request $request){
        if($request->get('status') == 'save'){
            $newCategory = DebateCategoryUser::create([
                'category_id' => $request->get('cat_id'),
                'user_id' => Auth::user()->id
            ]);
            if($newCategory){
                return 'success';
            }else{
                return 'error';
            }
        }else{
            $delteCategoty = DebateCategoryUser::where('category_id', $request->get('cat_id'))->where('user_id',Auth::user()->id)->delete();
            if($delteCategoty){
                return 'success';
            }else{
                return 'error';
            }
        }
    }

	

    // increment contest clicks 
    // only unique user 
    // one user / one click / one contest / one event type
    public function contestClick($contestID){
        $contest_detail = Contest::findOrFail($contestID);
        if($contest_detail){
            $contestStats = ContestStats::where('contest_id', '=', $contestID)
                                ->where('visitor_id','=',Auth::user()->id)
                                ->where('event_type','=','click')
                                ->first();
            if(!$contestStats){
                // insert new click entry 
                ContestStats::insert(array('visitor_id' => Auth::user()->id,
                    'contest_id'=>$contestID,
                    'event_type' => 'click',
                    'created_at' => Carbon\Carbon::now()
                ));
            }

            return redirect()->away($contest_detail->website_url);
            //echo "<pre>";
            //print_r($contestStats);
            
        }
    }

   
	
}
