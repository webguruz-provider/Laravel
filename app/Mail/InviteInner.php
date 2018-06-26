<?php

namespace App\Mail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class InviteInner extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */

    public $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    
    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
        $user = $this->user;
        $debate_id              = $request->input('debate_id');
        $subject = ucfirst(trans($user->name))." invited you to a debate on sided";
        return $this->from('support@sided.co')
                ->subject($subject )
                ->view('emails.invite_friends_inner', compact('debate_id'));



            
        //return $this->view('emails.invite_friends');
    }
}
