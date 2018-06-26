<?php

namespace App\Http\Controllers\Game\Debates\Arguments;

use App\Debate;
use App\DebateArgument;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ArgumentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Debate $debate)
    {
        return $debate->arguments()->get();
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
        //print_r(json_decode(json_encode($request->input())));
        
        $fingerprint_string = $request->input('fingerprint_string');
        $event_type = 'give_argument';
        $event_id   =  $debate->id;
        $points     = '10';
        $visitor_id = auth()->id();

        $already_exist = DebateArgument::where('debate_id',  $debate->id)->where('user_id', auth()->id())->count();
        if($already_exist == '0'){
            // insert new point
            if($this->add_point_once($fingerprint_string, $event_type, $event_id, $points, $visitor_id)){
                //echo "ok";
            }
        }
        $argument = DebateArgument::create([
            'debate_id' => $debate->id,
            'user_id' => auth()->id(),
            'argument' => request('message'),
        ]);
        return $argument->load('user');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(DebateArgument $d)
    {
        return $d->first();
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
