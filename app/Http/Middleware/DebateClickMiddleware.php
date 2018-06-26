<?php

namespace App\Http\Middleware;

use Closure;
use App\Impression;
use App\Question;
use App\QuestionStats;
use Carbon\Carbon;

use Illuminate\Support\Facades\Auth;

class DebateClickMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::check()){

            // question impression (on debate page as per discussion not question click is counted any)
            // after 5 mintues impression increased for same question 
            $question = Question::findOrfail($request->debate->question->id);
            if ($question) {
                $question_stats = QuestionStats::where('question_id',$request->debate->question->id)
                                ->where('event_type','impression')
                                ->where('visitor_id', Auth::user()->id)
                                ->orderBy('created_at', 'desc')
                                ->first();

                if($question_stats){
                    $to = \Carbon\Carbon::now();
                    $from = $question_stats->created_at;
                    $diff_in_minutes = $to->diffInMinutes($from);

                    if($diff_in_minutes > 5){
                        QuestionStats::create([
                            'question_id'=>$request->debate->question->id,
                            'event_type'=>'impression',
                            'visitor_id'=>Auth::user()->id
                        ]);
                    }
                }else{
                    QuestionStats::create([
                        'question_id'=>$request->debate->question->id,
                        'event_type'=>'impression',
                        'visitor_id'=>Auth::user()->id
                    ]);
                }
            }
            
            // for debate impressions (not for question)
            Impression::create(['debate_id'=>$request->debate->id,'question_id'=>$request->debate->question_id, 'visitor_id'=>Auth::user()->id]);

        }else{
            
            // here need to send impression of question again with fingerprint string
            $this->addImpression($request->debate->question_id);

            
            // debate impressions
           Impression::create(['debate_id'=>$request->debate->id,'question_id'=>$request->debate->question_id, 'visitor_id'=>NULL]);

        }
        return $next($request);
    }



    
    public function addImpression($question_id){
        $fstring = session()->get('fingerprint_string');
        $question = Question::findOrfail($question_id);

        if ($question && !empty($fstring)) {
            $question_stats = QuestionStats::where('question_id',$question_id)
                            ->where('event_type','impression')
                            ->where('visitor_id', NULL)
                            ->where('fingerprint_string', $fstring)
                            ->orderBy('created_at', 'desc')
                            ->first();

            if($question_stats){
                $to = Carbon::now();
                $from = $question_stats->created_at;
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes > 5){
                    QuestionStats::create([
                        'question_id'=> $question_id,
                        'event_type'=>'impression',
                        'visitor_id'=> NULL,
                        'fingerprint_string' => $fstring
                    ]);
                }
            }else{
                QuestionStats::create([
                    'question_id'=>$question_id,
                    'event_type'=>'impression',
                    'visitor_id'=> NULL,
                    'fingerprint_string' => $fstring
                ]);
            }
        }
        return true;

    }

}
