<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Game;

class GameController extends Controller
{
    public function createGame(Request $request)
    {
        try {
            Log::info('Init create game');

            $validator = Validator::make($request->all(), [   
                'name' => 'required|string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $newGame = new Game();
            $userId = auth()->user()->id;

            $newGame->name = $request->name;
            $newGame->user_id=$userId;  

            $newGame->save();

            return response()->json(["data"=>$newGame, "success"=>'Game created'], 200);
     
        } catch (\Throwable $th) {
            Log::error('failed to create the game->'.$th->getMessage());

            return response()->json([ 'error'=> 'upssss!'], 500);
        }
    }

    
}
