<?php

// use Illuminate\Http\Request;

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

//  Route::middleware('auth:api')->get('/user', function (Request $request) {
//      return $request->user();
//  });

 Route::group(['middleware' => ['cors']], function() {
    Route::get('eclaim/sep/{sep}', 'Api\ClaimSepController@index');
    Route::post('eclaim/create', 'Api\ClaimSepController@create');
    Route::put('eclaim/update/{no_reg}', 'Api\ClaimSepController@update');
    Route::delete('eclaim/delete/{no_reg}', 'Api\ClaimSepController@delete');
 });
