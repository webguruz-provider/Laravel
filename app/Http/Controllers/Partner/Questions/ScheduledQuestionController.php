<?php

namespace App\Http\Controllers\Partner\Questions;

use App\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ScheduledQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::scheduled()->with('author', 'category')->orderby('publish_at', 'asc')->get();
        $title = "Questions";
        $view="scheduled";
        return view('admin.questions.scheduled', compact('questions', 'title','view'));
    }
}
 