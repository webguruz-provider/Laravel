<?php

namespace App\Http\Controllers\Partner\Profile;

use App\User;
use App\Ad;
use Validator;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Session;
use Illuminate\Support\Facades\Input;
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
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
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
       // echo "gfgf"; exit;
        $user = User::with('pro_ads')->whereId(Auth::user()->id)->first();
        $ads = Ad::where('partner_id', Auth::user()->id)->where('advertisement_type',3)->get();
        return view('partner.profile.proedit', compact('ads', 'user'));
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
       /* echo "<pre>";
        print_r($request->all());
        exit;*/
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
        if( $request->hasFile('background_img') ) {
            $image = $request->file('background_img');
            $input['background_img'] = time().'.'.$image->getClientOriginalExtension();

            $destinationPath = public_path('/images/pro_background');
            $image->move($destinationPath, $input['background_img']);
        }
        $User->fill($input)->save();
        return \Redirect::back()->withSuccess( 'Profile Successfully updated.' );
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
    public function attach_ads(){
        $attached_ads_id = Input::get('attached_ads_id');
        $userId = Input::get('user_id');
        if(User::where('id', $userId)->update(['ads_id'=>$attached_ads_id])){
            Session::flash('message', "Ad attachment to Profile successfully."); 
        }else{
            Session::flash('message', "Error");
        }
        return redirect(url('/partners/proprofile/'.$userId.'/edit'));
    }
    public function unattach($id){
        User::where('ads_id', $id)->update(['ads_id' => 0]); 
        Session::flash('message', "Ad successfully removed.");
        return redirect()->back();
    }
}
