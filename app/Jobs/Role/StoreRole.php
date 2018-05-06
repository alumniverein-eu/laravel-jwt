<?php

namespace App\Jobs\Role;

use App\Models\Role;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreRole implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request, $role;

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
     public function handle(Role $role)
     {
         $this->role = $role->create($this->request);
     }
}
