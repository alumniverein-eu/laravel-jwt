<?php

namespace App\Http\Requests\User;

//use StoreUserRequest;
use Illuminate\Support\Facades\Auth;
use JWTAuth;

class SignupUserRequest extends StoreUserRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(!JWTAuth::getToken()){ //Logged in user cannot perform this action
            return true;
        } else {
            return false;
        }
    }

    /**
     * Get the rules() from StoreUserRequest!
     */
}
