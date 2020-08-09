<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\User;
use Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MessageController extends Controller
{
    /**
     * MessageController constructor.
     *
     * @param  Message  $message
     */
    public function __construct(Message $message)
    {
        $this->message = $message;
    }


    /**
     * @param  void
     *
     * @return mixed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userInbox() {
        
        $messages = Message::where(function($query) {
            $query->where('from_user', 1)
                  ->where('to_user', auth()->user()->id);
        })->orWhere(function($query) {
            $query->where('from_user',  auth()->user()->id)
                  ->where('to_user', 1);
        })->get();

        return view('auth.user.message.inbox')->withMessages($messages);
    }

    /**
     * @param  void
     *
     * @return mixed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminInbox() {

        $models = Conversation::all();

        $conversations = [];

        foreach($models as $conversation) {
        
            if (!empty($conversation->messages->toArray())) {
                $conversations[] = [
                    'id' => $conversation->id,
                    'user_name' => $conversation->user->full_name,
                    'message' =>  $conversation->messages->first()->content,
                ];
            }
        }

        return view('admin.message.inbox')->withConversations($conversations);
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request) {

        $message = $this->message->store($request->all());

        $messages = Message::where(function($query) {
            $query->where('from_user', 1)
                  ->where('to_user', auth()->user()->id);
        })->orWhere(function($query) {
            $query->where('from_user',  auth()->user()->id)
                  ->where('to_user', 1);
        })->get();

        return Response::json(['messages'=>$messages], 200);
    }

    public function storeAdminMessage(Request $request) {

        $conversation = Conversation::find(intval($request->conversation_id));

        $message = Message::create([
            'to_user' => $conversation->user->id,
            'from_user' => Auth::user()->id,
            'conversation_id'=> $conversation->id,
            'content' => $request->message,
        ]);

        $messages = Message::where('conversation_id', intval($request->conversation_id))->get();

        return Response::json(['messages'=>$messages], 200);
    }


    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function getUserMessages(Request $request) {

        $conversation = find(intval($request->id));

        $messages = Message::where('conversation_id', intval($request->id))->get();

        // $messages = Message::where(function($query) {
        //     $query->where('from_user', 1)
        //           ->where('to_user', auth()->user()->id);
        // })->orWhere(function($query) {
        //     $query->where('from_user',  auth()->user()->id)
        //           ->where('to_user', 1);
        // })->get();

        
        // ->orWhere(function($query) {
        //     $query->where('from_user',  auth()->user()->id)
        //     ->where('to_user', 1);
        // })->get();
        
        return Response::json(['messages'=>$messages], 200);
    }
}
