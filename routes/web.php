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
    Route::get('/manage_cities', 'AdminController@manage_cities')->name('home.manage_cities');
    Route::get('/manage_types', 'AdminController@manage_types')->name('home.manage_types');
    Route::get('/manage_models', 'AdminController@manage_models')->name('home.manage_models');

	Route::post('/store_cities', 'AdminController@store_cities')->name('save_cities');	
	
	Route::delete('/destroy_cities/{id}', 'AdminController@destroy_cities');

	Route::post('/manage_cities', 'AdminController@manage_cities')->name('manage_cities');
	Route::get('/edit_cities/{id}', 'AdminController@edit_cities')->name('edit_cities');

    Route::group(['middleware' => ['guest']], function() {       
        Route::get('/login', 'AdminController@show')->name('login.show');
        Route::post('/login', 'AdminController@login')->name('login.perform');

    });

    Route::group(['middleware' => ['auth']], function() {    
        Route::get('/logout', 'LogoutController@perform')->name('logout.perform');
    });
});


