<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;

// Route::post('/user', function () {
//     return 'CREATE USER BY ID';
// });

// Route::group([
//     'middleware'=> 'IsAdmin'
// ], function(){

// });


//localhost:8000/api/


Route::post('/register', [AuthController::class, 'registerUser']);    //authoritation

Route::post('/login', [AuthController::class, 'loginUser']);    //authoritation


Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/logout', [AuthController::class, 'logoutUser']);    //authoritation
Route::get('/profile', [AuthController::class, 'getMyProfile']);  //authoritation
});


Route::group([
    'middleware' => 'jwt.auth'
], function(){
//Route::post('/user', [UserController::class, 'createNewUser']);  //created1
Route::get('/user/{id}', [UserController::class, 'getUserById']);   //created1
Route::patch('/user/{id}', [UserController::class, 'updateUserById']);    //created1
Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);   //created1
Route::get('/users', [UserController::class, 'getAllUsers']);    //for admin
});

Route::group([
    'middleware' => 'jwt.auth'
], function(){
    Route::post('/game', [GameController::class, 'createGame']);
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::get('/game/{id}', [GameController::class, 'getGameById']);
    Route::patch('/game/{id}', [GameController::class, 'updateGameById']);
    Route::delete('/game/{id}', [GameController::class, 'deleteGame']);
});


Route::post('/channel', [channelController::class], 'createChannel');
Route::get('/channel/{id}', [channelController::class], 'getChannelById');
Route::get('/channels', [channelController::class], 'getAllChannels');
Route::patch('/channel/{id}', [channelController::class], 'updateChannel');
Route::delete('/channel/{id}', [channelController::class], 'deleteChannel');

