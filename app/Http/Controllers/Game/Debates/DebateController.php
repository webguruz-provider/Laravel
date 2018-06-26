<?php

namespace App\Http\Controllers\Game\Debates;

use App\Debate;
use App\DebateUser;
use App\DebateCategory;
use App\DebateArgument;
use App\DebateCategoryUser;
use App\Question;
use App\User;
use App\Follower;
use DB;
use Session;

//use App\Mail\Invite;
//use App\Mail\Challenge;

//use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;

use App\Helpers\DebateUsers;
//use Illuminate\Mail\Mailable;
//use Illuminate\Support\Facades\Mail;


//use App\Helpers\Points;

class DebateController extends Controller
{


    public function __construct()
    {
        $this->middleware(['auth','frontuser'], ['except' => 'show']);
    }



    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    // pick a question
    public function index()
    {
        $questions = DB::table('questions')
            ->join('debate_category', 'debate_category.id', '=', 'questions.category_id')
            ->select('questions.*', 'debate_category.name')
            ->take(10)->get();
        $categories = DebateCategory::all();
        return view('game.debates.index', compact('questions','categories'));
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

    public function show(Debate $debate)
    {

        if(auth::check()){
            if(Auth::user()->is_admin == 1){
                return redirect()->route('partnerQuestionActivity');
            }else{
               
                $userDebate = new DebateUsers();
                $debate = $debate->load(['arguments', 'users', 'arguments.user', 'comments', 'votes','getDebatequestion.getquestionAuther']);
                
                if($debate['question']['ads_id'] == 0){
                    $debate = $debate->load(['arguments', 'question.category.ads', 'users', 'arguments.user', 'comments', 'votes','getDebatequestion.getquestionAuther']);
                }else{
                    $debate = $debate->load(['arguments', 'question.ads', 'users', 'arguments.user', 'comments', 'votes','getDebatequestion.getquestionAuther']);
                }
                // echo "<pre>";
                // print_r($debate);
                // exit;
                $followUsers = User::where('is_admin',0)->where('id', '!=' , Auth::user()->id)->get();
                
                $following_user = User::with('followings.followedUser')->where('id', auth()->user()->id )->first();
                $my_sided_network = $following_user->followings;
                $debate_user = $userDebate->get_user($debate->id);
                return view('game.debates.show', compact('debate', 'my_sided_network', 'debate_user', 'followUsers'));
            }
        }else{

            $debate = $debate->load(['arguments', 'users', 'arguments.user', 'comments', 'votes','getDebatequestion.getquestionAuther']);
            
            return view('game.debates.shownonlogin', compact('debate'));
        }
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
    
    public function debate_sharebox(){
        Session::put('shareboxdebate', 'hidden');
        return response()->json(['response_code'=>'0', 'response'=>'hidden', 'status'=>'success']);  
    }    

}
