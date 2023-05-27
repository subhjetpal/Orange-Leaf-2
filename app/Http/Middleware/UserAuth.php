<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $page=array('login','index','/');
        if($request->path()=="login" && $request->session()->has('user')){
            return redirect('/home');
        }
        if(!$request->session()->has('user') && !in_array($request->path(), $page)){
            return redirect('/login');
        }
        return $next($request);
    }
}
