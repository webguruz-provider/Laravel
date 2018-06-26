<?php

namespace App\Http\Controllers\Game\Dashboard;

use App\Activity;
use App\Debate;
use App\DebateUser;
use App\Question;
use App\User;
use App\Follower;
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

class DashboardController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('onboarded');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {   
        try{
            $expired = Question::where('expire_at','<',Carbon::now())->get();
            foreach($expired as $expire){
                // update debate status where question id = exired question id
                Debate::where('question_id', $expire->id)
                        ->where('status', 'active')
                        ->update(['status'=>'closed']);
            }
          
           // $myCategories = DebateCategoryUser::groupBy('category_id')->pluck('category_id')->where('user_id',Auth::user()->id)->all();
            $myCategories = DebateCategoryUser::where('user_id',Auth::user()->id)->pluck('category_id')->toArray();
            $catAssociatedQuestionId = Question::whereIn('category_id', $myCategories)->pluck('id')->toArray();
        
            $debates = Debate::whereIn('question_id', $catAssociatedQuestionId)->where('starts_at', '<=', Carbon::now())->where([['ends_at', '>=', Carbon::now()], ['status', '!=', 'completed'],])->take(2)->orderby('created_at', 'desc')->get();
           /* echo "<pre>";
            print_r($debates);
            exit;*/
           
            $usedQuesIds = DebateUser::where('user_id', Auth::user()->id)->groupBy('question_ID')->pluck('question_ID')->all();
            

            $usedQuesIdsForAns = UserAnswer::where('user_id', Auth::user()->id)->groupBy('question_id')->pluck('question_id')->all();
            $questions = Question::with('category','getquestionAuther','userAnswer')->whereIn('category_id', $myCategories)->publicLive()->whereNotIn('id', $usedQuesIds)->whereNotIn('id', $usedQuesIdsForAns)->where('has_multiple_ans',0)->limit(3)->orderby('id', 'desc')->get();
            /*echo "<pre>";
            print_r($questions);
            exit;*/
            $serveyQuestions = Question::with('category','getquestionAuther')->whereIn('category_id', $myCategories)->publicLive()->whereNotIn('id', $usedQuesIdsForAns)->where('question_type',1)->take('3')->get();
            
            //$activities = Activity::all();            
            $obj_user = new User();
            $follow_suggestions = $obj_user->follow_suggestion(auth()->user()->id);
            $prousers = $obj_user->where('is_admin', 1)->get();
            $active_users = $obj_user->where('is_admin', '1')->where('id', '!=', auth()->user()->id)->take(6)->orderBy('go_online', 'true')->get();

            $active_users_online = $obj_user->where('is_admin', '1')->where('go_online','true')->get();
            
            $obj_category = new DebateCategory();
            $categories = $obj_category->where('status','live')->get();

            $ads = Ad::dashboardAds()->get();

            return view('game.dashboard.index', compact('questions', 'serveyQuestions', 'debates', 'follow_suggestions','categories','active_users','prousers','ads','active_users_online'));

        }catch(Exception $e){
            $msg = $e->getMessage();
            return view('errors.404', compact('msg'));
        }
    }

    /*
    * Load more suggest questions 
    *
    */
    public function loadDataAjax(Request $request)
    {

        $output = '';
        $id = $request->id;
        
        $myCategories = DebateCategoryUser::where('user_id',Auth::user()->id)->pluck('category_id')->toArray();
         $usedQuesIds = DebateUser::where('user_id', Auth::user()->id)->groupBy('question_ID')->pluck('question_ID')->all();

            $usedQuesIdsForAns = UserAnswer::where('user_id', Auth::user()->id)->groupBy('question_id')->pluck('question_id')->all();
            $questions = Question::with('category','getquestionAuther','userAnswer')->whereIn('category_id', $myCategories)->publicLive()->whereNotIn('id', $usedQuesIds)->whereNotIn('id', $usedQuesIdsForAns)->where('has_multiple_ans',0)->where('id','<',$id)->limit(3)->orderby('id', 'desc')->get();
        
        if(!$questions->isEmpty())
        {
            foreach($questions as $question)
            {
                if($question->question_type==0)
                {
                    $b = '<a class="debate-btn" href="../debates/pickaside?question_id='.$question->id.'">Start Debate</a>';
                }else{
                    $b = '<a class="debate-btn" href="../servey/pickanswer?question_id='.$question->id.'">Submit Answer</a>';
                }
                $output .= '<div class="dashboard-item">
        <div class="debate-preview u-background-white">
        <div class="debate-preview__header">
                            <div class="debate-haeder-top">
                                <h4 class="debate-preview__category"> Submitted In <strong class="u-text-black">'.$question->category->name.'</strong></h4>
                                <h5 class="debate-preview__category"> Submitted By <strong class="u-text-black">
                                <a href="../players/'.$question->getquestionAuther->name.'">'.$question->getquestionAuther->name.'</a>
                                </strong></h5>

                            </div>
                            <p class="debate-preview__question-text">'.$question->text.'</p>

                            <small class="debate-preview__question-source">
                                <i class="fa fa-circle" aria-hidden="true"></i>'.$question->medium.'from 
                                <strong class="u-text-black">'.$question->source.'</strong>
                              </small>
                              <div class="debate-btn-box">'.$b.'</div>
                        </div>
						</div></div>';
            }
            $output .= '<div id="remove-row">
                            <button id="btn-more" data-id="'.$question->id.'" class="debate-btn nounderline btn-block mdl-button mdl-js-button mdl-button--raised mdl-js-ripple-effect mdl-button--accent" > Load More </button>
                        </div>';
            
            echo $output;
        }
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



    public function load_follow_suggestion(){
        $user = new User();
        $follow_suggestions = $user->follow_suggestion(auth()->user()->id);
        if(count($follow_suggestions) > 0){
            return response()->json(['response_code'=>'1', 'response'=>$follow_suggestions, 'status'=>'success']);  

        }else{
            return response()->json(['response_code'=>'0', 'response'=>'No more suggesstion.', 'status'=>'success']);    
        }
    }



    public function share_box(){
        Session::put('sharebox', 'hidden');
        return response()->json(['response_code'=>'0', 'response'=>'hidden', 'status'=>'success']);  
    }    
}
