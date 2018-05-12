<?php

namespace App\Jobs\Membership;

use App\Models\Membership;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class DestroyMembership implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $membership;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->membership->delete();
    }
}
