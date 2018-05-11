<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\User;
use App\Models\Role;

class AttachRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request, $acting_user;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $acting_user, Array $request)
    {
        $this->acting_user = $acting_user;
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $affected_user = User::FindOrFail($this->request['user']);
        $role = Role::FindOrFail($this->request['role']);
        $inception = (isset($this->request['incepts']) ? $this->request['incepts'] : null );
        $expiration = (isset($this->request['expires']) ? $this->request['expires'] : null );

        $affected_user->roles()->attach($role->id, [
          'incepts_at' => $inception,
          'expires_at' => $expiration,
        ]);
    }
}
