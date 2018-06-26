<?php

namespace App\Mail;
use App\User;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Invite extends Mailable
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
    public function build()
    {
        $user = $this->user;
        $subject = ucfirst(trans($user->name))." invited you to Sided";
        return $this->from('support@sided.co')
                ->subject($subject )
                ->view('emails.invite_friends');


            
        //return $this->view('emails.invite_friends');
    }
}
