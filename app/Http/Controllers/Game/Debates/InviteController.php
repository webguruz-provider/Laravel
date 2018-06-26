<?php

namespace App\Http\Controllers\Game\Debates;

use App\Mail\Invite;

use Exception;
use Session;
use App\UserPoint;
use App\User;
use DB;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use Illuminate\Mail\Mailable;
use Illuminate\Support\Facades\Mail;

class InviteController extends Controller
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
     * For now only sending email for invite
     No any point system for invite
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try{
            $user   = Auth::user();
            $emails = $request->input('email');

            if(!is_array($emails)){
                $emails = explode(',', $request->input('email'));
            }

            foreach($emails as $email){
                $notoficationStatus = DB::table('users')->where('email',$email)->first();
				if(!empty($notoficationStatus))
				{
					if($notoficationStatus->go_online!="false")
					{
						Mail::to($email)->send(new InviteInner($user));
					}
				}
				else
				{
					Mail::to($email)->send(new InviteInner($user));
				}
            }
            Session::flash('message', "Invite friends successfully sent.");



            $fingerprint_string = $request->input('fingerprint_string');
            $event_type = 'invite';
            $event_id   =  '0';
            $points     = '50';
            $visitor_id = auth()->id();

            $already_exist = UserPoint::where('visitor_id',$visitor_id)
                                    ->where('event_type', 'invite')->count();

            if($already_exist == '0'){
                // insert new point
                if($this->add_point_once($fingerprint_string, $event_type, $event_id, $points, $visitor_id)){
                    // echo "ok comment";
                }
            }




            
            if($request->input('debate_id') == null){
                Session::flash('message', "Invite friends successfully sent.");
                return redirect('feed');
            }else{
                Session::flash('message', "Invite friends successfully sent.");
                //return redirect('debates/'.$request->input('debate_id'));
				return redirect('feed');
            }


        }catch(Exception $e){
            Session::flash('message', "Invite friends successfully sent.");
            //return redirect('debates/'.$request->input('debate_id'));
			return redirect('feed');
        }
        
        

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
