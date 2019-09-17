<?php

namespace App\Jobs;

use App\Models\Acl\User;
use Illuminate\Bus\Queueable;
use App\Mail\SendEmailToNewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SendEmailToNewUserJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $user;
    
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($user)
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
        Mail::to($this->user->email)->subject('Olaaaa')->send(new SendEmailToNewUser($this->user));
    }
}
