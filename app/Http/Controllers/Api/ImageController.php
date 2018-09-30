<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Response;
Use DB;

use App\Models\User;

class ImageController extends Controller
{
    public function userProfileImage(User $user = null){
        if($user) {
          $path = public_path().'/userfiles/user' . $user->id . '/' . $user->profile_image;
        } else {
          $path = public_path().'/userfiles/default/default.png';
        }
        return Response::download($path);
    }
}
