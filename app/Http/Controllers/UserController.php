<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createNewUser(Request $request)
    {
        try {
            Log::info('Init create contacts');

            $validator = Validator::make($request->all(), [  
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'streamName'=> 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $newUser = new User();  
    
            $newUser->name = $request->name;
            $newUser->email=$request->email;
            $newUser->password=$request->password;
            $newUser->streamName=$request->streamName;                                     
            
            $newUser->save();

        return response()->json(["data"=>$newUser, "success"=>'User created'], 200);

        } catch (\Throwable $th) {
            Log::error('failed to create user->'.$th->getMessage());

            return response()->json([ 'error'=> 'upssss!'], 500);
        }
    }

    public function getUserById ($id)
    {
        try {
            Log::info('Init get user by Id');
            //$userId = auth()->user()->id;
            $user = DB::table('users')->where('id',$id)->get();

            if(empty($user)){
                return response()->json(
                    [
                        "error" => "user not exists"
                    ],400
                );
            };
            return response()->json($user, 200);

        } catch (\Throwable $th) {
            Log::error('Ha ocurrido un error->'.$th->getMessage());

            return response()->json([ 'error'=> 'upssss!'], 500);
        }
    }
}
