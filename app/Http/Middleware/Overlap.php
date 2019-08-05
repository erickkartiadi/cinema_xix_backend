<?php

namespace App\Http\Middleware;

use App\Movie;
use App\Schedule;
use Carbon\Carbon;
use Closure;

class Overlap
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
        $movie_id = $request->movie_id;
        $movie = Movie::find($movie_id);
        $minute_length = $movie->minute_length;
        $start = $request->start;
        $end = Carbon::parse($start)->addMinute($minute_length)->format('Y-m-d H:i:s');

        $schedules = Schedule::all();
        foreach($schedules as $schedule){
            $start_time = Carbon::parse($schedule->start)->timestamp;
            $end_time = Carbon::parse($schedule->end)->timestamp;
            if(!(Carbon::parse($end)->timestamp <= $start_time or Carbon::parse($start)->timestamp >= $end_time)){
                return response()->json(['message'=>'schedule overlapped']);
            }
        }
        return $next($request);
    }
}
