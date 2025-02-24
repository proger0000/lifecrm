<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureUserIsApproved
{
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check() && !auth()->user()->approved) {
            auth()->logout();
            return redirect('/login')->withErrors(['Ваш аккаунт ещё не одобрен администратором.']);
        }
        return $next($request);
    }
}
