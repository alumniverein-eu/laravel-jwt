<?php

namespace App\Http\Controllers\Api\Membership;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

use App\Models\Membership;

class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (Auth::user()->can('index', Membership::class)) {
          return response(Membership::all())
                    ->setStatusCode(200);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Auth::user()->can('create', Membership::class)) {
          //dispatch(new StoreRole($request->all()));
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
     * @param  App\Models\Membership $membership
     * @return \Illuminate\Http\Response
     */
    public function show(Membership $membership)
    {
        if (Auth::user()->can('view', $membership)) {
          return response($membership)
                    ->setStatusCode(201);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  App\Models\Membership
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
