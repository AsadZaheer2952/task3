<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MailVerify;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\SignupController;
use App\Http\Controllers\UserController;

Route::post('login',[LoginController::class,"logIn"]);                                 //login 
Route::post('signup',[SignupController::class,"signUp"]); 

Route::middleware(['verify'])->group(function(){
    Route::post('logout',[UserController::class,"logOut"]);    //logout Route
    Route::post('uedit',[UserController::class,"edit"]);

Route::get('verification/{email}',[MailVerify::class,"verify"]);                        //link verfication Route
Route::get('regenrate/{email}',[MailVerify::class,"regenrate_link"]);                   //verify link create Route

});