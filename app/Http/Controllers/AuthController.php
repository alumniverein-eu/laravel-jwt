<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;
use JWTAuth;
use App\User;
use Auth;

class AuthController extends Controller
{

  /**
    * Register a new user.
    *
    * @var RegisterFormRequest $request
    *
    * @return response
    */
  public function register(RegisterFormRequest $request)
  {
    $user = new User;
    $user->email = $request->email;
    $user->name = $request->name;
    $user->password = bcrypt($request->password);
    $user->save();
    return response([
        'status' => 'success',
        'data' => $user
       ], 200);
  }

  /**
    * Login attempt
    *
    * @var Request $request
    *
    * @return response
    */
  public function login(Request $request)
  {
      $credentials = $request->only('email', 'password');
      if ( ! $token = JWTAuth::attempt($credentials)) {
              return response([
                  'status' => 'error',
                  'error' => 'invalid.credentials',
                  'msg' => 'Invalid Credentials.'
              ], 400);
      }
      return response([
              'status' => 'success',
              'token' => $token
          ]);
  }

  /**
    * Return data of the current logged-in user
    *
    * @var Request $request
    *
    * @return response
    */
  public function user(Request $request)
  {
      $user = User::find(Auth::user()->id);
      return response([
              'status' => 'success',
              'data' => $user
          ]);
  }

  /**
    * Logout the current user
    *
    * @return response
    */
  public function logout()
  {
      JWTAuth::invalidate();
      return response([
              'status' => 'success',
              'msg' => 'Logged out Successfully.'
          ], 200);
  }

  /**
    * Login attempt
    *
    * @return response
    */
  public function refresh()
  {
      return response([
       'status' => 'success'
      ]);
  }
}
