<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
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

    public function getMessageById($channelId)
    {
        try {
            Log::info('Init get messages by channel Id');
            $userId = auth()->user()->id;
            
            $messages = DB::table('messages')->where('user_id',$userId)->where('channel_id',$channelId)->get();

            if(empty($messages)){
                return response()->json(
                    [
                        "error" => "Game not exists"
                    ],404
                );
            };
            return response()->json($messages, 200);
            
        } catch (\Throwable $th) {
            Log::error('Failed to get message by channel id->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function getAllMessages()
    {
        try {
            Log::info('Init get all messages');
            $userId = auth()->user()->id;

            $message = DB::table('messages')->where('user_id', $userId)->get()->toArray();

            if(empty($message)){
                return response()->json(
                    [
                        "success" => "There are not games"
                    ], 202
                );
            };
            return response()->json($message, 200);

        } catch (\Throwable $th) {
            Log::error('Failed to get all the messages->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);  
        }
    }

    public function updateMessageById(Request $request, $messageId) //id mensaje
    {
        try {
            Log::info('Update message by id');
            $userId = auth()->user()->id;

            $validator = Validator::make($request->all(), [   
                'message' => 'string',
            ]);

            if ($validator->fails()) {
                return response()->json($validator->errors(), 418);
            };
            
            $messageUpdate = Message::where('id',$messageId)->where('user_id',$userId)->first();

            if(empty($messageUpdate)){
                return response()->json(["error"=> "no have any message"], 404);
            };

            if(isset($request->message)){
                $messageUpdate->message = $request->message;
            };

            $messageUpdate->save();

            return response()->json(["data"=>$messageUpdate, "success"=>'Message updated'], 200);

        } catch (\Throwable $th) {
            Log::error('Failed to update the message->'.$th->getMessage());
            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }

    public function deletedMessage($id)
    {
        try {
            Log::info('delete message');
            $userId = auth()->user()->id;

            $message = Message::where('id',$id)->where('user_id',$userId)->first();

            if(empty($message)){
                return response()->json(["error"=> "message not exists"], 404);
            };

            $message->delete();

            return response()->json(["data"=> "message deleted"], 200);

        } catch (\Throwable $th) {
            Log::error('Failes to deleted the message->'.$th->getMessage());

            return response()->json([ 'error'=> 'Ups! Something wrong'], 500);
        }
    }
}
