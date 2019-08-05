<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Movie;

class MovieController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('validate:movie',['except'=>['index','destroy']]);
    }

    public function index()
    {
        $movie = Movie::all();
        return response()->json(['body' => $movie],200);
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
    public function store(Request $request)
    {


        $image = $request->file('picture_url');
        $extension = $image->getClientOriginalExtension();
        $filename = time().'_.'.$image->getClientOriginalExtension();
        $image->move('images',$filename);

        $movie = new Movie;
        $movie->name = $request->name;
        $movie->minute_length = $request->minute_length;
        $movie->picture_url = url('images/'.$filename);
        $movie->save();
        return response()->json(['message' => 'create movie success'],200);
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

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $image = $request->file('picture_url');
        $filename = time().$image->getClientOriginalExtension();
        $image->move('images',$filename);

        $movie = Movie::find($id);
        $movie->name = $request->name;
        $movie->minute_length = $request->minute_length;
        $movie->picture_url = url('images/'.$filename);
        $movie->save();
        return response()->json(['message' => 'update movie success'],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $image = Movie::find($id);
        $image->delete();
        return response()->json(['message'=>'delete movie success'],200);
    }
}
