<?php

namespace App\Http\Requests\Role;

use App\Models\Role;
use Illuminate\Validation\Rule;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateRoleRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update', Role::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $role_id = $this->route()->parameter('role')->getKey();
        return [
            'name' => 'string|min:3|max:24|unique:roles,name,' . $role_id . ',id',
            'slug' => 'string|min:3|max:18|unique:roles,slug,' . $role_id . ',id',
        ];
    }
}
