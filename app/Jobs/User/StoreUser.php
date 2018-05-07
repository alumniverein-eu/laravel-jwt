<?php

namespace App\Jobs\User;

use App\Models\User;
use App\Jobs\Mail\User\SendSignupMail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class StoreUser implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $request, $user;

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
    public function handle(User $user)
    {
        $this->user = $user->create($this->request);
        dispatch(new SendSignupMail($this->user));
    }
}
