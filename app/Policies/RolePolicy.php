<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Role;
use Illuminate\Auth\Access\HandlesAuthorization;

class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the list of all roles.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function index(User $user)
    {
        return $user->hasAccess(['global-role']);
    }

    /**
     * Determine whether the user can view the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function view(User $user, Role $role)
    {
        //user can only see their own role unless they hold global permissions on Role
        if($user->hasAccess(['global-role']) || $user->inRole($role->slug)){
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
        return $user->hasAccess(['global-role']);
    }

    /**
     * Determine whether the user can update the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function update(User $user)
    {
        return $user->hasAccess(['global-role']);
    }

    /**
     * Determine whether the user can delete the role.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Role  $role
     * @return mixed
     */
    public function delete(User $user)
    {
        return $user->hasAccess(['global-role']);
    }

    /**
     * Determine whether the user can associate a role.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function associate(User $user)
    {
        return $user->hasAccess(['global-role']);
    }
}
