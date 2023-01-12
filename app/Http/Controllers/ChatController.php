<?php

namespace App\Http\Controllers;
use App\Models\Chat;
use Illuminate\Support\Facades\Validator;
use App\Event\UserChat;
use Illuminate\Http\Request;

class ChatController extends Controller
{
    public function conversations(Request $request)
    {

        $isValidate = Validator::make($request->all(), [

            'user1' => 'required|exists:users,id',
            'user2' => 'required|exists:users,id',
            'message' => 'nullable',

        ]);

        if ($isValidate->fails()) {
            return response()->json([
                "errors" => $isValidate->errors()->all(),
                "success" => false

            ], 403);
        }

        $chat = new Chat();
        $chat->user1=$request->user1;
        $chat->user2=$request->user2;
        $chat->message=$request->message??'';
        $chat->save();

        $cov=Chat::where('user1',$request->user1)->where('user2',$request->user2)->get();

        event(new UserChat($cov));



        return response()->json([
            "success"=>true,
            "data" => $chat]);




    }

}
