<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Membership;
use Illuminate\Auth\Access\HandlesAuthorization;

class MembershipPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of all memberships.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasAccess(['manage-membership','global-membership']);
    }

    /**
     * Determine whether the user can view the membership.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership $membership
     * @return mixed
     */
    public function view(User $user, Membership $membership)
    {
        //user can only see their own membership unless they hold global permissions on Membership
        if($user->hasAccess(['global-membership']) || $user->membership() == $membership){
            return true;
        }
        return false;
    }

    /**
     * Determine whether the user can create roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['global-membership']);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership $membership
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAccess(['global-membership']);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Membership $membership
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAccess(['global-membership']);
    }
}
