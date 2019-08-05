<?php

namespace App\Http\Middleware;

use Closure;
use App\LoginToken;

class Authorization
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

        $check = LoginToken::where('token',$request->header('token'))->first();
        if(!$check){
            return response()->json(['message'=>'unauthorized user'],401);
        }
        return $next($request);
    }
}
