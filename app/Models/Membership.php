<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use User;

class Membership extends Model
{
    protected $fillable = [
        'amount', 'project', 'start_at', 'end_at', 'end_reason',
    ];

    protected $casts = [
        'permissions' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
