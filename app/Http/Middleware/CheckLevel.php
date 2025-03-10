<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CheckLevel
{
    public function handle(Request $request, Closure $next, $level)
    {
        $user = Session::get('user');

        if ($user && $user->level === $level) {
            return $next($request);
        }

        return redirect()->route('login');
    }
}
