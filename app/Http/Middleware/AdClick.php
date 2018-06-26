<?php

namespace App\Http\Middleware;
use App\Question;
use App\QuestionStats;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdClick
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
        $question = Question::findOrfail($request->question_id);
        if ($question) {

            $question_stats = QuestionStats::where('question_id',$request->question_id)
                            ->where('event_type','click')
                            ->where('visitor_id', Auth::user()->id)
                            ->orderBy('created_at', 'desc')
                            ->first();

            if($question_stats){
                $to = \Carbon\Carbon::now();
                $from = $question_stats->created_at;
                $diff_in_minutes = $to->diffInMinutes($from);

                if($diff_in_minutes > 20){
                    QuestionStats::create([
                        'question_id'=>$request->question_id,
                        'event_type'=>'click',
                        'visitor_id'=>Auth::user()->id
                    ]);
                }
            }else{
                QuestionStats::create([
                    'question_id'=>$request->question_id,
                    'event_type'=>'click',
                    'visitor_id'=>Auth::user()->id
                ]);
            }
            
        }
        return $next($request);
    }
}
