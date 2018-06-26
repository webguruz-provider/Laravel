<?php namespace App\Http\Composers;

//use Auth;
use App\User;

class AdminNavComposer
{
    public function compose($view)
    {
        $user = User::find(1);
        $view->with('user', $user);
    }
}
