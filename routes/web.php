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
    Route::get('/manage_users', 'AdminController@manage_users')->name('manage_users');
	
	
    Route::get('/manage_cities', 'AdminController@manage_cities')->name('manage_cities');
	Route::post('/store_cities', 'AdminController@store_cities')->name('save_cities');	
	Route::get('/changeStatus', 'AdminController@changeStatus')->name('changeStatus');		
	Route::get('/verify_user_via_link/{id}/{token}', 'AdminController@verify_user_via_link');		
	Route::delete('/destroy_cities/{id}', 'AdminController@destroy_cities');
	Route::get('/edit_cities/{id}', 'AdminController@edit_cities')->name('edit_cities');
	
	Route::post('/save_vehicle_types', 'AdminController@save_vehicle_types')->name('save_vehicle_types');	
	Route::get('/manage_vehicle_types', 'AdminController@manage_vehicle_types')->name('manage_vehicle_types');
	Route::delete('/destroy_vehicle_types/{id}', 'AdminController@destroy_vehicle_types');
	Route::get('/edit_vehicle_types/{id}', 'AdminController@edit_vehicle_types')->name('edit_vehicle_types');
	
	
	Route::get('/manage_vehicle_models', 'AdminController@manage_vehicle_models')->name('manage_vehicle_models');
	Route::post('/save_models', 'AdminController@save_models')->name('save_models');	
	Route::delete('/destroy_models/{id}', 'AdminController@destroy_models');
	Route::get('/edit_models/{id}', 'AdminController@edit_models')->name('edit_models');


	Route::get('/manage_vehicle_name', 'AdminController@manage_vehicle_name')->name('manage_vehicle_name');
	Route::post('/save_vehicle_name', 'AdminController@save_vehicle_name')->name('save_vehicle_name');	
	Route::delete('/destroy_vehicle_name/{id}', 'AdminController@destroy_vehicle_name');
	Route::get('/edit_vehicle_name/{id}', 'AdminController@edit_vehicle_name')->name('edit_vehicle_name');
 
    Route::group(['middleware' => ['guest']], function() {       
        Route::get('/login', 'AdminController@show')->name('login.show');
        Route::post('/login', 'AdminController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {    
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});


