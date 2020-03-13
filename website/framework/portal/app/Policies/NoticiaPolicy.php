<?php

namespace App\Policies;

use App\Models\Acl\User;
use App\Models\Sistema\Noticias\Noticia;
use Illuminate\Auth\Access\HandlesAuthorization;

class NoticiaPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    //Verifica se o usuário é o dono da Noticia que será atualizada
    public function update(User $user, Noticia $noticia)
    {
        return $user->id === $noticia->user_id;
    }

    public function delete(User $user, Noticia $noticia)
    {
        return $user->id === $noticia->user_id;
    }

    public function uploads(User $user, Noticia $noticia)
    {
        return $user->id === $noticia->user_id;
    }
}
