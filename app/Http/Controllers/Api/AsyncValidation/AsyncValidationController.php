<?php

namespace App\Http\Controllers\Api\AsyncValidation;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ValidationController extends Controller
{
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
            return response(NULL, 200);
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
