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

//Route::post('signup', 'Api\UserController@store');
Route::post('login', 'Api\Auth\AuthController@login');

Route::group(['middleware' => 'jwt.auth'], function(){
  Route::get('auth/user', 'AuthController@user');
  Route::post('auth/logout', 'Api\Auth\AuthController@logout');
  Route::post('auth/refresh', 'Api\Auth\AuthController@refresh');

  Route::resource('user', 'Api\User\UserController', ['except' => ['edit', 'create']]);
});
