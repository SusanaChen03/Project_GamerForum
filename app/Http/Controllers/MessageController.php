<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use App\Models\Channel;
use App\Models\User;
use App\Models\Game;
use App\Models\Message;

class MessageController extends Controller
{
    public function createMessage(Request $request, $channelId)
    {
        try {
            Log::info('Init create message');
            $userId = auth()->user()->id;

            $userIn = DB::table('channel_user')->where('user_id', $userId)->where('channel_id', $channelId)->get()->toArray();

            if($userIn){ 

                $validator = Validator::make($request->all(), [
                    'message' => 'required|string',
                ]);
    
                if ($validator->fails()) {
                    return response()->json($validator->errors(), 418);
                };

                 $newMessage = new Message();
            
                    $newMessage->message = $request->message;
                    $newMessage->channel_id = $channelId;
                    $newMessage->user_id = $userId;

                    $newMessage->save();

                    return response()->json(["data"=>$newMessage, "success"=>'Message created'], 200);
            };

        } catch (\Throwable $th) {
            Log::error('Failed to post the message' . $th->getMessage());
            return response()->json([ 'error'=> 'Upsss! Something wrong'], 418);
        }
    }
}
