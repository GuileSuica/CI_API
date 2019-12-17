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

Route::namespace('Api')->name('api.')->group(function(){
	Route::prefix('sensor')->group(function(){
		Route::get('/', 'SensorController@index')->name('index_sensors');
		Route::get('/{id}', 'SensorController@show')->name('single_sensors');
		Route::post('/', 'SensorController@store')->name('store_sensors');
		Route::put('/{id}', 'SensorController@update')->name('update_sensors');
		Route::delete('/{id}', 'SensorController@delete')->name('delete_sensors');
    });

    Route::prefix('medicao')->group(function(){
        Route::get('/medicao', 'MedicaoController@show')->name('get_medicao');
        //Route::post('/medicao', 'MedicaoController')->name('store_medicao');
        //Route::get('/medicao/{id}', 'MedicaoController')->name('single_medicao');
        //Route::put('/medicao/{id}', 'MedicaoController@update')->name('update_medicao');
        //Route::delete('/medicao/{id}', 'MedicaoController@delete')->name('delete_medicao');
    });
});
