<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });


// Route::post('/user', function () {
//     return 'CREATE USER BY ID';
// });


//localhost:8000/api/users


Route::post('/user', [UserController::class, 'createNewUser']);  //created1

Route::post('/register', [UserController::class, 'registerUser']);    //authoritation

Route::post('/login', [UserController::class, 'loginUser']);    //authoritation

Route::post('/logout', [UserController::class, 'logoutUser']);    //authoritation

Route::get('/users', [UserController::class, 'getAllUsers']);    //for admin

Route::get('/user/{id}', [UserController::class, 'getUserById']);   //created1

Route::patch('/user/{id}', [UserController::class, 'updateUserById']);  

Route::delete('/user/{id}', [UserController::class, 'deleteUserById']);
