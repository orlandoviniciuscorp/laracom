<?php

namespace App\Http\Middleware;

use Closure;

class VerifyCityShop
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
        $session = app()->get('session');

        if(!$session->has('shop_type')){
            return redirect()->route('home.selections');
        }

        return $next($request);

    }
}
