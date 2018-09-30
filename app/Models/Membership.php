<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Membership extends Model
{
    /**
     * Returns models validation rules
     *
     * @param usage - determins the request type
     */
    public function modelRules($usage)
    {
        $rules = [
            'store' => [
                'user_id' => 'required|exists:users,id|unique:memberships,user_id',
                'amount' => 'required|numeric|nullable',
                'project' => 'sometimes|in:sbe,sbw,epd,none',
                'start_at' => 'sometimes|date|nullable',
                'end_at' => 'sometimes|date|nullable',
                'end_reason' => 'sometimes|string|max:200|nullable',
                'json' =>'sometimes|json|nullable',
                'type' =>'sometimes|in:active,passive',
                'street' => 'required|min:3',
                'city' => 'required|min:3',
                'postcode' => 'required|min:3',
            ],
            'update' => [
                'amount' => 'sometimes|numeric|nullable',
                'project' => 'sometimes|in:sbe,sbw,epd,none',
                'start_at' => 'sometimes|date|nullable',
                'end_at' => 'sometimes|date|nullable',
                'end_reason' => 'sometimes|string|max:200|nullable',
                'json' =>'sometimes|json|nullable',
                'type' =>'sometimes|in:active,passive',
                'street' => 'sometimes|min:3',
                'city' => 'sometimes|min:3',
                'postcode' => 'sometimes|min:3',
            ]
        ];
        return $rules[$usage];
    }

    protected $fillable = [
        'amount', 'project', 'start_at', 'end_at', 'end_reason',
        'street', 'city', 'postcode', 'json'
    ];

    protected $casts = [
        'json' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
