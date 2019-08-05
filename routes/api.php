<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('v1/auth/login', 'UserController@login');

Route::group(['middleware' => 'authorization'], function () {
    Route::get('v1/auth/logout', 'UserController@logout');
    Route::get('v1/available-schedules','ScheduleController@all');
    Route::group(['middleware'=>'isAdmin'],function(){
        Route::resource('v1/branches', 'BranchController');
        Route::resource('v1/studios', 'StudioController');
        Route::resource('v1/movies','MovieController');
        Route::resource('v1/branches.studios.schedules','ScheduleController');

    });

});






