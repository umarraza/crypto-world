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
        
        return view('auth.user.message.inbox')->withMessages(auth()->user()->getMessages());
    }

    public function getMessages() {
        return response()->json(['messages'=>Auth::user()->getMessages()]);
    }

    /**
     * @param  void
     *
     * @return mixed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminInbox() {

        return view('admin.message.inbox')->withConversations(Auth::user()->conversations());
    }

    public function getConversations() {
        return response()->json(['conversations'=>Auth::user()->conversations()]);
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request) {

        $message = $this->message->store($request->all());

        return Response::json(['messages'=>Auth::user()->getMessages()], 200);
    }

    public function storeAdminMessage(Request $request) {

        $this->message->storeAdminMessage($request->all());

        return Response::json(['messages'=>$this->message->getConversationMessages(intval($request->conversation_id))], 200);
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
    public function getUserMessages(Request $request) {

        return Response::json(['messages'=>Message::where('conversation_id', intval($request->id))->get()], 200);
    }
}
