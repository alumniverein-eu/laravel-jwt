<?php

namespace App\Jobs\Membership;

use App\Models\Membership;
use App\Models\User;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreMembership implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request, $membership;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Array $request)
    {
        $this->request = $request;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(Membership $membership)
    {
        $membership = new Membership($this->request);
        $affected_user = User::FindOrFail($this->request['user_id']);
        $affected_user->membership()->save($membership);
    }
}
