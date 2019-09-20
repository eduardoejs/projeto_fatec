<?php

namespace App\Listeners;

use App\Events\NovoUsuario;
use App\Mail\SendEmailToNewUser;
use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class EnviarEmailNovoUsuario
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  NovoUsuario  $event
     * @return void
     */
    public function handle(NovoUsuario $event)
    {
        Mail::to($event->user->email)->queue(new SendEmailToNewUser($event->user));
    }
}
