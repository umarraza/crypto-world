<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Conversation;
use App\Models\Message;
use App\User;
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


    public function userMessages() {
        
        return view('auth.message.user-messages')
            ->withUserMessages(Auth::user()->messages)
            ->withAdminMessages(Message::where('from_user',1)->get());
    }

    public function adminInbox() {

        $conversations = Conversation::all();

        return view('admin.message.inbox')->withConversations($conversations);
    }

    public function store(Request $request) {

        $message = $this->message->store($request->all());

        return redirect()->route('user.messages');
    }

    public function getUserMessages(Request $request) {


        $user = User::find($request->user_id);

        $conversations = Conversation::all();

        $adminMessages = Message::where('from_user', Auth::user()->id)->where('to_user', $user->id)->get();

        return view('admin.message.inbox')
            ->withConversations($conversations)
            ->withUserMessages($user->messages)
            ->withAdminMessages($adminMessages);
    }
}
