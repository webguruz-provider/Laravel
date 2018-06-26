<?php

namespace App\Http\Controllers\Game\Pages;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    //

    public function support(){
    	return view('game.pages.support');
    }

    public function badges(){
    	return view('game.pages.badges');
    }


    public function pointframework(){
    	return view('game.pages.pointframework');
    }
    
}
