<?php

namespace App\Http\Controllers;

use App\Models\User;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;


class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        try {
            Log::info('Init register');

            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3',
                'streamName'=> 'required|string|max:100'
            ]);

            if($validator->fails()){            //metodo fails true o false
                return response()->json($validator->errors()->toJson(),400);
            }

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->password),
                'streamName' => $request->get('streamName')
            ]);

            $token = JWTAuth::fromUser($user);   //recupera los datos del usuario y nos lo encripta a la $token

            return response()->json(compact('user','token'),201);

        } catch (\Throwable $th) {

            return response()->json([ 'error'=> 'upssss!'], 500);
        }
    }

    

    
}
