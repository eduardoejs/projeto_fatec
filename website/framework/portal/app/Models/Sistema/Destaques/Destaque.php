<?php

namespace App\Models\Sistema\Destaques;

use App\Models\Acl\User;
use Illuminate\Database\Eloquent\Model;
use App\Models\Sistema\Gerenciamento\Imagens\Imagem;

class Destaque extends Model
{
    protected $fillable = ['titulo','conteudo','data_exibicao','link_url','ordem','user_id',
                            'imagem_id'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function imagem()
    {
        return $this->belongsTo(Imagem::class);
    }
}
