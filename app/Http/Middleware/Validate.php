<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Validator;

class Validate
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next,$type)
    {

        if($type == 'branch'){
            $rules = [
                'name' => 'required'
            ];
        }
        if($type == 'studio'){
            $rules = [
                'name' => 'required',
                'basic_price' => 'required|min:1|max:1000000',
                'additional_friday_price' => 'numeric|required|min:0|max:1000000',
                'additional_saturday_price' => 'numeric|required|min:0|max:1000000',
                'additional_sunday_price' => 'numeric|required|min:0|max:1000000'
            ];
        }
        if($type == 'movie'){
            $rules = [
                'name' => 'required',
                'minute_length' => 'required|numeric|min:1|max:999',
                'picture_url' => 'required'
            ];
        }
        if($type == 'schedule'){
            $rules = [
                'movie_id' => 'required',
                'start' => 'required',
            ];
        }
        $validate = Validator::make($request->all(),$rules);
        if($validate->fails()){
//            echo $validate->errors();
            return response()->json(['message'=>'invalid field'],422);
        }
        return $next($request);
    }
}
