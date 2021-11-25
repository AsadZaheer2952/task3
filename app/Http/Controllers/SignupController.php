<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\mail;
use App\Mail\TestMail;
use App\Mail\LoginMail;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\SignupRequest;

class SignupController extends Controller
{
    function signUp(SignupRequest $req)
    {
      
        
      $req->validated();

        $results = $req->file('image')->store('apidoc');
        $email = $req->email;
        $users = new User([
           'name'     => $req->name,
           'email'    => $req->email,
           'password' => Hash::make($req->password),
           'gender'   => $req->gender,
           'image'    =>  $results,
           
        ]);

      
        if($users->save())
        {
 
         if(self::mail($email)){
         return response()->json(["Message"=>"save","Status"=>"200"],200);}
         else
         {
            return response()->json(["Message"=>"Not save","Status"=>"404"],404);
         }
        }

    
    }
public function mail($email)
{
    $details = ['title'=>'Hello Asad',
                'link' =>'http://127.0.0.1:8000/api/verification'.'/'.$email,
                'link1' => 'http://127.0.0.1:8000/api/regenrate'.'/'.$email];

                Mail::to('asad.zaheer295@gmail.com')->send(new TestMail($details));
                return "Email Send";
            
}

}
