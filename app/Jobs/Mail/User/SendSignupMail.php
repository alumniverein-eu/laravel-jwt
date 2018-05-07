<?php

namespace App\Jobs\Mail\User;

use App\Models\User;
use Log;
use Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendSignupMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::send('email.user.signupmail', [ 'user' => $this->user ], function ($message) {
            $message->from('dev@alumniverein.eu', 'Dev Team');
            $mail = $this->user->email;
            $message->to($mail);
        });
        Log::info("Mail to new user ".$this->user->name. " send! (".$this->user->email.")");
    }
}
