<?php

namespace App\Policies;

use App\Models\Acl\User;
use App\Models\Sistema\Avisos\Aviso;
use Illuminate\Auth\Access\HandlesAuthorization;

class AvisoPolicy
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

    //Verifica se o usuário é o dono da Aviso que será atualizada
    public function updateAviso(User $user, Aviso $aviso)
    {
        return $user->id === $aviso->user_id;
    }

    public function deleteAviso(User $user, Aviso $aviso)
    {
        return $user->id === $aviso->user_id;
    }    
}
