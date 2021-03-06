<?php

namespace App\Http\Controllers;

use App\Branch;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class BranchController extends Controller
{


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(){
        $this->middleware('validate:branch',['except'=>['index','destroy']]);
    }
    public function index()
    {
        $branch = Branch::all();
        return response()->json(['body'=>$branch]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

            $branch = new Branch;
            $branch->name = $request->name;
            $branch->save();
            return response()->json([
                'message' => 'create branch success'
                ]);


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
        $branch = Branch::find($id);
        $branch->name = $request->name;
        $branch->save();
        return response()->json([
            'message' => 'update branch success'
        ],200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $branch = Branch::find($id);
        $branch->delete();
        return response()->json([
            'message' => 'delete branch success'
        ],200);

    }
}
