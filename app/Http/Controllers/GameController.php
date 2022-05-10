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

    public function getAllGames()
    {
        try {
            Log::info('Init get all games');

            $userId = auth()->user()->id;

            $game = User::find($userId)->games;

            if(empty($game)){
                return response()->json(
                    [
                        "success" => "There are not games"
                    ], 202
                );
            };

            return response()->json($game, 200);
            
        } catch (\Throwable $th) {

            Log::error('failed to get all the games->'.$th->getMessage());

            return response()->json([ 'error'=> 'upssss!'], 500);  

        }
    }

    public function getGameById($id) //busqueda por id del juego
    {
        try {
            Log::info('Init get games by id');

            $userId = auth()->user()->id;

            $game = DB::table('games')->where('user_id',$userId)->first();

            if(empty($game)){
                return response()->json(
                    [
                        "error" => "Contact not exists"
                    ],400
                );
            };

            return response()->json($game, 200);

        } catch (\Throwable $th) {
            Log::error('failed to get game by id->'.$th->getMessage());

            return response()->json([ 'error'=> 'upssss!'], 500);
        }
    }

}
