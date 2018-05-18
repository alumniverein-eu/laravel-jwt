<?php

namespace App\Http\Controllers\Api\Membership;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Config;

use App\Http\Requests\Membership\StoreMembershipRequest;
use App\Http\Requests\Membership\UpdateMembershipRequest;

use App\Models\Membership;
use App\Jobs\Membership\StoreMembership;
use App\Jobs\Membership\UpdateMembership;
use App\Jobs\Membership\DestroyMembership;


class MembershipController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (Auth::user()->can('index', Membership::class)) {
          $response = Membership::paginate(Config::get('pagination.itemsPerPage'))
                        ->appends('paged', $request->input('paged'));
          return response($response)
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
    public function store(StoreMembershipRequest $request)
    {
        if (Auth::user()->can('create', Membership::class)
          || Auth::user()->id == $request->user_id) {
          dispatch(new StoreMembership($request->all()));
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
     * @param  App\Models\Membership  $membership
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
    public function update(UpdateMembershipRequest $request, Membership $membership)
    {
        if (Auth::user()->can('update', $membership)){
          dispatch(new UpdateMembership($membership, $request->all()));
          return response(Membership::find($membership->id))
                    ->setStatusCode(202);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Membership $membership)
    {
        if (Auth::user()->can('delete', $membership)){
          dispatch(new DestroyMembership($membership));
          return response(null)
                    ->setStatusCode(202);
        } else {
          return response(null)
                    ->setStatusCode(403);
        }
    }
}
