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


    /**
     * @param  void
     *
     * @return mixed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function userInbox() {
        
        return view('auth.user.message.inbox')
            ->withUserMessages(Auth::user()->messages)
            ->withAdminMessages(Message::where('from_user',1)->get());
    }

    /**
     * @param  void
     *
     * @return mixed
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminInbox() {

        $conversations = Conversation::all();
        // dd($conversations);


        return view('admin.message.inbox')->withConversations($conversations);
    }

    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     */
    public function store(Request $request) {

        $message = $this->message->store($request->all());

        return redirect()->route('user.messages');
    }


    /**
     * @param Illuminate\Http\Request $request
     *
     * @return mixed
     * @throws \App\Exceptions\GeneralException
     * @throws \Throwable
     */
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
