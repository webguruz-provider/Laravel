<?php

namespace App\Mail;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class Proposequestion extends Mailable
{
     use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(Request $request)
    {
		$category = $request->category;
		$question_text = $request->question_text;
		$pro_email = $request->pro_email;
		$pro_user = $request->pro_user;
		$user_name = $request->user_name;
		$subject = ucfirst(trans($user_name))." proposed a question";
        return $this->from('support@sided.co')
                ->subject($subject )
                ->view('emails.propose_question', compact('category', 'question_text','pro_email','pro_user','user_name'));
    }
}
