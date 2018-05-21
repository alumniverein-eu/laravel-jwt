<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignupUserRequest;

use JWTAuth;
use Auth;

use App\Jobs\User\StoreUser;

class AuthController extends Controller
{
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
            return response(['message'=>'Invalid Credentials'], 401);
        }
        return response($token, 200);
    }

    /**
      * Logout the current user
      *
      * @return response
      */
    public function logout()
    {
        $response = JWTAuth::invalidate();
        return response($response, 200);
    }

    /**
      * Refresh attempt
      *
      * @return response
      */
    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return response($newToken, 200);
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function signup(SignupUserRequest $request)
    {
        if (!JWTAuth::getToken()) { //Logged in user cannot perform this action
            dispatch(new StoreUser($request->all()));
            return response(NULL, 202);
        } else {
            return response(NULL,403);
        }
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
        $response = Auth::user();
        return response($response, 200);
    }

    /**
      * Check
      *
      * @var Request $request
      *
      * @return response
      */
    public function check(Request $request)
    {
        if(Auth::user()){
            return response(NULL, 200);
        } else {
            return response(NULL, 401);
        }

    }
}
