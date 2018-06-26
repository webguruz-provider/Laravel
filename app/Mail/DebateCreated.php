<?php

namespace App\Mail;

use App\User;
use App\Debate;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class DebateCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    private $user;
    private $debate;
    public function __construct(Debate $debate,User $user)
    {
        //
        $this->user = $user;
        $this->debate = $debate;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $user = $this->user;
        $debate = $this->debate;
     
        if($debate->status =='needs_opponent'){
            $subject = ucfirst(trans($user->name)).", wanna start this debate on Sided?";
        }
        else{
            $subject = ucfirst(trans($user->name)).", wanna start this debate on Sided?";
        }
        


         return $this->from('support@sided.co')
                ->subject($subject )
                ->view('emails.debate_started', compact('user','debate'));



        //return $this->view('emails.debate_started', compact('user','debate'));
    }
}
