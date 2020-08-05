<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $userId = Auth::user()->id;
        $userId = encrypt($userId);

        // dd(Notification::select('notification')->get());

        return view('dashboard')->withUserId($userId);
        // return view('dashboard')->withUserId($userId)->withNotifications(Notification::select('notification'));
    }
}
