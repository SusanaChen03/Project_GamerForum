<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function registerUser(Request $request)
    {
        try {
            Log::info('Init register user');
            $validator = Validator::make($request->all(), [
                'name' => 'required|string|max:100',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:3',
                'streamName' => 'required|string|max:100'
            ]);
 
            if ($validator->fails()) {           
                return response()->json($validator->errors()->toJson(), 418);
            };

            $user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => bcrypt($request->password),
                'streamName' => $request->get('streamName')
            ]);

            $token = JWTAuth::fromUser($user);

            return response()->json(compact('user', 'token'), 201);

        } catch (\Throwable $th) {
            Log::error('Failed to register user->' . $th->getMessage());

            return response()->json(['error' => $th->getMessage()], 500);
        }
    }

    public function loginUser(Request $request)
    {
        try {
            Log::info('Init login');
            $input = $request->only('email', 'password');

            $jwt_token = null;

            if (!$jwt_token = JWTAuth::attempt($input)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid Email or Password',
                ], Response::HTTP_UNAUTHORIZED);
            };

            return response()->json(['success' => true, 'token' => $jwt_token]);

        } catch (\Throwable $th) {

            Log::error('Failed to login user->' . $th->getMessage());

            return response()->json(['error=> "Error login user'], 500);
        }
    }

    public function logoutUser(Request $request)
    {
        $this->validate($request, [
            'token' => 'required'
        ]);

        try {
            Log::info('Init Logout');
            JWTAuth::invalidate($request->token);

            return response()->json([
                'success' => true,
                'message' => 'User logged out successfully'
            ]);

        } catch (\Exception $exception) {

            return response()->json([
                'success' => false,
                'message' => 'Sorry, the user cannot be logged out'
            ], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function getMyProfile()
    {
        try {
            Log::info('Init Get Profile');

            return response()->json(auth()->user());

        } catch (\Throwable $th) {

            Log::error('Failed to get your profile->' . $th->getMessage());

            return response()->json(['error=> Error to get profile'], 500);
        }
    }
};
