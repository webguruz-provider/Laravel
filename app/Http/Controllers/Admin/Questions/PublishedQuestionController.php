<?php

namespace App\Http\Controllers\Admin\Questions;

use App\Question;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PublishedQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $questions = Question::get();
        $title = "All Questions";
        return view('admin.questions.index', compact('questions', 'title'));
    }
}
