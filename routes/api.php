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

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group(['middleware' => 'jwt.auth'], function(){
  //auth routes
  Route::get('auth/user', 'Api\Auth\AuthController@user');
  Route::post('auth/logout', 'Api\Auth\AuthController@logout');
  Route::get('auth/check', 'Api\Auth\AuthController@check');
  //Route::post('auth/refresh', 'Api\Auth\AuthController@refresh');

  //user routes
  Route::resource('user', 'Api\User\UserController', ['except' => ['edit', 'create']]);

  //role routes
  Route::resource('role', 'Api\Role\RoleController', ['except' => ['edit', 'create']]);
  Route::group(['prefix' => 'role'], function (){
      Route::post('attach', 'Api\Role\RoleController@attachToUser');
      Route::post('detach', 'Api\Role\RoleController@detachFromUser');
  });

  //membership routes
  Route::resource('membership', 'Api\Membership\MembershipController', ['except' => ['edit', 'create']]);

});

//routes without jwt
Route::post('login',  'Api\Auth\AuthController@login');
Route::post('signup', 'Api\Auth\AuthController@signup');
Route::post('sgnp/checkname', 'Api\Auth\AuthController@checkName');
Route::post('sgnp/checkmail', 'Api\Auth\AuthController@checkMail');
