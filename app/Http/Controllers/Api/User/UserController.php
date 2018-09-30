<?php

namespace App\Http\Controllers\Api\User;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Config;
use Image;
use Hash;
use File;

use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;

use App\Models\User;
use App\Jobs\User\StoreUser;
use App\Jobs\User\UpdateUser;
use App\Jobs\User\DestroyUser;

use App\Http\Resources\User\UsersWithRelationsResource;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('index', User::class)) {
            $response = User::paginate(Config::get('pagination.itemsPerPage'));
            $response = UsersWithRelationsResource::collection($response)
                        ->appends('paged', $request->input('paged'));
            return response($response, 200);
        } else {
            return response(NULL, 401);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreUserRequest $request)
    {
        if (Auth::user()->can('create', User::class)) {
            dispatch(new StoreUser($request->all()));
            return response(NULL, 202);
        } else {
            return response(NULL, 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        //$user->load('membership');
        //return response($user, 200);
        $response = new UsersWithRelationsResource($user);
        return response($response, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(User $user, UpdateUserRequest $request)
    {
        if (Auth::user()->can('update', $user)){
            dispatch(new UpdateUser($user, $request->except('profile_image')));

            if($request->hasFile('profile_image')){
                $this->storeProfileImage($user, $request->file('profile_image'));
        	} elseif ($request->profile_image == null){
                $this->removeProfileImage($user);
            }

            return response(NULL, 202);
        } else {
            return response(NULL, 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (Auth::user()->can('delete', $user)){
            dispatch(new DestroyUser($user));
            return response(NULL, 202);
        } else {
          return response(NULL, 401);
        }
    }

    private function storeProfileImage(User $user, $image){
        $store_path = '/userfiles/user' . $user->id . '/';
        $filename = 'p_' . base64_encode(Hash::make($user->id)) . '.png';
        //$filename = 'profile_' . $user->id . '.' . $image->getClientOriginalExtension();
        if($user->profile_image != NULL){
            if( File::exists(public_path($store_path . $user->profile_image)) ){
                // delete old image
                $this->removeProfileImage($user);
            }
            // save new version
            Image::make($image)->fit(300, 300)->encode('png', 100)->save( public_path($store_path . $filename) );
        } else {
            Image::make($image)->fit(300, 300)->encode('png', 100)->save( public_path($store_path . $filename) );
        }

        $user->profile_image = $filename;
        $user->save();
    }

    private function removeProfileImage(User $user){
        $store_path = '/userfiles/user' . $user->id . '/';
        $filename = $user->profile_image;
        if(File::exists( public_path($store_path . $filename) )){
            // delete image
            File::delete( public_path($store_path . $filename) );
            return true;
        }
        return false;
    }
}
