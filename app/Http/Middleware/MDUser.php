<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Session;

class MDUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // return $next($request);

        // dd(Session::has('user'));
        if(!Session::has('tecnical'))
        {
            return redirect('/');
        }
        // dd($request->fullUrl());
        // if ($request->fullUrl() === url('/'))
        // {
        //     return redirect('court/start');
        // }
        $response = $next($request);
        return $response;
    }
}
