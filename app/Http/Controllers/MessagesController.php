<?php

namespace App\Http\Controllers;

use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessagesController extends Controller
{
    public function getChatMessages () {
// get sender and receiver cht users
        $receivers = Message::where('sender_id',  Auth::user()->id)
                            ->select('receiver_id')
                            ->distinct()
                            ->get();
        foreach ($receivers as $i) {
            $receivers_id[] = $i->receiver_id;
        }

        $senders = Message::where('receiver_id',  Auth::user()->id)
                          ->select('sender_id')
                          ->distinct()
                          ->get();
        foreach ($senders as $i) {
            $senders_id[] = $i->sender_id;
        }
// connect arrays and get unique users data
        $all_users_ids = array_unique(array_merge($receivers_id, $senders_id));
        $chat_users = User::whereIn('id', $all_users_ids)->get();

        return response()->json($chat_users);
    }

    public function chosenUsersMessages ($id) {
        $sent_messages = Message::where('receiver_id', $id)
                                ->where('sender_id', Auth::user()->id)->with('user_receiver')
                                ->orwhere('sender_id', $id)
                                ->where('receiver_id', Auth::user()->id)->with('user_sender')
                                ->get();
        return response()->json($sent_messages);
    }

    public function createMessage (Request $request, $id) {
        $message = $request->messageText;
        $created_message = Message::create([
            'sender_id' => Auth::user()->id,
            'receiver_id' => $id,
            'message' => $message
        ]);
        if ($created_message) {
//            event(new Message($message));
            return response()->json($created_message->load(['user_sender', 'user_receiver']));
        }
        return response()->json('Failure');
    }
}
