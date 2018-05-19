<?php

namespace App\Http\Requests\Membership;

use App\Models\Membership;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if(Auth::user()->can('create', Membership::class) ||
           Auth::user()->id == $this->user_id)
           return true;
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $model = new Membership();
        return $model->modelRules('store');
    }
}
