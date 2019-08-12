<?php

namespace App\Models\Sistema\Vestibular;

use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;
use App\Models\Sistema\Gerenciamento\Arquivos\Arquivo;

class Vestibular extends Model
{
    protected $table = 'vestibulares';

    protected $fillable = ['conteudo','valor_inscricao','data_inicio','data_fim',
                           'data_exibicao','imagem_id'];

    public function imagem()
    {
        return $this->hasOne(Imagem::class);
    }

    public function arquivos()
    {
        return $this->belongsToMany(Arquivo::clas);
    }
}
