<?php

namespace App\Http\Controllers\Game\Debates\Comments;

use Auth;

use App\Debate;
use App\DebateComment;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Debate $debate)
    {
        return $debate->comments()->get();
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
    public function store(Debate $debate, Request $request)
    {

        $fingerprint_string = $request->input('fingerprint_string');
        $event_type = 'add_comment';
        $event_id   =  $debate->id;
        $points     = '10';
        $visitor_id = auth()->id();

        $already_exist = DebateComment::where('debate_id',  $debate->id)->where('user_id', auth()->id())->count();
        if($already_exist == '0'){
            // insert new point
            if($this->add_point_once($fingerprint_string, $event_type, $event_id, $points, $visitor_id)){
                // echo "ok comment";
            }
        }


        $comment = DebateComment::create([
            'debate_id' => $debate->id,
            'user_id' => Auth::Id(),
            'comment' => $request['message']
        ]);

        $comment->recordActivity('posted', $comment, Auth::Id());

        return $comment->load('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DebateComment $comment)
    {
        return $comment;
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
