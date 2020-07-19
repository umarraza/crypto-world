<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        $logged_in_user = Auth::user();

        if ($logged_in_user->isAdmin()) {
            return $next($request);
        }

        return redirect()->back()->withFlashDanger(__('You are unauthorized for this action'));
    }
}
