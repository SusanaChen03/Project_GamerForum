<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Channel;
use App\Models\User;
use App\Models\Game;
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
                return response()->json($validator->errors(), 418);
            };

            $newChannel = new Channel();
            $newChannel->name = $request->name;
            $newChannel->game_id = $request->game_id; 

            $newChannel->save();

            return response()->json(["data"=>$newChannel, "success"=>'Channel created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to create the channel->'.$th->getMessage());

            return response()->json([ 'error'=> 'Upsss! Something wrong'], 418);
        }
    }

    public function createChannelByUserId(Request $request)
    {
        try {
            Log::info('Init create createChannelByUserId');
            
            $user = User::find($request->iduser);
            $user->channels()->attach($request->idchannel);
             
            return response()->json(["data"=>"ok", "success"=>'Channel created'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to create the channel->'.$th->getMessage());
            return response()->json([ 'error'=> $th->getMessage()], 418);
        }
    }
    
    public function getChannelByUserId ($id)  
    {
        try {
            Log::info('Init get channel by id');

            $channel = DB::table('channel_user')->where('user_id',$id)->get();

            if(empty($channel)){
                return response()->json(
                    [
                        "error" => "channel not exists"
                    ],400
                );
            };
            
            return response()->json($channel, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get channel by id->'.$th->getMessage());
        
            return response()->json([ 'error'=> 'Upsss! Something wrongs!'.$th->getMessage()], 500);
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
            Log::error('Failed to get channel by id->'.$th->getMessage());
        
            return response()->json([ 'error'=> 'Upsss! Something wrongs!'], 500);
        }
    }

    public function getAllChannels()
    {
        try {
            Log::info('Init get all channels');
            $channel = Channel::all(); 

            if(empty($channel)){
                return response()->json(
                    [
                        "success" => "There are not channels"
                    ], 202
                );
            };
            Log::info('Get all channels');

            return response()->json($channel, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all channels->'.$th->getMessage());

            return response()->json([ 'error'=> 'Upsss! Something wrongs!'], 500);
        }
    }

    public function updateChannel(Request $request, $id)
    {
        try {
            Log::info('Update channel by id');

            $validator = Validator::make($request->all(), [   
                'name' => 'string|max:100',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };

            $channel = Channel::where('id', $id)->first();

            if(empty($channel)){
                return response()->json(["error"=> "channel not exists"], 404);
            };

            if(isset($request->name)){
                $channel->name = $request->name;
            }

            $channel->save();

            return response()->json(["data"=>$channel, "success"=>'channel updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update the channel->'.$th->getMessage());
            return response()->json([ 'error'=> 'Upsss! Something wrongs!'], 500);
        }
    }

    public function deleteChannel($id)
    {
        try {
            Log::info('delete Channel');
            $channel = Channel::where('id', $id)->first();

            if(empty($channel)){
                return response()->json(["error"=> "channel not exists"], 404);
            };
            $channel->delete();

            return response()->json(["data"=> "channel deleted"], 200);
            
        } catch (\Throwable $th) {
            Log::error('Failed to deleted the channel->'.$th->getMessage());
            return response()->json([ 'error'=> 'Upsss! Something wrongs!'], 500);
        }
    }

}
