<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Validator; 
use Firebase\JWT\JWT;
use Firebase\JWT\Key;
use Illuminate\Support\Facades\mail;
use App\Mail\TestMail;
use App\Mail\LoginMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\LoginRequest;

class LoginController extends Controller
{


    public function login_mail($email)   
    {
        $details = ['title'=>'Log in Confirmation Mail',
                    'Message' =>'Your Are Log in At '.now()];
    
                    Mail::to('asad.zaheer295@gmail.com')->send(new LoginMail($details));   //Here in to We Put Mail $req->email Where We send mail
                    return "Email Send";
                
    }
    



     public function logIn(LoginRequest $req){

    $req->validated();
    
     $user = DB::table('users')
     ->where('email',$req->email)->first();  
     
   
    if(!empty($user->id)){
        $password          = $user->password;  
        $user_data['id']   = $user->id;
        $user_data['email']= $user->email;
    
    if(Hash::check($req->password,$password ))  
    {     
       
            $secret_key="Malik$43";
            $iss = "localhost";
            $iat = time(); 
            $nbf = $iat+10; 
            $exp = $iat+1800; 
            $aud = "user"; 

            $payload_info= array(
                "iss" =>$iss,
                "iat" =>$iat, 
                "nbf" =>$nbf,
                "exp" =>$exp, 
                "aud" =>$aud, 
                "data" =>$user_data
                );
                
            try{
                
                    $sql= DB::table('users')
                    ->where('email', $req->email)
                    ->whereNotNull('email_verified_at')   
                    ->where('status',1)
                    ->get();
                    
                    $count = Count($sql);

            if($count)  
            {
                
                $Auth_key = JWT::encode($payload_info,$secret_key);     
                $user = DB::table('users')
                ->where('email',$req->email)
                ->update(['remember_token'=> $Auth_key, 'updated_at' => now()->addMinutes(30) ]);

               self::login_mail($req->email);
            	return response(["Message"=>["message"=>"Successfully Login","Status"=>200],'Auth_key'=>$Auth_key,],200);
            }
            else
            {
                return response(["Message"=>"Unauthorized Access or Verify Your Email","Status"=>"404"],404);  //Message For Unauthorized user
            }
            }
            catch (Exception $e)
            {
            	return array('error'=>$e->getMessage());
            }
        }

            else
            {
               
                return response(["Message"=>"Credentials Not Matched","Status"=>"404"],404); //If User Input Not Match Then Through This Message
            } 
        }
        else
        {
            return response(["Message"=>"Credentials Not Matched","Status"=>"404"],404);
        }
}

      



}
