<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Session;



class AuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }  
      
    public function reverify()
    {
        return view('auth.verification');
    }  
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function registration()
    {
        return view('auth.registration');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postLogin(Request $request)
    {
        $request->validate([
            'phone_number' => 'required',
            'password' => 'required',            

        ]);
        
        $user = User::where('phone_number', $request->phone_number)->first();

        if($user && $user->isVerified == false && Hash::check($request->password, $user->password)){
            return redirect("login")->with('status', 'Account not verified');
        };
        $credentials = $request->only('phone_number', 'password');
       
        if (Auth::attempt($credentials)) {
           
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->witherrors('Oppes! You have entered invalid credentials');
    }
      
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'name' => 'required',
            'phone_number' => 'required|numeric|unique:users',
            'password' => 'required|min:8',
        ]);

        $code = random_int(100000, 999999);
        $user = new User;

        User::create([
            'name' => $request->name,
            'phone_number' => $request->phone_number,
            'verification_code' => $code,
            'password' => Hash::make($request->password)
          ]);

          $this->makeCall($request->phone_number);
         
        return redirect()->route('login')->withSuccess($code);
    }
    
    /**
     * Write code on Method
     *
     * @return response()
     */
    public function dashboard()
    {
        if(Auth::check()){
            return view('dashboard');
        }
  
        return redirect("login")->witherrors('Opps! You do not have access');
    }



    public function postReverify(Request $request){
        $request->validate([            
            'phone_number' => 'required|numeric',            
        ]);
        $code = random_int(100000, 999999);

        $newToken= User::where('phone_number', $request->phone_number)->update(['verification_code' => $code]);

        if($newToken){
            $this->makeCall($request->phone_number);
            return redirect()->route('login')->withSuccess($code);
                
            }
            else{
                return redirect("login")->witherrors('Opps! this phone number does not exit');
            }

    }

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }

    public function makeCall($call_to) {
        $token = getenv("TWILIO_AUTH_TOKEN");
        $twilio_sid = getenv("TWILIO_SID");
        $twilio = new Client($twilio_sid, $token);
       
        $twilio->calls->create($call_to, // to
                        "+17122143185", // from
                        [
                            "url" => "http://c336-129-205-113-8.ngrok.io/build-twiml/user-input/".$call_to
                        ]
               );

    }

    
}