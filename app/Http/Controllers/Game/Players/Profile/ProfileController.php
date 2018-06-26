<?php

namespace App\Http\Controllers\Game\Players\Profile;


use App\User;

use Validator;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
//use Image;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //

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
    public function store(User $user, Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
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
        // profile edit page
        return view('game.players.profile.edit');
        
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
        $id = auth()->id();
        $User = User::findOrFail($id);
        $this->validate($request, [
            'name' => 'required',
            'email' => [
                'required',
                Rule::unique('users')->ignore($id),
            ],
            'handle' => [
                'required',
                Rule::unique('users')->ignore($id),
                'regex:/^[a-zA-Z0-9_.]*$/'
            ]
        ]);
 
        $input = $request->all();
        if( $request->hasFile('avatar_url') ) {
            $image = $request->file('avatar_url');
            $input['avatar_url'] = time().'.'.$image->getClientOriginalExtension();

            // $destinationPath = public_path('/images/thumbnail');
            // $thumb_img = Image::make($image->getRealPath())->resize(80, 80);
            // $thumb_img->save($destinationPath.'/'.$input['avatar_url']);

            $destinationPath = public_path('/images');
            $image->move($destinationPath, $input['avatar_url']);
        }
        $User->fill($input)->save();
        return \Redirect::back()->withSuccess( 'Details Successfully updated' );
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
