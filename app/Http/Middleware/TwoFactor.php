<?php

namespace App\Http\Middleware;

use Closure;

class TwoFactor
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
        $user = auth()->user();
        if(auth()->check() && $user->two_factor_code)
        {
            if(!$request->is('verify*'))
            {
                return redirect()->route('verify.index')->withMessage('The two factor code has been sent');
            }
        }
        return $next($request);
    }
}
