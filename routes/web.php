<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Route::get('/', function () {
    // return view('welcome');
// });


Route::group(['namespace' => 'App\Http\Controllers'], function()
{   
    Route::get('/', 'AdminController@index')->name('home.index');
    Route::get('/manage_cities', 'AdminController@manage_cities')->name('manage_cities');
	Route::post('/store_cities', 'AdminController@store_cities')->name('save_cities');	
	Route::get('/changeStatus', 'AdminController@changeStatus')->name('changeStatus');		
	Route::delete('/destroy_cities/{id}', 'AdminController@destroy_cities');
	Route::get('/edit_cities/{id}', 'AdminController@edit_cities')->name('edit_cities');
	
	Route::post('/save_vehical_types', 'AdminController@save_vehical_types')->name('save_vehical_types');	
	Route::get('/manage_vehical_types', 'AdminController@manage_vehical_types')->name('manage_vehical_types');
	Route::delete('/destroy_vehical_types/{id}', 'AdminController@destroy_vehical_types');
	Route::get('/edit_vehical_types/{id}', 'AdminController@edit_vehical_types')->name('edit_vehical_types');
	
	
	Route::get('/manage_vehical_models', 'AdminController@manage_vehical_models')->name('manage_vehical_models');
	Route::post('/save_models', 'AdminController@save_models')->name('save_models');	
	Route::delete('/destroy_models/{id}', 'AdminController@destroy_models');
	Route::get('/edit_models/{id}', 'AdminController@edit_models')->name('edit_models');

    Route::group(['middleware' => ['guest']], function() {       
        Route::get('/login', 'AdminController@show')->name('login.show');
        Route::post('/login', 'AdminController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {    
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});


