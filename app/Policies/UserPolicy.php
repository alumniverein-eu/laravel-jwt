<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function index(User $user)
    {
        //if($user->hasAccess(['index-user']))
        return true;
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\User  $model
     * @return mixed
     */
    public function view(User $user, User $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     *
     * @param  \App\Models\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->hasAccess(['create-user', 'admin-user']);
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\User  $model
     * @return mixed
     */
    public function update(User $user, User $model)
    {
        if($user->hasAccess(['update-user', 'admin-user']) || $user->id == $model->id)
            return true;
        else
            return false;
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param  \App\Models\User  $user
     * @param  \App\App\Models\User  $model
     * @return mixed
     */
    public function delete(User $user, User $model)
    {
        return $user->hasAccess(['delete-user', 'admin-user']);
    }
}
