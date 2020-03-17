<?php

namespace App\Models\Sistema\Paginas;

use App\Models\Acl\Perfil;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Arquivos\Arquivo;

class Pagina extends Model
{
    protected $fillable = ['conteudo', 'parametro_rota'];

    /** Relacionamentos entre classes */

    //Relacionamento NxN
    public function perfis()
    {
        return $this->belongsToMany(Perfil::class);
    }

    public function arquivos()
    {
        return $this->belongsToMany(Arquivo::class, 'arquivo_pagina', 'pagina_id', 'arquivo_id')->withTimestamps();
    }
}
