<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterFormRequest;

use App\User;

use JWTAuth;
use JWTAuthException;
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

  // $user = new User;
  // $user->email = $request->email;
  // $user->name = $request->name;
  // $user->password = bcrypt($request->password);
  // $user->save();
  // return response([
  //     'status' => 'success',
  //     'data' => $user
  //    ], 200);


}
