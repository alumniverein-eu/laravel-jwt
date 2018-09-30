<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\Resource;

class UsersWithRelationsResource extends Resource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'firstname' => $this->firstname,
            'lastname' => $this->lastname,
            'profileImageLink' => $this->profile_image ? 'api/images/profile/' . $this->id : 'api/images/profile/',
            'membership' => $this->membership ? $this->membership : null
        ];
    }
}
