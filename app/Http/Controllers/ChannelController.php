<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Game;
use App\Models\Channel;
class ChannelController extends Controller
{
    public function createChannel(Request $request)
    {
        try {
            Log::info('Init create channel');

            $validator = Validator::make($request->all(), [   
                'name' => 'required|string',
            ]);
            if ($validator->fails()) {
                return response()->json($validator->errors(), 400);
            };

            $newChannel = new Channel();

            $newChannel->name = $request->name;
            $newChannel->game_id = $request->game_id; 

            $newChannel->save();

            return response()->json(["data"=>$newChannel, "success"=>'Channel created'], 200);

        } catch (\Throwable $th) {
            Log::error('failed to create the channel->'.$th->getMessage());

            return response()->json([ 'error'=> 'upsss'], 418);
        }
    }

    public function getChannelById ($id)  
    {
        try {
            Log::info('Init get channel by id');

            $channel = DB::table('channels')->where('game_id',$id)->get();
          
            if(empty($channel)){
                return response()->json(
                    [
                        "error" => "channel not exists"
                    ],400
                );
            };
            
            return response()->json($channel, 200);

        } catch (\Throwable $th) {
            Log::error('failed to get channel by id->'.$th->getMessage());
        
            return response()->json([ 'error'=> 'upssss!'.$th->getMessage()], 500);
        }
    }
}
