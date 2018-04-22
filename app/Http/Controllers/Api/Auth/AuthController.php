<?php

namespace App\Http\Controllers\Api\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use JWTAuth;
use Auth;

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
            return response([
                'status' => 'error',
                'error' => 'credentials',
                'msg' => 'Invalid Credentials.',
            ], 401);
        }
        return response([
            'status' => 'success',
            'token' => $token
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
        $token = JWTAuth::getToken();
        $newToken = JWTAuth::refresh($token);

        return response([
         'status' => 'success',
         'token' => $newToken
        ]);
    }
}
