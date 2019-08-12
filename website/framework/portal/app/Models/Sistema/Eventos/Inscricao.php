<?php

namespace App\Models\Sistema\Eventos;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;

class Inscricao extends Model
{
    protected $table = 'inscricoes';

    protected $fillable = ['user_id', 'subevento_id', 'liberar_certificado'];

    /** Relacionamentos entre classes */

    //Relacionamento NxN
    public function users()
    {
        return $this->belongsToMany(User::class);
    }
}
