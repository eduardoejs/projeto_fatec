<?php

namespace App\Observers;

use App\Events\NovoUsuario;
use App\Models\Acl\User;

class UserObserver
{
    /**
     * Handle the user "created" event.
     *
     * @param  \App\Models\Acl\User  $user
     * @return void
     */
    public function created(User $user)
    {
        event(new NovoUsuario($user));
    }

    /**
     * Handle the user "updated" event.
     *
     * @param  \App\Models\Acl\User  $user
     * @return void
     */
    public function updated(User $user)
    {
        if($user->token_create != null){
            $user->update(['token_create' => null]);
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param  \App\Models\Acl\User  $user
     * @return void
     */
    public function deleted(User $user)
    {
        //
    }

    /**
     * Handle the user "restored" event.
     *
     * @param  \App\Models\Acl\User  $user
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param  \App\Models\Acl\User  $user
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}
