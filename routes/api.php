<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChannelController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\MessageController;

// Route::post('/user', function () {
//     return 'CREATE USER BY ID';
// });

// Route::group([
//     'middleware'=> 'IsAdmin'
// ], function(){

// });


//localhost:8000/api/

//NO NEED AUTHORIZATION
Route::post('/register', [AuthController::class, 'registerUser']);  
Route::post('/login', [AuthController::class, 'loginUser']);  

//AUTH
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/logout', [AuthController::class, 'logoutUser']);    
Route::get('/profile', [AuthController::class, 'getMyProfile']); 
});

// USERS
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/user', [UserController::class, 'createNewUser']);  
Route::get('/user/{id}', [UserController::class, 'getUserById']);   
Route::patch('/user/{id}', [UserController::class, 'updateUserById']);   
Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);   
Route::get('/users', [UserController::class, 'getAllUsers']);    //for admin
});

//GAMES
Route::group([
    'middleware' => 'jwt.auth'
], function(){
    Route::post('/game', [GameController::class, 'createGame']);
    Route::get('/games', [GameController::class, 'getAllGames']);
    Route::get('/game/{id}', [GameController::class, 'getGameById']);
    Route::patch('/game/{id}', [GameController::class, 'updateGameById']);
    Route::delete('/game/{id}', [GameController::class, 'deleteGame']);
});


//CHANNELS
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/channel', [ChannelController::class, 'createChannel']);
Route::get('/channel/{id}', [channelController::class, 'getChannelById']);
Route::get('/channels', [channelController::class, 'getAllChannels']);
Route::patch('/channel/{id}', [channelController::class, 'updateChannel']);
Route::delete('/channel/{id}', [channelController::class, 'deleteChannel']);

Route::post('/channelByUser', [channelController::class, 'createChannelByUserId']);
Route::get('/getChannelByUser', [channelController::class, 'getChannelByUserId']);
Route::post('/letChannelByUser', [channelController::class, 'letChannelByUserId']);
});

//MESSAGES
Route::group([
    'middleware' => 'jwt.auth'
], function(){
Route::post('/message/{id}', [MessageController::class, 'createMessage']);    //buscar id channel
Route::get('/message/{id}', [MessageController::class, 'getMessageById']);
Route::get('/messages', [MessageController::class, 'getAllMessages']);
Route::patch('/message/{id}', [MessageController::class, 'updateMessageById']);
Route::delete('/message/{id}', [MessageController::class, 'deletedMessage']);

});


