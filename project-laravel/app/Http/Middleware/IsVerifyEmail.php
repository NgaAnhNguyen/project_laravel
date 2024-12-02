<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class IsVerifyEmail
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next)

    {

        if (!Auth::user()->is_email_verified) {

            Auth::guard('web')->logout();
            return redirect()->route('checkout')

                    ->with('message', 'You need to confirm your account. We have sent you an activation code, please check your email.');

          }

   

        return $next($request);

    }
}
