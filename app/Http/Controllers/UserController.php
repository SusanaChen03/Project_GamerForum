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
            Log::info('Init create User');
            $validator = Validator::make($request->all(), [  
                'name' => 'required|string',
                'email' => 'required|email',
                'password' => 'required|string',
                'streamName'=> 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $newUser = new User();  
            $newUser->name = $request->name;
            $newUser->email=$request->email;
            $newUser->password=$request->password;
            $newUser->streamName=$request->streamName;                                     
            
            $newUser->save();

        return response()->json(["data"=>$newUser, "success"=>'User created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to create user->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function getAllUsers()
    {
        try {
            Log::info('Init get all contacts');
            $user = User::all(); 

            if(empty($user)){
                return response()->json(
                    [
                        "success" => "There are not users"
                    ], 202
                );
            };

            Log::info('Get all users');

            return response()->json($user, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all users->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function getUserById ($id)
    {
        try {
            Log::info('Init get user by Id');
            $user = DB::table('users')->where('id',$id)->get();

            if(empty($user)){
                return response()->json(
                    [
                        "error" => "user not exists"
                    ],404
                );
            };
            return response()->json($user, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get user->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function updateUserById(Request $request, $id)
    {
        try {
            Log::info('Update data user');
           $validator = Validator::make($request->all(), [  
            'name' => 'string|max:100',
            'email' => 'email',
            'password' => 'string',
            'streamName' => 'string'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 418);
        };
        
        $user = User::where('id',$id)->first();
        if(empty($user)){
            return response()->json(["error"=> "contact not exists"], 404);
        };

        if(isset($request->name)){
            $user->name = $request->name;
        };

        if(isset($request->email)){
            $user->email = $request->email;
        };

        if(isset($request->password)){
            $user->password = $request->password;
        };

        if(isset($request->streamName)){
            $user->streamName = $request->streamName;
        };

        $user->save();

        return response()->json(["data"=>$user, "success"=>'User updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update user data->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function deleteUserById ($id)
    {
        try {
            Log::info('delete user');
            $user = User::where('id',$id)->first();

            if(empty($user)){
                return response()->json(["error"=> "user not exists"], 404);
            };
            
            $user->delete();

            return response()->json(["data"=> "user deleted"], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to delete user->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }
}
