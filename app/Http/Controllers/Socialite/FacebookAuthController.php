<?php

namespace App\Http\Controllers\Socialite;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Socialite;
use App\Sided\SocialAccountService;

class FacebookAuthController extends Controller
{

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        return Socialite::driver('facebook')->redirect();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function store(SocialAccountService $service)
    {
        $user = $service->getFaceBookUser(Socialite::driver('facebook')->user());
        auth()->login($user);
        return redirect()->to('/feed');
    }
}
