<?php

namespace App\Http\Controllers\Partner\Answers;

use Auth;
use Session;
use App\Answer;
use App\Question;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
class AnswerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($id)
    {
        $hasQuesAuthorCount = Question::whereId($id)->where('user_id', Auth::user()->id)->count();
        if($hasQuesAuthorCount == 1){
            $answers = Answer::where('question_id',$id)->orderBy('id','DESC')->get();
            return view('admin.answers.index', compact('answers'));
        }else{
            return view('errors.pro-404');
        }
    }
    public function create(){
        //
    }
    public function store(Request $request){
        $ans = Answer::create([
            'question_id' => $request->get('question_id'),
            'answer' => $request->get('answer')
        ]);
        if($ans){
            Question::where('id', $request->get('question_id'))->update(['has_multiple_ans' => 0]);
            Session::flash('message', "Answer created successfully.");
        }else{
            Session::flash('message', "Error!. Please try again.");
        }
        return redirect()->back();
    }
    public function edit(){
        //
    }
    public function update(Request $request){
        $updateAns = Answer::where('id', $request->get('ans_id'))->update(['answer' => $request->get('answer')]);
        if($updateAns){
            Session::flash('message', "Answer updated successfully.");
        }else{
            Session::flash('message', "Error!. Please try again.");
        }
        return redirect()->back();
    }
    public function delete(Request $request){
        if($request->get('submit') == 'yes'){
            $deletedAns = Answer::where('id', $request->get('ans_id'))->delete();
            if($deletedAns){
                $ansCount = Answer::where('question_id', $request->get('question_id'))->count();
                if($ansCount == 0){
                    Question::where('id', $request->get('question_id'))->update(['has_multiple_ans' => 1]);
                }
                Session::flash('message', "Answer deleted successfully.");
            }else{
                Session::flash('message', "Error!. Please try again.");
            }
            return redirect()->back();
        }else{
            return redirect()->back();
        }
    }
}
