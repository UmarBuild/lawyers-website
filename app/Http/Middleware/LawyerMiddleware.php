<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class LawyerMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::user()) {
            return redirect()->route('login');
        }
        if (!Auth::user()->isLawyer()) {
            return redirect()->route('home')->with('error', 'Access denied. Lawyer area only.');
        }
        if (!Auth::user()->isApproved()) {
            Auth::logout();
            return redirect()->route('login')->with('error', 'Your account is not approved yet.');
        }
        return $next($request);
    }
}
