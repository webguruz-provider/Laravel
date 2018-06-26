<?php

namespace App\Http\Controllers\Partner\Questions;

use App\Question;
use App\UserPoint;
use App\Impression;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class ExpiredQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // do something with my eloquent query builder that might involve the key
        // $model->where('someImportantFilter', '=', $filter); // like this
            
        $filter_text = Input::get('filter_text');
        if ($filter_text !== null && $filter_text != ''){

            $questions = Question::expired()->with('author', 'category')
                        ->where('text', 'like', '%' . Input::get('filter_text') . '%')
                        ->orderby('id', 'desc')->get();

        }else{
           $questions = Question::expired()->with('author', 'category')->get();

        }
        
        $title = "Questions";
        $view="expired";

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
}
