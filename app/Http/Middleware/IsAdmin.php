<?php
/**
 * Created by PhpStorm.
 * User: s112
 * Date: 05.06.19
 * Time: 19:39
 */


namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return mixed
     */
    public function handle($request, $next)
    {
        if (Auth::check() && Auth::user()->admin == 1)
            return $next($request);
        else
            return abort(404);
    }
}