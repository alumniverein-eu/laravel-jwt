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
            return response(['message'=>'Invalid Credentials'])
                    ->setStatusCode(401);
        }
        return response(['message'=>$token])
                ->setStatusCode(200);
    }

    /**
      * Logout the current user
      *
      * @return response
      */
    public function logout()
    {
        $response = JWTAuth::invalidate();
        return response(['message'=>$response])
                ->setStatusCode(200);
    }

    /**
      * Login attempt
      *
      * @return response
      */
    public function refresh()
    {
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return response($newToken)
                  ->setStatusCode(200);
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
            return response(null)
                    ->setStatusCode(201);
        } else {
            return response(null)
                    ->setStatusCode(403);
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
        $user = Auth::user();
        return response($user)
                ->setStatusCode(200);
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
            return response(null)
                    ->setStatusCode(200);
        } else {
            return response(null)
                    ->setStatusCode(401);
        }

    }

    /**
      * Check
      *
      * @var Request $request
      *
      * @return response
      */
    public function checkName(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|unique:users|min:3'
        ]);
        if($validatedData){
            return response(null)
                    ->setStatusCode(200);
        } else {
            return response(null)
                    ->setStatusCode(500);
        }
    }

    /**
      * Check
      *
      * @var Request $request
      *
      * @return response
      */
    public function checkMail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'required|email|unique:users'
        ]);
        if($validatedData){
            return response(null)
                    ->setStatusCode(200);
        } else {
            return response(null)
                    ->setStatusCode(500);
        }
    }
}
