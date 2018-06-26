<?php

namespace App\Http\Controllers\Partner\Questions;

use Auth;

use App\Question;
use App\Impression;
use Carbon\Carbon;


use Illuminate\Http\Request;
use App\Http\Requests\Admin\Questions\QuestionStore;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class DraftQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
         
        //$questions = Question::with('author', 'category')->get();
         $filter_text = Input::get('filter_text');
        if ($filter_text !== null && $filter_text != ''){
            $questions = Question::Draft()->with('author', 'category')
                        ->where('text', 'like', '%' . Input::get('filter_text') . '%')
                        ->orderby('id', 'desc')->get();

        }else{
           $questions = Question::Draft()->with('author', 'category')->get();
        }



        $title = "Questions";
        $view = "draft";

         $user_enganged  = array();
        $impressions    = array();
        

       foreach($questions as $question){
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

                //$impressions[$question->id][] = UserPoint::where('event_id', $debate->id)->where('event_type','debate_view')->count();
            }
            $impressions[$question->id] = Impression::where('question_id',$question->id)->count();

        }

        $total_impressions = $this->array_sum_recursive($impressions);

        return view('admin.questions.index', compact('questions', 'title','view','user_enganged','impressions', 'total_impressions'));
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
}
