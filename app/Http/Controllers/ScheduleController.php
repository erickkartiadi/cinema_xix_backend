<?php

namespace App\Http\Controllers;

use Faker\Provider\DateTime;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Schedule;
use App\Studio;
use App\Movie;

class ScheduleController extends Controller
{
    public function __construct(){
        $this->middleware('validate:schedule',['except'=>['destroy','index','all']]);
        $this->middleware('overlap',['except'=>['destroy','index','all']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $schedules = Schedule::all();
        $results = array();
        foreach($schedules as $schedule){
            $schedule['movie_name'] = $schedule->movie->name;
            $schedule['studio_name'] = $schedule->studio->name;
            $schedule['branch_name'] = $schedule->studio->branch->name;
            $schedule->makeHidden('movie');
            $schedule->makeHidden('studio');
            array_push($results,$schedule);
        }
        return $results;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request,$branch_id,$studio_id)
    {
        $studio = Studio::find($studio_id)->first();
        $basic_price = $studio->basic_price;
        $additional_friday_price = $studio->additional_friday_price;
        $additional_saturday_price = $studio->additional_saturday_price;
        $additional_sunday_price = $studio->additional_sunday_price;

        $movie_id = $request->movie_id;
        $movie = Movie::find($movie_id);
        $minute_length = $movie->minute_length;
        $start = $request->start;
        $end = Carbon::parse($start)->addMinute($minute_length)->format('Y-m-d H:i:s');
        $price = $basic_price;
        $dayofweek = Carbon::parse($start)->dayOfWeek;

        if($dayofweek == Carbon::FRIDAY){
            $price += $additional_friday_price;
        }
        if($dayofweek == Carbon::SATURDAY){
            $price += $additional_saturday_price;
        }
        if($dayofweek == Carbon::SUNDAY){
            $price += $additional_sunday_price;
        }
        $schedule = new Schedule;
        $schedule->movie_id = $movie_id;
        $schedule->start = $start;
        $schedule->end = $end;
        $schedule->price = $price;
        Studio::find($studio_id)->schedules()->save($schedule);
        return response()->json(['message'=>'create schedule success']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }
    public function update(Request $request,$branch_id,$studio_id, $id)
    {
        $price = Studio::find($studio_id)->basic_price;
        $additional_friday_price = Studio::find($studio_id)->additional_friday_price;
        $additional_saturday_price = Studio::find($studio_id)->additional_saturday_price;
        $additional_sunday_price = Studio::find($studio_id)->additional_sunday_price;

        $movie_id = $request->movie_id;
        $movie = Movie::find($movie_id);
        $start = $request->start;
        $minute_length = $movie->minute_length;
        $end = Carbon::parse($start)->addMinute($minute_length)->format("Y-m-d H:i:s");


        $dayOfWeek = Carbon::parse($start)->dayOfWeek;
        if($dayOfWeek == Carbon::FRIDAY){
            $price += $additional_friday_price;
        }
        if($dayOfWeek == Carbon::SATURDAY){
            $price+= $additional_saturday_price;
        }
        if($dayOfWeek == Carbon::SUNDAY){
            $price += $additional_sunday_price;
        }

        $schedule = Schedule::find($id);
        $schedule->movie_id = $request->movie_id;
        $schedule->start = $start;
        $schedule->end = $end;
        $schedule->price = $price;
        Studio::find($studio_id)->schedules()->save($schedule);
        return response()->json(['message'=>'update schedule success']);

    }
    public function destroy($branch_id,$studio_id,$id)
    {
        Schedule::find($id)->delete();
        return response()->json(['message'=>'delete schedule success'],200);
    }

    public function all(){
        $schedules = Schedule::groupBy('movie_id','price');
        return $schedules->get();
    }
}
