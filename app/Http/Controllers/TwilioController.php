<?php

namespace App\Http\Controllers;
use Twilio;
use App\User;
use Illuminate\Http\Request;
class TwilioController extends Controller
{
    public function index()
    {
        $accountId = 'AC3933d1348280d77b0a52ff390f37ec51'; 
        $token = '4a92784fca737d65787620b833e732c0'; 
        $fromNumber = '+17246095092';
        $twilio = new \Aloha\Twilio\Twilio($accountId, $token, $fromNumber);
        $twilio->message('+919041064990', 'Testing');
      // $message = Twilio::message("+919041064990", 'jkjkjkj');
        // $sid = 'AC5071d78aa03a3f9ee41bbde092dfe732'; 
        // $token = 'c7584619237181f2556142e74bf252f5'; 
        // $client = new \Services_Twilio($sid, $token);

        // $message = $client->account->messages->sendMessage(
        //     '+15005550006', // From a valid Twilio number
        //     '+919041064990', // Text this number
        //     "Hello Sided!"
        // );
        
        dd($twilio);
    }
}
