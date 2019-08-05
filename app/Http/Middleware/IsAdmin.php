<?php

namespace App\Http\Middleware;
use App\LoginToken;

use Closure;

class IsAdmin
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
        $user =  LoginToken::where('token',$request->header('token'))->first()->user;
        if($user->role == "admin"){
            return $next($request);
        }
        return response()->json(['message'=>'forbidden user access'],403);
    }
}
