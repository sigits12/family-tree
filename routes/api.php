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
Route::group(['namespace' => 'Api'], function () {
	Route::get('anggota', 'AnggotaController@index');
	Route::post('anggota', 'AnggotaController@store');
	Route::get('anggota/{id}', 'AnggotaController@show');
	Route::put('anggota/{id}', 'AnggotaController@update');
	Route::delete('anggota/{id}', 'AnggotaController@destroy');
});