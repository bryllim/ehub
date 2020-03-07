<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Message;
use Auth;

class MessageController extends Controller
{
    public function index()
    {
        return view("messages");
    }

    public function conversation($id)
    {
        $user = User::findOrFail($id);
        $messages = Message::where('recepient_id', $user->id)
                           ->where('user_id', Auth::user()->id)
                           ->orWhere('recepient_id', Auth::user()->id)
                           ->where('user_id', $user->id)
                           ->get();
        return view('conversation', ['user' => $user, 'messages' => $messages]);
    }

    public function newMessage(Request $request)
    {
        $message = new Message;
        $message->message = $request->message;
        $message->user_id = Auth::user()->id;
        $message->recepient_id = $request->recepient_id;
        $message->save();
        
        return $message->id;
    }
}
