<?php

namespace App\Models\Sistema\Paginas;

use App\Models\Acl\Perfil;
use Illuminate\Database\Eloquent\Model;

class Pagina extends Model
{
    protected $fillable = ['conteudo', 'parametro_rota'];

    /** Relacionamentos entre classes */

    //Relacionamento NxN
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }
}
