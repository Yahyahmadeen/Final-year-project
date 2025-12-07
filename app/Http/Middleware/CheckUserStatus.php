<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckUserStatus
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check() && Auth::user()->status !== 'active') {
            $user = Auth::user();
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $errorMessage = 'Your account is no longer active. Please contact support.';
            if ($user->status === 'pending') {
                $errorMessage = 'Your account is still pending approval.';
            } elseif ($user->status === 'suspended') {
                $errorMessage = 'Your account has been suspended. Please contact support.';
            }

            return redirect()->route('login')->with('error', $errorMessage);
        }

        return $next($request);
    }
}
