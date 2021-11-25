<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Middleware\UserVerify;



Route::middleware(['verify'])->group(function(){

    Route::post('postcreate',[PostController::class,"postCreate"]);  
    Route::get('UserPosts',[PostController::class,"userPosts"]); 
    Route::post('postupdate/{pid}',[PostController::class,"postUpdate"]);  
    Route::get('postdelete/{pid}',[PostController::class,"postDelete"]);
    Route::post('search',[PostController::class,"postSearch"]);  
});