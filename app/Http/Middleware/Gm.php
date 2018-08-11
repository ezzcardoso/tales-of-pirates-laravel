<?php

namespace App\Http\Middleware;

use Closure;

class Gm
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
        if (\Auth::check()) {
            if (\Auth::user()->gm == \App\User::ADMINISTRATOR) {

                return $next($request);

            }
        }
        return redirect('home');
    }
}
