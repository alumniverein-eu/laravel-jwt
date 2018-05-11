<?php

namespace App\Http\Requests\Role;

use App\Models\Role;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UserAttachRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('manage', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'user' => 'required|exists:users,id|unique:roles_users,user_id,NULL,id,role_id,'.$this->role,
            'role' => 'required|exists:roles,id|unique:roles_users,role_id,NULL,id,user_id,'.$this->user,
            'incepts' => 'sometimes|date_format:"Y-m-d H:i:s"',
            'expires' => 'sometimes|date_format:"Y-m-d H:i:s"',
        ];
    }
}
