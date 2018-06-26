<?php

namespace App\Http\Controllers\Partner\Questions;

use Auth;

use App\Question;
use App\UserPoint;
use App\Impression;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Questions\QuestionStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;


class LiveQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $filter = Input::get('filter_days'); // or using a Request instance

        if ($filter !== null)
        {
            // do something with my eloquent query builder that might involve the key
            // $model->where('someImportantFilter', '=', $filter); // like this

            
            $filter_text = Input::get('filter_text');
            if ($filter_text !== null && $filter_text != ''){
                $questions = Question::Published()->with('author', 'category', 'debates', 'debates.users', 'debates.arguments','debates.comments', 'debates.votes')
                            ->where('publish_at', '>=', Carbon::now()->subDays($filter))
                            ->where('text', 'like', '%' . Input::get('filter_text') . '%')
                            ->orderby('id', 'desc')->get();

            }else{
                $questions = Question::Published()->with('author', 'category', 'debates', 'debates.users', 'debates.arguments','debates.comments', 'debates.votes')
                            ->where('publish_at', '>=', Carbon::now()->subDays($filter))
                            ->orderby('id', 'desc')->get();

            }
            

        }else{
            $questions = Question::Published()->with('author', 'category', 'debates', 'debates.users', 'debates.arguments','debates.comments', 'debates.votes')->orderby('id', 'desc')->get();
        }
        //echo "<pre>";
        //print_r(json_decode(json_encode($questions)));


        //die('here');
        
        
        $user_enganged  = array();
        $impressions    = array();
        $clicks         = 0;
        $adClicks         = 0;
        $quesImp = 0;





        foreach($questions as $question){

            $clicks = (int)($clicks + $question->clicks()->count());
            $adClicks = (int)($adClicks + $question->AdClicks()->count());
            $quesImp = (int)($quesImp + $question->QuesImpressions()->count());

            $user_enganged[$question->id] = array();
            //$impressions[$question->id] = array();
            foreach($question->debates as $debate){
                //$particepent_users = json_decode(json_encode($debate->users));

                foreach($debate->users as $user){
                    $user_enganged[$question->id][] = $user->id;
                }

                if(is_object($debate->comments)){
                    foreach($debate->comments as $user){
                        $user_enganged[$question->id][] = $user->user_id;
                    }
                }

                if(is_object($debate->votes)){
                    foreach($debate->votes as $vote){
                        //print_r($vote);

                        $user_enganged[$question->id][] = $vote->voter_id;
                    }
                }

                

                //$impressions[$question->id][] = UserPoint::where('event_id', $debate->id)->where('event_type','debate_view')->count();
            }
            $impressions[$question->id] = Impression::where('question_id',$question->id)->count();

        }



        $total_impressions = $this->array_sum_recursive($impressions);
       /* echo "<pre>";
        print_r($user_enganged);
        die;*/




        //$questions = Question::with('author', 'category')->get();
        $title = "Questions";
        $view="live";
       
        return view('admin.questions.index', compact('questions', 'title','view', 'user_enganged','impressions', 'total_impressions', 'clicks','adClicks','quesImp'));
    }


    function array_sum_recursive($array)
    {
        $sum = 0;

        array_walk_recursive($array, function($item) use (&$sum) {
            $sum += $item;
        });

        return $sum;
    }



    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questions.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionStore $request)
    {
        Question::create([
            'user_id' => 1,
            'category_id' => 1,
            'name' => 'name',
            'text' => $request->text,
            'publish_at' => $request->publish_at,
            'expire_at' => $request->expire_at
        ]);
        return ['message' => 'Question Created'];
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Question $question)
    {
        return $question;
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
}
