<?php

namespace App\Mail;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Crypt;

class Challenge extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
	private $take_a_dare_name;
	
    public function __construct($take_a_dare_name , User $user)
    {
        //
		$this->take_a_dare_name  = $take_a_dare_name;
		
        $this->user = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        //echo "<pre>";
        //print_r($request->all());
		//print_r($request->invite);
        //exit;
		
        $user = $this->user;
		echo $take_a_dare_namee = $this->take_a_dare_name;
        $debate_id              = $request->input('debate_id');		
        $challenger_name              = $request->input('challenger_name');
        $encrypted_debate_id    = Crypt::encryptString($debate_id);
		
         $subject = ucfirst(trans($challenger_name))." just challenged you to a debate on Sided";
        return $this->from('support@sided.co')
                ->subject($subject )
                ->view('emails.challenge_friends', compact('debate_id', 'encrypted_debate_id','user','take_a_dare_namee','challenger_name'));
			
        //return $this->view('emails.challenge_friends', compact('debate_id', 'encrypted_debate_id','user'));
    }
}
