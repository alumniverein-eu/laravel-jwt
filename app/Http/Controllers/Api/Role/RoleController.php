<?php

namespace App\Http\Controllers\Api\Role;


use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Http\Requests\Role\StoreRoleRequest;
use App\Http\Requests\Role\UpdateRoleRequest;

use App\Models\Role;
use App\Jobs\Role\StoreRole;
use App\Jobs\Role\UpdateRole;
use App\Jobs\Role\DestroyRole;


class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Role::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRoleRequest $request)
    {
        if (Auth::user()->can('create', Role::class)) {
          dispatch(new StoreRole($request->all()));
          return response(null)
                    ->setStatusCode(201);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function show(Role $role)
    {
        return $role;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRoleRequest $request, Role $role)
    {
        if (Auth::user()->can('update', $role)){
          dispatch(new UpdateRole($role, $request->all()));
          return response(Role::find($role->id))
                    ->setStatusCode(202);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Role  $role
     * @return \Illuminate\Http\Response
     */
    public function destroy(Role $role)
    {
        if (Auth::user()->can('delete', $role)){
          dispatch(new DestroyRole($role));
          return response(null)
                    ->setStatusCode(202);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }
}
