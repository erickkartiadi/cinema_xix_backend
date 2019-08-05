<?php

namespace App\Http\Controllers;

use App\Studio;
use App\Branch;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    public function __construct(){
        $this->middleware('validate:studio',['except'=>['index','destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $studios = Studio::all();
        $results = array();
        foreach($studios as $studio){
            $studio['branch_name'] = $studio->branch->name;
            $studio->makeHidden('branch');
            array_push($results,$studio);
        }

        return response()->json(['body' => $results],200);
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

        $studio = new Studio;
        $branch_id = $request->branch_id;
        $studio->name = $request->name;
        $studio->basic_price = $request->basic_price;
        $studio->additional_friday_price = $request->additional_friday_price;
        $studio->additional_saturday_price = $request->additional_saturday_price;
        $studio->additional_sunday_price = $request->additional_sunday_price;

        Branch::find($branch_id)->studios()->save($studio);
        return response()->json(['message'=>'create studio success'],200);
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
        $studio = Studio::find($id);
        $studio->name = $request->name;
        $studio->basic_price = $request->basic_price;
        $studio->additional_friday_price = $request->additional_friday_price;
        $studio->additional_saturday_price = $request->additional_saturday_price;
        $studio->additional_sunday_price = $request->additional_sunday_price;

        $studio->save();
        return response()->json(['message'=>'update studio success'],200);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $studio = Studio::find($id);
        $studio->delete();
    }
}
