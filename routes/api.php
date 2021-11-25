<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CommentController;
use App\Http\Middleware\UserVerify;
use App\Http\Middleware\Validation;
use App\Http\Middleware\UpdateValidation;





Route::middleware(['verify'])->group(function(){
    Route::post('comment',[CommentController::class,"commentCreate"]);  
    Route::get('comment/delete/{cid}/{pid}',[CommentController::class,"commentDelete"]);  
    Route::get('postcomments/{pid}',[CommentController::class,"postComments"]);  

    
});




