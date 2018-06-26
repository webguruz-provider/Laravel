<?php

namespace App\Http\Controllers\Game\Serveys;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Question;
use App\UserServey;
use App\UserAnswer;
use App\Answer;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ServeyController extends Controller
{
    public function index(Request $request){
        $question = Question::with('category','getquestionAuther', 'answer')->where('id',$request->input('question_id'))->first();
       if($question->ads_id >= 1){
            $ads = Question::where('id',$request->input('question_id'))->with('ads')->first();
       }else{
            $ads = Question::where('id',$request->input('question_id'))->with('category.ads')->first();
       }
       
        $answerSubmittedByUser = UserAnswer::where('user_id', Auth::user()->id)->where('question_id', $request->input('question_id'))->count();
        if($answerSubmittedByUser >= 1){
            return redirect('/feed');
        }else{
            if($question->count() > 0){
                $hasVisited = UserServey::where('question_id', $request->input('question_id'))->where('user_id', Auth::user()->id)->first();
                if(count($hasVisited) == 0){
                    $userServey = $this->visitedServeyStatus(Auth::user()->id,$request->input('question_id'),0);
                    return view('game.serveys.pickaservey', compact('question', 'userServey', 'ads')); 
                }else{
                   $userServey = $hasVisited;
                    return view('game.serveys.pickaservey', compact('question', 'userServey', 'ads'));
                }     
            }
            else
            {
                die('question not found');
            }
        }
    }
    private function visitedServeyStatus($userId, $questionId, $serveyId){
        if($serveyId == 0){
            $servey = UserServey::create([
                'user_id' => $userId,
                'question_id' => $questionId,
                'status' => 0
            ]);
        }else{
            $servey = UserServey::where('id', $serveyId)->update(['status' => 1]);
        }
        return $servey;
    }
    public function singleServeyAnswer(Request $request){
        $question = Question::find($request->get('question_id'));
        if($request->has('answer_id')){
            $serveyAns = UserAnswer::create([
                'user_id' => Auth::user()->id,
                'question_id' => $request->get('question_id'),
                'answer_id' => $request->get('answer_id')
            ]);
            if($serveyAns){
                $this->visitedServeyStatus(Auth::user()->id,$request->input('question_id'),$request->input('servey_id'));
                if($question->instant_result == 1){
                    return redirect()->route('serVeyInstantResult',$request->get('question_id'));
                }else{
                    return redirect()->route('serveyAnsSubmitThankyou',$request->get('question_id'));
                }
            }else{
                echo "Error";
                exit;
            }
        }else{
            if($request->get('other_answer') == 1){
                $serveyAns = UserAnswer::create([
                    'user_id' => Auth::user()->id,
                    'question_id' => $request->get('question_id'),
                    'other_answer_text' =>  $request->get('other_answer_text')
                ]);
                $this->visitedServeyStatus(Auth::user()->id,$request->input('question_id'),$request->input('servey_id'));
                if($question->instant_result == 1){
                    return redirect()->route('serVeyInstantResult',$request->get('question_id'));
                }else{
                    return redirect()->route('serveyAnsSubmitThankyou', $request->get('question_id'));
                }
            }else{
                echo "Error"; exit;
            }
        }
    }
    public function multipleServeyAnswer(Request $request){
       $question = Question::find($request->get('question_id'));
        if($request->has('answer_id')){
            foreach($request->get('answer_id') as $ansId){
                $serveyAns = UserAnswer::create([
                    'user_id' => Auth::user()->id,
                    'question_id' => $request->get('question_id'),
                    'answer_id' =>  $ansId
                ]);
            }
            $this->visitedServeyStatus(Auth::user()->id,$request->input('question_id'),$request->input('servey_id'));
            if($question->instant_result == 1){
                return redirect()->route('serVeyInstantResult',$request->get('question_id'));
            }else{
                return redirect()->route('serveyAnsSubmitThankyou', $request->get('question_id'));
            }
        }else{
            if($request->get('other_answer') == 1){
                $serveyAns = UserAnswer::create([
                    'user_id' => Auth::user()->id,
                    'question_id' => $request->get('question_id'),
                    'other_answer_text' =>  $request->get('other_answer_text')
                ]);
                $this->visitedServeyStatus(Auth::user()->id,$request->input('question_id'),$request->input('servey_id'));
                if($question->instant_result == 1){
                    return redirect()->route('serVeyInstantResult',$request->get('question_id'));
                }else{
                    return redirect()->route('serveyAnsSubmitThankyou', $request->get('question_id'));
                }
            }else{
                echo "Error"; exit;
            }
        }
    }
    public function getInstantResult($question_id){
        $colorArrays = ['#28a745', '#5873fe', '#e7b63a', '#323232', '#004bbc', '#41cac0', '#9972b5', '#ff6c60', '#57c8f2', '#343957', '#82b440', '#dddddd', '#00bfff', '#804000'];
        //$userCount = UserAnswer::where('question_id',5)->count();
        // $serveyresults =UserAnswer::select('answer_id', DB::raw('count(*) as total'))
        //               ->groupBy('answer_id')->with('answer')
        //               ->where('question_id',5)
        //               ->get();
        $hasServeySubmittedUserCout = UserAnswer::where('question_id', $question_id)->where('user_id', Auth::user()->id)->count();
        $questionDetails = Question::find($question_id);
        $otherAnswersCount = UserAnswer::where('question_id',$question_id)->where('answer_id',NULL)->count();
        $answered = UserServey::where('question_id',$question_id)->where('status',1)->count();
        $skipped = UserServey::where('question_id',$question_id)->where('status',0)->count();
        $serveyResults = Answer::with('serveyAnswers')->where('question_id',$question_id)->get();
        if($hasServeySubmittedUserCout >= 1){
            return view('game.serveys.servey-result', compact('colorArrays', 'answered', 'skipped', 'serveyResults', 'otherAnswersCount', 'questionDetails')); 
        }else{
            return view('errors.404');
        }
    }
    public function thankyou($id){
        $hasServeySubmittedUserCout = UserAnswer::where('question_id', $id)->where('user_id', Auth::user()->id)->count();
        if($hasServeySubmittedUserCout >= 1){
            return view('game.serveys.thank-you');
        }else{
            return view('errors.404');
        }
    }
}
