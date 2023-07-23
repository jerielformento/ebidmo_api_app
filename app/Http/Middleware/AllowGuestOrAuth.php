<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;

class AllowGuestOrAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {

        
            /* if ($request->bearerToken()) {
                if(Auth::check()) {
                    //echo "auths";
                } else {
                    $token = PersonalAccessToken::findToken($request->bearerToken());
                    $user = $token->tokenable();
                    //dd($user);
                    Auth::setUser($user);
                }
                //return response()->json(['id'=>Auth::id()]);
                //Auth::setUser();
            } else {
                //echo "not auth 2";
            } */
    

        return $next($request);
    }
}
