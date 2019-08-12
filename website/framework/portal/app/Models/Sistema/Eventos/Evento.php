<?php

namespace App\Models\Sistema\Eventos;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;

class Evento extends Model
{
    protected $fillable = ['nome', 'descricao', 'data_inicio', 'data_fim', 
                           'liberar_certificados', 'data_limite_inscricoes', 'ativo', 'imagem_id'];

    public function imagem()
    {
        return $this->hasOne(Imagem::class);
    }
}
