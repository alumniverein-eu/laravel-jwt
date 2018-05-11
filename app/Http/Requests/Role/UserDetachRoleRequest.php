<?php

namespace App\Http\Requests\Role;

<<<<<<< HEAD
use App\Models\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
=======
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
>>>>>>> ebfff5f27486d8972890dfdbcc1114f9fd64bd55

class UserDetachRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
<<<<<<< HEAD
        return Auth::user()->can('manage', Role::class);
=======
        return true;
>>>>>>> ebfff5f27486d8972890dfdbcc1114f9fd64bd55
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required|exists:roles_users,user_id,role_id,'.$this->role,
            'role' => 'required|exists:roles_users,role_id,user_id,'.$this->user,
        ];
    }
}
