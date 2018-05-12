<?php

namespace App\Http\Requests\Membership;

use App\Models\Membership;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UpdateMembershipRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::user()->can('update', Membership::findOrFail($this->membership->id));
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'amount' => 'required|numeric|nullable',
            'project' => 'sometimes|in:sbe,sbw,epd,none',
            'start_at' => 'sometimes|date|nullable',
            'end_at' => 'sometimes|date|nullable',
            'end_reason' => 'sometimes|string|max:200|nullable',
            'json' =>'sometimes|json|nullable',
            'type' =>'sometimes|in:active,passive',
        ];
    }
}
