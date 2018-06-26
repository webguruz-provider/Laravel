<?php

namespace App\Http\Controllers\Game\Debates;

use App\Question;
use App\DebateCategory;
use App\Debate;
use App\DebateUser;
use App\DebateArgument;
use App\UserPoint;
use App\Fingerprint;

use App\Mail\DebateCreated;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Carbon\Carbon;
use Validator;
use Session;
use DB;

use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;


class DebateOnboardingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // start debate step 1
    public function index()
    {
        
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //echo "jk"; exit;
        $questions = Question::with('category')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '=', 'publish'],])->orderby('id', 'desc')->get();
        $categories = DebateCategory::where('status', '=', 'live')->get();
        return view('game.debates.create', compact('questions','categories'));

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
            DB::beginTransaction();

            $start_dt = Carbon::now();
            $lday = Carbon::now();
            $ldate = $lday->addDays(1);
            
            $v = Validator::make($request->all(), [
                'side'=>'required',
                'question_id' => 'required',
                'argument' => 'required',
            ]);

            if ($v->fails())
            {
                return redirect()->back()->withErrors($v->errors())->withInput($request->all());
            }

            if(auth()->user()->id !=''){
                $debate = Debate::create([
                    'question_id'=>$request->input('question_id'),
                    'status'=>'needs_opponent',
                    'starts_at'=>$start_dt,
                    'ends_at'=>$ldate
                ]);

                if($debate){
                    DebateUser::insert(array('user_id' => auth()->user()->id,
                        'side'=>$request->input('side'),
                        'debate_id' => $debate->id,
                        'question_ID' => $request->input('question_id'),
                        'votes' => '0')
                    );

                    DebateArgument::insert(array('debate_id'=>$debate->id,
                        'user_id'=>auth()->user()->id,
                        'argument'=>$request->input('argument'),
                        'created_at'=>$start_dt
                    ));

                    $fingerprint_string = $request->input('fingerprint_string');
                    $this->add_point(auth()->user()->id,$fingerprint_string, 'give_argument', $debate->id,'10');

                    $this->add_point(auth()->user()->id,$fingerprint_string, 'debate_start', $debate->id,'25');

                    //Mail::to(auth()->user()->email)->send(new DebateCreated($debate, auth()->user())); 

                    /*$f_query = Fingerprint::where('user_id', auth()->user()->id)
                                    ->where('fingerprint_string', $request->input('fingerprint_string'));
                    
                    $point_insert = array('event_type'=>'debate_start', 'event_id'=>$debate->id,'visitor_id'=>auth()->user()->id, 'points'=>'25', 'created_at'=>$start_dt);

                    if($f_query->count() > 0){
                        $data = $f_query->first();
                        $point_insert['fingerprint_id'] = $data->id;
                    }else{

                        $fingerprint_id = Fingerprint::insertGetId(['fingerprint_string'=>$request->input('fingerprint_string'), 'user_id'=>auth()->user()->id, 'created_at'=>Carbon::now() ]);
                        $point_insert['fingerprint_id'] = $fingerprint_id;
                    }
                    UserPoint::insert($point_insert);
                    */



                }else{
                    throw new Exception("Error Processing Request");
                }
            }
            DB::commit();


            return redirect('debates/'.$debate->id);
        }catch(\Exception $e){
            DB::rollback();

            echo $e->getMessage().' on line number in store debate '.$e->getLine();

            die($e->getMessage());
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



    function pick_your_side(Request $request){

        $question = Question::with('category','getquestionAuther')
                        ->where('id',$request->input('question_id'))
                        ->first();
                       /* echo "<pre>";
        print_r($question->getquestionAuther->name);
        exit;*/
        if($question->count() > 0){
            return view('game.debates.pickaside', compact('question'));    
        }
        else
        {
            die('question not found');
        }
    }



    // ajax call from game layout
    public function get_question_by_category(Request $request){
        /*$questions = Question::with('category')
                        ->where('category_id', $request->input('category_id'))
                        ->get();*/

         $questions = Question::with('category.ads','getquestionAuther')->where('publish_at', '<=', Carbon::now())->where([['expire_at', '>=', Carbon::now()], ['status', '=', 'publish'],])->where('category_id', $request->input('category_id'))->orderby('id', 'desc')->get();
        return response()->json($questions);
    }




}
