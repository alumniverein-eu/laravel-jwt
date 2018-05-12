<?php

namespace App\Jobs\Membership;

use App\Models\Membership;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class UpdateMembership implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request, $membership;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Membership $membership, Array $request)
    {
        $this->request = $request;
        $this->membership = $membership;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->membership->update($this->request);
    }
}
