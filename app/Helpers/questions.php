<?php
namespace App\Helpers;
use App\Question;


class Questions{

	private $active;
	private $expired;

    public function __construct() {
        
    	
    }


	public function get_questions(){
		return Question::all();
	}


}