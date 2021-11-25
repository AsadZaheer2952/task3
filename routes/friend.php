<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FriendController;
Route::middleware(['verify'])->group(function(){
Route::post('/friend', [FriendController::class,"addFriends"]);
Route::get('/friendlist', [FriendController::class,"showFriends"]);
Route::post('/friend/remove', [FriendController::class,"remove"]);
Route::post('/request', 'FriendController@request');
});