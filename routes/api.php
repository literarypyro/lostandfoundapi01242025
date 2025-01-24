<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
/*

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
*/
Route::group(['middleware' => ['cors']], function () {
    // ...
//	Route::post('/login',['as'=>'post', 'uses'=>'AuthController@loginUser'])->name('login.api');



	Route::post('/new_user',['as'=>'post', 'uses'=>'AuthController@registerUser'])->name('register.api');
	
	Route::post('/register/{id}/profile',['as'=>'post', 'uses'=>'AuthController@addUserProfile']);
	Route::post('/register/{id}/address',['as'=>'post', 'uses'=>'AuthController@addUserAddress']);
	Route::post('/register/{id}/contact',['as'=>'post', 'uses'=>'AuthController@addUserContact']);

});
//	Route::get('/items/searchlist/{search_type}/{search_term}/list', ['as' => 'request', 'uses' => 'FoundItemController@search']);
	Route::get('/items/searchrange/{search_type}/{search_term}/range/{daterange}/range', ['as' => 'request', 'uses' => 'FoundItemController@search']);
	Route::get('/items/{search_type}', ['as' => 'request', 'uses' => 'FoundItemController@search']);
	Route::get('/item/{id}', ['as' => 'request', 'uses' => 'FoundItemController@retrieveItem']);
	Route::get('/item/{id}/status', ['as' => 'request', 'uses' => 'FoundItemController@status']);
	Route::get('/item/{id}/status/{latest}', ['as' => 'request', 'uses' => 'FoundItemController@status']);



	Route::post('/login',['as'=>'post', 'uses'=>'AuthController@loginUser']);
	//Route::post('/register',['as'=>'post', 'uses'=>'AuthController@registerUser'])->name('register.api');
	Route::post('/new_user',['as'=>'post', 'uses'=>'AuthController@registerUser'])->name('register.api');

Route::middleware('auth:api')->group(function () {
    // our routes to be protected will go in here
	Route::get('/logout',['as'=>'get', 'uses'=>'AuthController@logoutUser'])->name('logout.api');
	Route::get('/item/{id}/remove', ['as' => 'request', 'uses' => 'FoundItemController@removeItem']);
	Route::put('/item_put', ['as' => 'post', 'uses' => 'FoundItemController@addItem']);	
	

	
});
