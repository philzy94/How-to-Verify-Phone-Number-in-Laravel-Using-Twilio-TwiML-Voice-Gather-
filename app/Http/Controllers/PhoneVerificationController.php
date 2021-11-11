<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Twilio\TwiML\VoiceResponse;
use App\Models\User;

class PhoneVerificationController extends Controller
{
    public function userInput($call_to)
    {
        $response = new VoiceResponse();
        $response->say("Hello, thank you for registering with us.");

        $gather = $response->gather([
            'action' => '/build-twiml/'.$call_to. '/verification',
            'numDigits' => 6,
            'timeout'=>10, 
        ]);

        $gather->say("Please enter the six digits verification code that is currently displaying on your screen in ther to verify your phone number");

        $response->say('Sorry. You did not respond and your account can not be verify. Goodbye');
        $response->hangup();        
        echo $response;
    }

    public function verifyNumber($call_to)
    {
        $user = User::where('phone_number', $call_to)->first();
        $code = $_POST['Digits'];

        $response = new VoiceResponse();
        
        if($_POST['Digits'] == $user->verification_code){
            $emailNumber= User::where('phone_number', $call_to)->update(['isVerified' => true]);

            if($emailNumber){
            $response->say('You account has been verified. Goodbye');
                
            }
            else{
                $response->say('An error accured while trying to verify your account. Please try again.');
                $response->redirect('/build-twiml/user-input/'.$call_to);
            }
        }
        else{
            $response->say('You entered a wrong verification, and your account can not be verified. Goodbye');
        }
    
        echo $response;
    }
}
