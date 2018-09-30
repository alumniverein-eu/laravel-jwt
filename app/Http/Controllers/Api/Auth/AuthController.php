<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\User\SignupUserRequest;

use JWTAuth;
use Auth;

use App\Jobs\User\StoreUser;
use App\Http\Resources\User\UsersWithRelationsResource;

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
        return response(['data' => $token], 200);
    }

    /**
      * Logout the current user
      *
      * @return response
      */
    public function logout()
    {
        $response = JWTAuth::invalidate();
        return response(['data' => $response], 200);
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

        return response(['data' => $newToken], 200);
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
            return response(['data' => ['data' => NULL]], 202);
        } else {
            return response(['data' => NULL], 403);
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
        $response = new UsersWithRelationsResource(Auth::user());
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
            return response(['data' => true], 200);
        } else {
            return response(['data' => false], 401);
        }

    }
}
