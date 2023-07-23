<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\PersonalAccessToken;
use Throwable;

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

        
        if ($request->bearerToken()) {
            try {
                $token = PersonalAccessToken::findToken($request->bearerToken());
                $user = $token->tokenable;
                Auth::setUser($user);
            } catch(Throwable $e) {
                // no command
            }
        }

        return $next($request);
    }
}
