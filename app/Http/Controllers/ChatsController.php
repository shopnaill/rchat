<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

class ChatsController extends Controller
{
   
    public function __construct()
    {
    $this->middleware('auth');
    }

    /**
     * Show Messages 
     *
     * @return \Illuminate\Http\Response
     */

    public function index()
    {
       return view('chat');
    }

    /**
     * Fetch all messages
     *
     * @return Message
     */
    public function fetchMessages($id)
    {
        $messages = Message::with('user')->where( function($q) use ($id){
            $q->where('user_id', auth()->id());
            $q->where('to_id', $id);
        })->orWhere(function($q) use ($id){
            $q->where('user_id', $id);
            $q->where('to_id', auth()->id());
        })->get();

      return  response()->json($messages);
    }

  

    /**
     * Add message to database & Call Event
     *
     * @param  Request $request
     * @return Response
     */
    public function sendMessage(Request $request)
    {
    $user = Auth::user();

    $message = $user->messages()->create([
        'to_id' => $request->to,
        'message' => $request->input('message')
    ]);

     event(new MessageSent($user, $message))->toOthers();

     return  response()->json(['status' => 'Message Sent!']);
    }
}
