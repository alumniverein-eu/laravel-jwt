<?php

namespace App\Jobs\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use App\Models\User;
use App\Models\Role;

class DetachRole implements ShouldQueue
{
    protected $request, $acting_user;

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

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

        $affected_user->roles()->detach($role->id);
    }
}
